<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SellerDetails;
use App\User;
use App\Quotation;
use App\Order;
use App\OrderDetail;
use App\Product;
use App\ProductStock;
use App\Address;
use Hash;
use Auth;
use DB;
use PDF;
use Validator;
use App\Followup;

class Crmcontroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {  
        // $list = SellerDetails::with('user')->get();
        // $add_by= $list[0]->user->add_by;
        $sort_search = null;
        if(auth()->user()->user_type=="admin"){
            $SellerDetails = SellerDetails::orderBy('id', 'DESC');
        }else{
            $SellerDetails = SellerDetails::whereHas('user', function($q){
                $q->where('add_by', auth()->user()->id);
            })->orderBy('id', 'DESC');
        }
        
         if ($request->has('search')){
            $sort_search = $request->search;
            $SellerDetails =  SellerDetails::select('users.name','users.email','users.phone','seller_details.*')->leftJoin('users', 'users.id', '=', 'seller_details.user_id')->where('users.name', 'like', '%'.$sort_search.'%')->orwhere('users.email', 'like', '%'.$sort_search.'%')->orwhere('users.phone', 'like', '%'.$sort_search)->orwhere('users.user_type', 'reseller')->where('users.user_type', 'wholesaler')->orderBy('id', 'DESC')->paginate(10);
           
             return view('backend.crm.index', compact('SellerDetails','sort_search'));
        }
        
        
        $SellerDetails = $SellerDetails->paginate(10);
        return view('backend.crm.index', compact('SellerDetails','sort_search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.crm.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //return $request->all();
        if(SellerDetails::where('phone1', $request->mobile1)->first() == null){
            if(User::where('email', $request->email)->first() == null){
                $user = new User;
                $user->add_by = $request->add_by;
                $user->name = $request->name;
                $user->email = $request->email;
                $user->phone = $request->mobile1;
                $user->user_type = $request->user_type;
                $user->password = Hash::make($request->mobile1);
                if($user->save()){
                    $SellerDetails = new SellerDetails;
                    $SellerDetails->user_id = $user->id;
                    $SellerDetails->phone1 = $request->mobile1;
                    $SellerDetails->phone2 = $request->mobile2;
                    $SellerDetails->whatsapp_number = $request->whatsapp_number;
                    $SellerDetails->gender = $request->gender;
                    $SellerDetails->dob = $request->dob;
                    $SellerDetails->profession = $request->profession;
                    $SellerDetails->contact_position = $request->contact_position;
                    $SellerDetails->website = $request->website;
                    $SellerDetails->street_address = $request->street_address;
                    $SellerDetails->city = $request->city;
                    $SellerDetails->state = $request->state;
                    $SellerDetails->country = $request->country;
                    $SellerDetails->pincode = $request->pincode;
                    $SellerDetails->delivery_address = $request->delivery_address;
                    $SellerDetails->facebook = $request->facebook;
                    $SellerDetails->instagram = $request->instagram;
                    $SellerDetails->twitter = $request->twitter;
                    $SellerDetails->anniversary = $request->anniversary;
                    $SellerDetails->business_name = $request->business_name;
                    $SellerDetails->tax_id_type = $request->tax_id_type;
                    $SellerDetails->tax_id = $request->tax_id;
                    if($SellerDetails->save()){
                        flash(translate('Data has been inserted successfully'))->success();
                        return redirect()->route('crm.index');
                    }
                }
            }else{
                flash(translate('Email already exists'))->error();
                return redirect()->back()->withInput();
            }
        }else{
            flash(translate('Phone number already exists'))->error();
            return redirect()->back()->withInput();
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $SellerDetails = SellerDetails::findOrFail(decrypt($id));
        return view('backend.crm.edit', compact('SellerDetails'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $SellerDetails = SellerDetails::findOrFail($id);
        $user = $SellerDetails->user;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->mobile1;
        $user->user_type = $request->user_type;
        $user->password = Hash::make($request->mobile1);
        if($user->save()){
            $SellerDetails->user_id = $user->id;
            $SellerDetails->phone1 = $request->mobile1;
            $SellerDetails->phone2 = $request->mobile2;
            $SellerDetails->whatsapp_number = $request->whatsapp_number;
            $SellerDetails->gender = $request->gender;
            $SellerDetails->dob = $request->dob;
            $SellerDetails->profession = $request->profession;
            $SellerDetails->contact_position = $request->contact_position;
            $SellerDetails->website = $request->website;
            $SellerDetails->street_address = $request->street_address;
            $SellerDetails->city = $request->city;
            $SellerDetails->state = $request->state;
            $SellerDetails->country = $request->country;
            $SellerDetails->pincode = $request->pincode;
            $SellerDetails->delivery_address = $request->delivery_address;
            $SellerDetails->facebook = $request->facebook;
            $SellerDetails->instagram = $request->instagram;
            $SellerDetails->twitter = $request->twitter;
            $SellerDetails->anniversary = $request->anniversary;
            $SellerDetails->business_name = $request->business_name;
            $SellerDetails->tax_id_type = $request->tax_id_type;
            $SellerDetails->tax_id = $request->tax_id;
            if($SellerDetails->save()){
                flash(translate('Data has been updated successfully'))->success();
                return redirect()->route('crm.index');
            }
        }

        flash(translate('Something went wrong'))->error();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::destroy(SellerDetails::findOrFail($id)->user->id);
        if(SellerDetails::destroy($id)){
            flash(translate('Staff Data has been deleted successfully'))->success();
            return redirect()->route('crm.index');
        }

        flash(translate('Something went wrong'))->error();
        return back();
    }

    public function quotation($id){
        $user = User::findOrFail(decrypt($id));
        return view('backend.crm.generate_quotation', compact('user'));
    }

    public function generate_quotation(Request $request){
        //return $request->all();
        $qu_no = Quotation::latest('id')->first();
        if($qu_no==null){
            $qu=1;
        }else{
            $qu = ++$qu_no->quotation_number;
        }
        
        //$products = $product;
        foreach ($request->variant as $key => $variant) {
            $product = ProductStock::where('id', $variant)->first();
            $quotation = new Quotation;
            $quotation->user_id = $request->user_id;
            $quotation->reseller_id = $request->reseller_id;
            $quotation->quotation_number = $qu;
            $quotation->business_name = $request->business_name;
            $quotation->quotation_name = $request->quotation_name;
            $quotation->date = $request->date;
            $quotation->variant_id = $variant;
            $quotation->product_id = $product->product_id;
            $quotation->base_price = $request->wholesale_unit[$key];
            $quotation->wholesale_discount = $request->wholesale_discount[$key];
            $quotation->wholesale_discount_type = $request->wholesale_discount_type[$key];
            $quotation->wholesale_quintity = $request->wholesale_quintity[$key];
            $quotation->wholesale_discount_price = $request->wholesale_discount_price[$key];
            $quotation->courier_charge = $request->courier_charge;
            $quotation->total = $request->total;
            $quotation->save();
        }
        if($quotation->save()){
            // $latest_qu = Quotation::latest('id')->first();
            // $quotation = Quotation::where('quotation_number', $quotation->quotation_number)->get();
            // flash(translate('Quotation has been generated successfully'))->success();
            // return view('backend.crm.view_generated_quotation', compact('quotation'));
            flash(translate('Quotation has been generated successfully'))->success();
            return redirect()->route('crm.allquotation');
        }
        else{
            flash(translate('Something went wrong'))->error();
            return back();
        }
    }

    public function allquotation(Request $request){  
        
        $sort_search = null;
        $date = null;
        if(auth()->user()->user_type=="admin"){
            $quotations = Quotation::where('follow_up_status', 0)->groupBy('quotation_number')->orderBy('id', 'DESC');
            //$quotation = Quotation::with('user')->with('reseller')->get();
        }else{
            $quotations = Quotation::whereHas('user', function($q){
                $q->where('user_id', auth()->user()->id);
            })->where('follow_up_status', 0)->groupBy('quotation_number')->orderBy('id', 'DESC');
        }
        if ($request->search||$request->date){
            $sort_search = $request->search;
            $date = $request->date;
           
            $quotations = Quotation::select('users.name','users.email','users.phone','quotations.*')->leftjoin('users','quotations.reseller_id','users.id')->where('quotations.follow_up_status', 0)->whereDate('quotations.new_date',$date)->orwhere('phone', $sort_search)->groupBy('quotation_number');
            
        }
        //return $quotation = Quotation::with('user')->with('reseller')->get();
        $quotations = $quotations->paginate(10);
        return view('backend.crm.allquotation', compact('quotations' , 'sort_search', 'date'));
    }

    public function viewquotation(Request $request, $quotation_number){
        
        $quotation = Quotation::where('quotation_number', decrypt($quotation_number))->get();
        // return $quotation;
        return view('backend.crm.view_generated_quotation', compact('quotation'));
        
    }

    public function viewduplicatequotation(Request $request, $quotation_number){
        
        $quotation = Quotation::where('quotation_number', decrypt($quotation_number))->get();
        // return $quotation;
        return view('backend.crm.view_duplicate_generated_quotation', compact('quotation'));
        
    }

    public function ordernow(Request $request){
        //return $request->all();
        //return strtotime(date('d-m-Y h:i A'));
        $order = new Order;
        $order->user_id = $request->reseller_id;
        $order->staff_id = $request->user_id;
        $order->payment_type = "cash_on_delivery";
        $order->grand_total = $request->total;
        $order->code = date('Ymd-His').rand(10,99);
        $order->delivery_date = $request->delivery_date;
        $order->remarks = $request->remarks;
        $order->date = strtotime(date('d-m-Y h:i A'));
        //$order->filter_date = date('Y-m-d');
        
        $seller = User::where('id', $request->reseller_id)->first();
        $address = Address::findOrFail($request->address_id);
        
        $data['name'] = $seller->name;
        $data['email'] = $seller->email;
        $data['address'] = $address->address;
        $data['country'] = $address->country;
        $data['state'] = $address->state;
        $data['city'] = $address->city;
        $data['postal_code'] = $address->postal_code;
        $data['phone'] = $address->phone;
        $data['checkout_type'] = $request->checkout_type;
        $order->shipping_address = json_encode($data);
        $order->save();
        foreach ($request->variant as $key => $variant) {
            $product_stock = ProductStock::where('id', $variant)->first();
            $product = Product::where('id', $product_stock->product_id)->first();
            if($product->tax_type == "percent"){
                $tax = ($product_stock->wholesale_price/100*$product->tax)*count($request->wholesale_quintity);
            }else{
                $tax = $product->tax*count($request->wholesale_quintity);
            }
            
            $orderdetails = new OrderDetail;
            $orderdetails->order_id = $order->id;
            $orderdetails->seller_id = $request->reseller_id;
            $orderdetails->product_id = $product_stock->product_id;
            $orderdetails->variation = $product_stock->variant;
            $orderdetails->quantity=$request->wholesale_quintity[$key];
            $orderdetails->shipping_type="pickup_point";
            $orderdetails->price = $request->wholesale_discount[$key];
            $orderdetails->mrp_price = $request->wholesale_unit[$key];
            $orderdetails->delivered_date = $request->delivery_date;
            $orderdetails->shipping_cost = $request->courier_charge/count($request->variant);
            $orderdetails->tax = $tax;
            $orderdetails->save();
        }
        $quotations = Quotation::where('quotation_number', $request->quotation_number)->get();
        foreach ($quotations as $quotation ){
            $quotation->quotation_name = $request->title;
            $quotation->courier_charge = $request->courier_charge;
            $quotation->date = date('Y-m-d');
            $quotation->order_status = 1;
            $quotation->address = $request->address_id;
            $quotation->save();
        }
        
        if($orderdetails->save()){
            flash(translate('Order has been successfully done'))->success();
            return redirect()->route('crm.allquotation');
        }
        else{
            flash(translate('Something went wrong'))->error();
            return back();
        }

    }

    public function variant(Request $request){

        $variant_data=array();

         $variants=array(); 

        foreach ($request->product_ids as $key => $id) {
            $product = Product::findOrFail($id);
            $variant = ProductStock::where('product_id', $product->id)->get();
            array_push($variant_data,$variant);
        }
        
        foreach($variant_data as $vari){
            foreach($vari as $varia){
                
                array_push($variants,$varia);
                
            }
        }
        if($request->variant_ids){
            if($variants){
            return response()->json(array('variants' => $variants,'variants_ids'=>$request->variant_ids), 200);
         }
            
        }else{
            if($variants){
                return response()->json(array('variants' => $variants,'variants_ids'=>''), 200);
            }
        }
        // $variants = ProductStock::where('product_id', $product->id)->get();
        // return response()->json(array('variants' => $variants), 200);

        $product_ids = $request->product_ids;
        return view('backend.crm.allproducts', compact('product_ids'));
		
    }

    public function allproducts(Request $request){

        $variant_ids = $request->variant_ids;
        $no=0;
        $product=array();
        foreach ($request->variant_ids as $key =>$id){
            $sr=++$no;
            $variant = ProductStock::findOrFail($id);
          
            array_push($product,['id'=>$variant->id,'name'=>$variant->product->name,'product_id'=>$variant->product_id,'variant'=>$variant->variant,'wholesale_price'=>$variant->wholesale_price,'wholesale_discount'=>$variant->wholesale_discount]);
        }
        return response()->json(array('products' => $product, 'i'=>$sr), 200);

        //return view('backend.crm.allproductsvariant', compact('variant_ids'));

    }
    
    public function quotationbyseller(Request $request, $reseller_id) {

        if(auth()->user()->user_type=="admin"){
            $quotationbyuser = Quotation::where('reseller_id', decrypt($reseller_id))->where('follow_up_status', 0)->orderBy('quotation_number', 'DESC')->groupBy('quotation_number');
        }else{
                $quotationbyuser = Quotation::whereHas('user', function($q){
                    $q->where('user_id', auth()->user()->id);
                })->where('reseller_id', decrypt($reseller_id))->where('follow_up_status', 0)->orderBy('quotation_number', 'DESC')->groupBy('quotation_number');
        }
        $quotationbyuser = $quotationbyuser->paginate(10);
        return view('backend.crm.quotationbyuser', compact('quotationbyuser'));
        //return $quotationbyuser;

    }

    public function user_info($id){
        
        $SellerDetails = SellerDetails::findOrFail($id);
        
        return view('backend.crm.userinfo', compact('SellerDetails'));
    }

    public function quotation_download($quotation_number) {
        $quotation = Quotation::where('quotation_number', $quotation_number)->get();
        return view('backend.crm.quotation_download_done', compact('quotation'));
        $pdf = PDF::setOptions([
                        'isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true,
                        'logOutputFile' => storage_path('logs/log.htm'),
                        'tempDir' => storage_path('logs/')
                    ])->loadView('backend.crm.quotation_download_done', compact('quotation'));
        return $pdf->download('quotation-'.$quotation[0]->quotation_number.'.pdf');

    }

    public function quotationduplicate(Request $request, $id){
        
        $quotation = Quotation::where('quotation_number', $id)->get();
        return view('backend.crm.view_duplicate_generated_quotation', compact('quotation'));
        
        //$quotation_new = $quotation->replicate();

        // $qu_no = Quotation::latest('id')->first();
        // if($qu_no==null){
        //     $qu=1;
        // }else{
        //     $qu = ++$qu_no->quotation_number;
        // }
        
        // foreach ($data_quotation as $quot) {
        //     $quotation = new Quotation;
            
        //     $quotation->user_id = $quot->user_id;
        //     $quotation->reseller_id = $quot->reseller_id;
        //     $quotation->quotation_number = $qu;
        //     $quotation->quotation_name = $quot->quotation_name;
        //     $quotation->date = $quot->date;
        //     $quotation->variant_id = $quot->variant_id;
        //     $quotation->product_id = $quot->product_id;
        //     $quotation->base_price = $quot->base_price;
        //     $quotation->wholesale_discount = $quot->wholesale_discount;
        //     $quotation->wholesale_discount_type = $quot->wholesale_discount_type;
        //     $quotation->wholesale_quintity = $quot->wholesale_quintity;
        //     $quotation->wholesale_discount_price = $quot->wholesale_discount_price;
        //     $quotation->courier_charge = $quot->courier_charge;
        //     $quotation->total = $quot->total;
        //     $quotation->duplicate_status = 1;
        //     $quotation->save();
        // }
        

        // if($quotation->save()){
        //     flash(translate('Quotation has been duplicated successfully'))->success();
        // }else{
        //     flash(translate('Something went wrong'))->error();
        // }
        // return back();
    }
    
    public function generate_duplicate_quotation(Request $request){
        //return $request->all();
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
            $quotation->business_name = $request->business_name;
            $quotation->quotation_name = $request->title;
            $quotation->date = date('Y-m-d');
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
            $quotation->save();
        }
        if($quotation->save()){
            // $latest_qu = Quotation::latest('id')->first();
            // $quotation = Quotation::where('quotation_number', $quotation->quotation_number)->get();
            // flash(translate('Quotation has been generated successfully'))->success();
            // return view('backend.crm.view_generated_quotation', compact('quotation'));
            flash(translate('Quotation Duplicated successfully'))->success();
            return redirect()->route('crm.allquotation');
        }
        else{
            flash(translate('Something went wrong'))->error();
            return back();
        }
    }
    
    public function sellerinfo(Request $request){

      
        $seller = SellerDetails::where('phone1', $request->mobile)->with('user')->first();
        $followup_status=Followup::where('reseller_id',$seller->user_id)->orderBy('id','desc')->first();
        return response()->json(array('seller' => $seller,'followup_status'=>$followup_status), 200);
    }

    public function quotationwithuserview(){
        return view('backend.crm.quotationwithuserview');
    }
    
    public function quotationwithuser(Request $request){
        
        //return $request->all();
        $user = SellerDetails::where('phone1', $request->mobile1)->get();
        if(sizeof($user) > 0){
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
                $quotation->business_name = $request->business_name;
                $quotation->quotation_name = $request->quotation_name;
                $quotation->date = $request->date;
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
                if($request->for_other == 1){
    			    $quotation->for_other = 1;
        			$quotation->other_phone = $request->other_phone;
        			$quotation->other_name = $request->other_name;
        			$quotation->other_email = $request->other_email;
    			}
                $quotation->save();
            }

        }else{
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
                    $SellerDetails->street_address = $request->street_address;
                    $SellerDetails->city = $request->city;
                    $SellerDetails->state = $request->state;
                    $SellerDetails->country = $request->country;
                    $SellerDetails->pincode = $request->pincode;
                    $SellerDetails->delivery_address = $request->delivery_address;
                    if($SellerDetails->save()){
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
                            $quotation->business_name = $request->business_name;
                            $quotation->quotation_name = $request->quotation_name;
                            $quotation->date = $request->date;
                            $quotation->variant_id = $variant;
                            $quotation->product_id = $product->product_id;
                            $quotation->base_price = $request->wholesale_unit[$key];
                            $quotation->wholesale_discount = $request->wholesale_discount[$key];
                            $quotation->wholesale_discount_type = $request->wholesale_discount_type[$key];
                            $quotation->wholesale_quintity = $request->wholesale_quintity[$key];
                            $quotation->wholesale_discount_price = $request->wholesale_discount_price[$key];
                            $quotation->type = $request->type[$key];
                            $quotation->courier_charge = $request->courier_charge;
                            $quotation->total = $request->total;
                            if($request->for_other == 1){
                			    $quotation->for_other = 1;
                    			$quotation->other_phone = $request->other_phone;
                    			$quotation->other_name = $request->other_name;
                    			$quotation->other_email = $request->other_email;
                			}
                            $quotation->save();
                        }
                        
                    }
                }
            }else{
                flash(translate('Email Exits'))->error();
                return redirect()->back()->withInput();
            }
        }
        
        if($quotation->save()){
            // $latest_qu = Quotation::latest('id')->first();
            // $quotation = Quotation::where('quotation_number', $latest_qu->quotation_number)->get();
            // flash(translate('Quotation has been generated successfully'))->success();
            // return view('backend.crm.view_generated_quotation', compact('quotation'));
            flash(translate('Quotation has been generated successfully'))->success();
            return redirect()->route('crm.allquotation');
        }
        else{
            flash(translate('Something went wrong'))->error();
            return back();
        }

    }

    public function newaddress(Request $request){
        //return $request->all();
        $validator = Validator::make($request->all(), [ 
            "phone"=>"required|numeric|digits:10|starts_with:6,7,8,9" 
        ]);
        if ($validator->fails()) { 
            flash(translate('Phone have 10 digits and start with 6,7,8,9'))->success();  
            return back();
        }

        $address = new Address;
        if($request->has('customer_id')){
            $address->user_id = $request->customer_id;
        }
        else{
            $address->user_id = Auth::user()->id;
        }
        $address->address = $request->address;
        $address->country = $request->country;
        $address->state = $request->state;
        $address->city = $request->city;
        $address->postal_code = $request->postal_code;
        $address->phone = $request->phone;
        $address->save();
        
        return back();
    }

    public function all_orders(Request $request){
        //return date('Y-m-d');
        $sort_search = null;
        $date = null;
        if(auth()->user()->user_type=="admin"){
            $orders = Order::orderBy('code', 'desc');
        }else{
            $orders = Order::where('staff_id',auth()->user()->id)->orderBy('code', 'desc');
        }
        if (!empty($request->search || $request->date)){
            $sort_search = $request->search;
            $date = $request->date;
            $orders = $orders->where('staff_id',auth()->user()->id)->where('code', 'like', '%'.$sort_search.'%')->orwhere('filter_date', $date);
        }
        // elseif(!empty($request->date)){
        //     $date = $request->date;
        //     $orders = $orders->where('staff_id',auth()->user()->id)->where('filter_date', $date);
        // }
        $orders = $orders->paginate(15);
        return view('backend.crm.orders.index', compact('orders', 'sort_search'));
    }

    public function all_orders_show($id){
        $order = Order::findOrFail(decrypt($id));
        return view('backend.crm.orders.show', compact('order'));
    }

}
