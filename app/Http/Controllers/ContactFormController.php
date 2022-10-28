<?php

namespace App\Http\Controllers;

use App\Exports\ContactFormExport;
use App\Imports\ContactFormImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Hash;
use Auth;
use App\Enquiry;
use App\User;
use App\ContactForm;
use App\SellerDetails;
use App\Quotation;
use App\ProductStock;
use App\Product;
use App\Followup;
use App\FollowupCall;

class ContactFormController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function index(Request $request) {
	    
		if(auth()->user()->user_type=="admin"){
			$data = Followup:: where('follow_up_status', 1)->where('delete_status',1)->orderBy('id', 'DESC');
			$data2 = Followup::
				where('next_date', '=', date('Y-m-d'))
					->orWhere('next_date', '<=', date('Y-m-d'))
				->where('status_of_lead', '!=', 'Lost lead')
				->where('status_of_lead', '!=', 'Junk lead')
				->where('status_of_lead', '!=', 'Not qualified')
				->where('follow_up_status', 1)
				->where('delete_status', 1)->orderBy('id', 'DESC');
		}else{
			$data = Followup::whereHas('user', function($q){
                $q->where('user_id', auth()->user()->id);
            })->where('follow_up_status', 1)->where('delete_status', 1)->orderBy('id', 'DESC');
            
			$data2 = Followup::
			where('next_date', '=', date('Y-m-d'))
			->orWhere('next_date', '<=', date('Y-m-d'))
			->where('status_of_lead', '!=', 'Lost lead')
			->where('status_of_lead', '!=', 'Junk lead')
			->where('status_of_lead', '!=', 'Not qualified')
			->whereHas('user', function($q){
                $q->where('user_id', auth()->user()->id);
            })->where('follow_up_status', 1)->where('delete_status', 1)->orderBy('id', 'DESC');
		}
		
		
		 
		 
		 $condition_status_of_lead=[];
         $condition_source_of_lead=[];
		
	    $status_of_lead=explode(",",$request->status_of_lead);
        $source_of_lead=explode(",",$request->source_of_lead);
		
		if ($request->status_of_lead){
           foreach($status_of_lead as $status)
            {
                array_push($condition_status_of_lead,['status_of_lead'=>$status]);
            }
        }
        if ($request->source_of_lead){
           foreach($source_of_lead as $source)
            {
                array_push($condition_source_of_lead,['source_of_lead'=>$source]);
            }
        }
		
		
		
	   	$data=$data->where(function ($query) use ($condition_status_of_lead){
            foreach ($condition_status_of_lead as $key=>$value)
            {
                $query->orWhere($value);
            }
            })->where(function ($query) use ($condition_source_of_lead){
            foreach ($condition_source_of_lead as $key=>$value)
            {
                $query->orWhere($value);
            }
            })->with('reseller');
	   	
	   	
	   	 $last_to_date=$request->last_to_date;
		 $next_to_date=$request->next_to_date;
		
		if($request->last_to_date != null && $request->last_from_date != null){
		    
              $start_date       = $request->last_from_date;
              $end_date         = $request->last_to_date;
		    
		    
			$data = $data->whereBetween('last_date',array($start_date,$end_date));
		}
		
		
			if($request->next_to_date != null && $request->next_to_date != null){
			     $next_from_date       = $request->next_from_date;
                 $next_to_date         = $request->next_to_date;
			$data = $data->whereBetween('next_date',array($next_from_date,$next_to_date));
		}
		
		
		
		if ($request->has('search')){
            
            $sort_search = $request->search;
            $user_ids = User::where('user_type','!=', 'admin')->where(function($user) use ($sort_search){
                $user->where('name', 'like', '%'.$sort_search.'%')->orWhere('email', 'like', '%'.$sort_search.'%')->orWhere('phone', 'like', '%'.$sort_search.'%');
            })->pluck('id')->toArray();
                $data = $data->where(function($customer) use ($user_ids){
                $customer->whereIn('reseller_id', $user_ids);
            });
            
            
        }
        
        	if ($request->has('search_leads_today')){
            
            $sort_search = $request->search_leads_today;
            $user_ids = User::where('user_type','!=', 'admin')->where(function($user) use ($sort_search){
                $user->where('name', 'like', '%'.$sort_search.'%')->orWhere('email', 'like', '%'.$sort_search.'%')->orWhere('phone', 'like', '%'.$sort_search.'%');
            })->pluck('id')->toArray();
                $data2 = $data2->where(function($customer) use ($user_ids){
                $customer->whereIn('reseller_id', $user_ids);
            });
            
            
        }
        
		
		$data=$data->paginate(10);
		
		$data2=$data2->paginate(5);
		
		 if($request->ajax())
        {
            if($request->page_type=='today_leads'){
                return view('backend.crm.contact_form.table_today_leads', compact('data','data2'))->render();
            }
            if($request->page_type=='all_leads'){
           return view('backend.crm.contact_form.table_all_leads', compact('data','data2'))->render();
            }
        }
		
		
		return view('backend.crm.contact_form.index', compact('data', 'data2'));

	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		return view('backend.crm.contact_form.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		//return $request->all();
		
		$user = SellerDetails::where('phone1', $request->mobile1)->get();
		if(sizeof($user) > 0){
		    if(isset($request->variant)){
    			$qu_no = Quotation::latest('id')->first();
                if($qu_no==null){
                    $qu=1;
                }else{
                    $qu = ++$qu_no->quotation_number;
                }
                foreach ($request->variant as $key => $variant) {
                    $product = ProductStock::where('id', $variant)->first();
                    $quotation = new Quotation;
                    $quotation->user_id = $request->user_id;
                    $quotation->reseller_id = $request->reseller_id;
                    $quotation->quotation_number = $qu;
                    $quotation->variant_id = $variant;
                    $quotation->product_id = $product->product_id;
                    $quotation->base_price = $request->wholesale_unit[$key];
                    $quotation->wholesale_discount = $request->wholesale_discount[$key];
                    $quotation->wholesale_discount_type = $request->wholesale_discount_type[$key];
                    $quotation->wholesale_quintity = $request->wholesale_quintity[$key];
                    $quotation->type = $request->type[$key];
                    $quotation->wholesale_discount_price = $request->wholesale_discount_price[$key];
                    $quotation->courier_charge = $request->courier_charge;
                    $quotation->total = $request->total;
    				$quotation->follow_up_status = 1;
    				if($request->for_other == 1){
        			    $quotation->for_other = 1;
            			$quotation->other_phone = $request->other_phone;
            			$quotation->other_name = $request->other_name;
            			$quotation->other_email = $request->other_email;
        			}
                    $quotation->save();
                    
                }
			}
			$FollowupDetails = new Followup;
			$FollowupDetails->user_id = $request->user_id;
			$FollowupDetails->reseller_id = $request->reseller_id;
			if(isset($request->variant)){
			   $FollowupDetails->quotation_number = $quotation->quotation_number; 
			}
			$FollowupDetails->follow_up_status = 1;
			$FollowupDetails->remark = $request->remark;
			$FollowupDetails->last_date = $request->last_date;
			$FollowupDetails->next_date = $request->next_date;
			$FollowupDetails->next_time = $request->next_time;
			$FollowupDetails->status_of_lead = $request->status_of_lead;
			$FollowupDetails->source_of_lead = $request->source_of_lead;
			if($request->for_other == 1){
			    $FollowupDetails->for_other = 1;
    			$FollowupDetails->other_phone = $request->other_phone;
    			$FollowupDetails->other_name = $request->other_name;
    			$FollowupDetails->other_email = $request->other_email;
			}
			$FollowupDetails->save();
		}else{
		    
		    if(SellerDetails::where('phone1', $request->mobile1)->first() == null){
		        if(User::where('email', $request->email)->first() == null){
		            
                    $user = new User;
                    $user->add_by = $request->user_id;
                    $user->name = $request->name;
                    $user->email = $request->email;
                    $user->phone = $request->mobile1;
                    $user->user_type = $request->user_type;
                    $user->password = Hash::make($request->mobile1);
                    if($user->save()){
                        $SellerDetails = new SellerDetails;
                        $SellerDetails->user_id = $user->id;
                        $SellerDetails->phone1 = $request->mobile1;
                        $SellerDetails->save();
                    }
                    
                    if(isset($request->variant)){
            			$qu_no = Quotation::latest('id')->first();
                        if($qu_no==null){
                            $qu=1;
                        }else{
                            $qu = ++$qu_no->quotation_number;
                        }
                        foreach ($request->variant as $key => $variant) {
                            $product = ProductStock::where('id', $variant)->first();
                            $quotation = new Quotation;
                            $quotation->user_id = $request->user_id;
                            $quotation->reseller_id = $user->id;
                            $quotation->quotation_number = $qu;
                            $quotation->variant_id = $variant;
                            $quotation->product_id = $product->product_id;
                            $quotation->base_price = $request->wholesale_unit[$key];
                            $quotation->wholesale_discount = $request->wholesale_discount[$key];
                            $quotation->wholesale_discount_type = $request->wholesale_discount_type[$key];
                            $quotation->wholesale_quintity = $request->wholesale_quintity[$key];
                            $quotation->type = $request->type[$key];
                            $quotation->wholesale_discount_price = $request->wholesale_discount_price[$key];
                            $quotation->courier_charge = $request->courier_charge;
                            $quotation->total = $request->total;
            				$quotation->follow_up_status = 1;
            				if($request->for_other == 1){
                			    $quotation->for_other = 1;
                    			$quotation->other_phone = $request->other_phone;
                    			$quotation->other_name = $request->other_name;
                    			$quotation->other_email = $request->other_email;
                			}
                            $quotation->save();
                        }
    			    }
        			$FollowupDetails = new Followup;
        			$FollowupDetails->user_id = $request->user_id;
        			$FollowupDetails->reseller_id = $user->id;
        			if(isset($request->variant)){
        			   $FollowupDetails->quotation_number = $quotation->quotation_number; 
        			}
        			$FollowupDetails->follow_up_status = 1;
        			$FollowupDetails->remark = $request->remark;
        			$FollowupDetails->last_date = $request->last_date;
        			$FollowupDetails->next_date = $request->next_date;
        			$FollowupDetails->next_time = $request->next_time;
        			$FollowupDetails->status_of_lead = $request->status_of_lead;
        			$FollowupDetails->source_of_lead = $request->source_of_lead;
        			if($request->for_other == 1){
        			    $FollowupDetails->for_other = 1;
            			$FollowupDetails->other_phone = $request->other_phone;
            			$FollowupDetails->other_name = $request->other_name;
            			$FollowupDetails->other_email = $request->other_email;
        			}
    			    $FollowupDetails->save();
		        }else{
		            flash(translate('Email Exits'))->error();
                    return redirect()->back()->withInput();
		        }
            }
		}
        if($FollowupDetails->save()){
            flash(translate('Follow-Up has been generated successfully'))->success();
            return redirect()->route('contact.index');
        }
        else{
            flash(translate('Something went wrong'))->error();
            return back();
        }

		return redirect()->route('contact.index');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\ContactForm  $contactForm
	 * @return \Illuminate\Http\Response
	 */
	public function show(ContactForm $contactForm) {
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\ContactForm  $contactForm
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id) {

		$Followup = Followup::find($id);
		$Followup->viewed=0;
		$Followup->save();
		return view('backend.crm.contact_form.edit', compact('Followup'));

	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\ContactForm  $contactForm
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id) {

		if($request->convert_quotaion){
		    $Followup = Followup::where('id', $id)->first();
		    $quotations = Quotation::where('quotation_number', $Followup->quotation_number)->get();
		    foreach($quotations as $quotation) {
		        $quotation->business_name = $request->business_name;
			    $quotation->quotation_name = $request->quotation_name;
			    $quotation->date = $request->date;
				$quotation->follow_up_status = 0;
				$quotation -> save();
			}
		    $Followup -> follow_up_status = 2;
			$Followup -> save();
		    if($quotation -> save()){
				flash(translate('Quotation has been generated successfully'))->success();
				return redirect()->route('crm.allquotation');
			}
			
		}else{
		    
		    $Followup = Followup::where('id', $id)->first();
		    if(isset($request->variant)){
		        $qu_no = Quotation::latest('id')->first();
                if($qu_no==null){
                    $qu=1;
                }else{
                    $qu = ++$qu_no->quotation_number;
                }
                
                foreach ($request->variant as $key => $variant) {
                    $product = ProductStock::where('id', $variant)->first();
                    $quotation = new Quotation;
                    $quotation->user_id = $request->user_id;
                    $quotation->reseller_id = $request->reseller_id;
                    $quotation->quotation_number = $qu;
                    $quotation->variant_id = $variant;
                    $quotation->product_id = $product->product_id;
                    $quotation->base_price = $request->wholesale_unit[$key];
                    $quotation->wholesale_discount = $request->wholesale_discount[$key];
                    $quotation->wholesale_discount_type = $request->wholesale_discount_type[$key];
                    $quotation->wholesale_quintity = $request->wholesale_quintity[$key];
                    $quotation->type = $request->type[$key];
                    $quotation->wholesale_discount_price = $request->wholesale_discount_price[$key];
                    $quotation->courier_charge = $request->courier_charge;
                    $quotation->total = $request->total;
    				$quotation->follow_up_status = 1;
    				if($request->for_other == 1){
        			    $quotation->for_other = 1;
            			$quotation->other_phone = $request->other_phone;
            			$quotation->other_name = $request->other_name;
            			$quotation->other_email = $request->other_email;
            		}
                    $quotation->save();
                }
                $Followup->quotation_number = $quotation->quotation_number;
		    }
			
			$Followup->remark = $request->remark;
			$Followup->last_date = date('Y-m-d');
			$Followup->next_date = $request->next_date;
			$Followup->next_time = $request->next_time;
			$Followup->status_of_lead = $request->status_of_lead;
			$Followup->source_of_lead = $request->source_of_lead;
			if($request->for_other == 1){
			    $Followup->for_other = 1;
    			$Followup->other_phone = $request->other_phone;
    			$Followup->other_name = $request->other_name;
    			$Followup->other_email = $request->other_email;
			}
			
			$Followup -> save();
			if($Followup->save()){
				flash(translate('Follow-Up been updated successfully'))->success();
            	return redirect()->route('contact.edit', $id);
			}else{
				flash(translate('Something went wrong'))->error();
				return back();
			}
		}
		
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\ContactForm  $contactForm
	 * @return \Illuminate\Http\Response
	 */

	public function destroy($id)
    {
        if(Followup::destroy($id)){
            flash(translate('Data has been deleted successfully'))->success();
            return redirect()->route('contact.index');
        }

        flash(translate('Something went wrong'))->error();
        return back();
    }
    
    public function followup_delete($id){
        
        $var = Followup::where('id', $id)->update(array('delete_status' => 0));
        flash(translate('Data has been deleted successfully'))->success();
	    return back();
    }


	public function filter(Request $request) {
    
	if (!empty($request->status_of_lead) && !empty($request->source_of_lead)) {
			$data = SellerDetails::where('status_of_lead', $request->status_of_lead)
				->Where('source_of_lead', $request->source_of_lead)
				->with('user')->get();
		}else if (!empty($request->status_of_lead) || !empty($request->source_of_lead)) {
			$data = SellerDetails::where('status_of_lead', $request->status_of_lead)
				->orWhere('source_of_lead', $request->source_of_lead)
				->with('user')->get();
		}else if($request->last_from_date != '' && $request->last_to_date != ''){
			$data = SellerDetails::whereBetween('last_date',array($request->last_from_date, $request->last_to_date))->with('user')->get();
		}else if($request->next_from_date != '' && $request->next_to_date != ''){
			$data = SellerDetails::whereBetween('next_date',array($request->next_from_date, $request->next_to_date))->with('user')->get();
		}
		 else {
			$data = SellerDetails::with('user')->get();
		}

		return view('contact_form.index', compact('data'));

	}

	public function ajxfilter(Request $request) {
		
		 $conditions = ['delete_status' => 1];
		 
		 $status_of_lead=$request->status_of_lead;
		 $source_of_lead=$request->source_of_lead;
		 $last_from_date=$request->last_from_date;
		 $last_to_date=$request->last_to_date;
		 $next_from_date=$request->next_from_date;
		 $next_to_date=$request->next_to_date;
		
		if($status_of_lead!=null){
		    
		     $conditions = array_merge($conditions, ['status_of_lead' => $status_of_lead]);
		}
		
		if($source_of_lead!=null){
		    
		     $conditions = array_merge($conditions, ['source_of_lead' => $source_of_lead]);
		}
		
		
	   	$data=Followup::where($conditions)->with('reseller')->get();
		
		if($last_from_date != null && $last_to_date != null){
			$data = $data->whereBetween('last_date',array($last_from_date,$last_to_date));
		}
		
		
			if($next_from_date != null && $next_to_date != null){
			$data = $data->whereBetween('next_date',array($next_from_date,$next_to_date));
		}
		
		
		return response()->json(array('data' => $data), 200);
		
	}

	public function importview() {
		return view('backend.crm.contact_form.import');
	}
	
	
	

	public function export() {

		return Excel::download(new ContactFormExport, 'ContactData.xlsx');
	}
	
	
		public function view($id) {

		$followup = Followup::find($id);
		return view('backend.crm.contact_form.followup_calls.followup_calls', compact('followup'));

	}
	
	
	public function followup_call_save(Request $request){
	    
	    $followup_call=new FollowupCall;
	    $followup_call->followup_id=$request->id;
        $followup_call->last_date_of_contact=$request->last_date_of_contact;
        $followup_call->last_time_of_contact=$request->last_time_of_contact;
        $followup_call->next_date_of_contact=$request->next_date_of_contact;
        $followup_call->next_time_of_contact=$request->next_time_of_contact;
        $followup_call->lead_status=$request->lead_status;
        $followup_call->lead_source=$request->lead_source;
        $followup_call->remark=$request->remark;
        $followup_call->save();
        
        return 1;
	    
	    
	}
	
	 public function followup_call_ajax_pagination(Request $request)
    {
        
        $followup_calls=FollowupCall::where('followup_id',$request->id)->orderBy('id','desc')->paginate(3);
        if($request->ajax())
        {
           return view('backend.crm.contact_form.followup_calls.followup_call_table', compact('followup_calls'))->render();
        }
   
        
    }
    
     public function updateComplete(Request $request)
    {
        $followup = Followup::findOrFail($request->id);
        $followup->active = $request->status;
        if($followup->save()){
            return 1;
        }
        return 0;
    }
    
    public function enquiry(Request $request)
    {
        $enquiry = new Enquiry;
        $enquiry->product_id = $request->product_id;
        $enquiry->name = $request->name;
        $enquiry->phone = $request->phone;
        $enquiry->qntity = $request->qntity;
        $enquiry->remark = $request->remark;
        $enquiry->save();
        
        return redirect()->back()->with('success','Enquiry Inserted Succesfull');
    }
    
   public function enqiry_view() {

		$pro_enq = Enquiry::orderBy('id','desc')->paginate(5);
		return view('backend.enquiry.index', compact('pro_enq'));

	}
    
	
}
