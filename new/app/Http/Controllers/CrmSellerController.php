<?php



namespace App\Http\Controllers;



use Maatwebsite\Excel\Facades\Excel;

use App\Exports\ContactFormExport;

use App\Imports\ContactFormImport;

use Illuminate\Http\Request;

use App\ContactForm;

use Carbon\Carbon;

use App\Enquiry;

use Auth;

use DB;

use App\ContactFormFollowup;

use App\MessageTemplate;

use Craftsys\Msg91\Facade\Msg91;

use App\User;

use App\MessageTransactionReport;

use App\AlertTransactionWallet;

use App\NotificationTemplet;

use App\JobPost;

use App\Job_category;

use App\Product;

use App\ProductTranslation;

use App\ProductStock;

use App\Category;

use App\Language;

use App\Models\Cart;

use App\SubSubCategory;

use Session;

use ImageOptimizer;

use Illuminate\Support\Str;

use Artisan;

use Validator;

use App\Quotation;

use App\Pi;

use App\CrmOrder;

use App\CrmOrderDetail;



class CrmSellerController extends Controller

{

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */



   public function dashboard(Request $request){

      $total_order_amount=CrmOrder::get()->sum('grand_total');
      $total_quotation=Quotation::get()->count();
      $total_pi=Pi::get()->count();
      $total_order=CrmOrder::get()->count();


    $dates = collect();
        foreach( range( -6, 0 ) AS $i ) {
            $date = \Carbon\Carbon::now()->addDays( $i )->format( 'Y-m-d' );
            $dates->put( $date, 0);
        }
        $Order = CrmOrder::where( 'created_at', '>=', $dates->keys()->first() )
                      ->groupBy( 'date' )
                      ->orderBy( 'date' )  
                     ->get( [
                         DB::raw( 'DATE( created_at ) as date' ),
                         DB::raw( 'COUNT( * ) as "count"' )
                     ] )
                     ->pluck( 'count', 'date' );
        $orders = $dates->merge( $Order );
        
    $dates = collect();
        foreach( range( -6, 0 ) AS $i ) {
            $date = \Carbon\Carbon::now()->addDays( $i )->format( 'Y-m-d' );
            $dates->put( $date, 0);
        }
        $quotation = Quotation::where( 'created_at', '>=', $dates->keys()->first() )
                      ->groupBy( 'date' )
                      ->orderBy( 'date' )  
                     ->get( [
                         DB::raw( 'DATE( created_at ) as date' ),
                         DB::raw( 'COUNT( * ) as "count"' )
                     ] )
                     ->pluck( 'count', 'date' );
        $quotations = $dates->merge( $quotation );


   $dates = collect();
        foreach( range( -6, 0 ) AS $i ) {
            $date = \Carbon\Carbon::now()->addDays( $i )->format( 'Y-m-d' );
            $dates->put( $date, 0);
        }
        $pi = Pi::where( 'created_at', '>=', $dates->keys()->first() )
                      ->groupBy( 'date' )
                      ->orderBy( 'date' )  
                     ->get( [
                         DB::raw( 'DATE( created_at ) as date' ),
                         DB::raw( 'COUNT( * ) as "count"' )
                     ] )
                     ->pluck( 'count', 'date' );
        $pis = $dates->merge( $pi );
        
     $dates = collect();
        foreach( range( -6, 0 ) AS $i ) {
            $date = \Carbon\Carbon::now()->addDays( $i )->format( 'Y-m-d' );
            $dates->put( $date, 0);
        }
        $enquiry = ContactFormFollowup::where( 'created_at', '>=', $dates->keys()->first() )
                      ->groupBy( 'last_date_of_contact' )
                      ->orderBy( 'last_date_of_contact' )  
                     ->get( [
                         DB::raw( 'DATE( created_at ) as date' ),
                         DB::raw( 'COUNT( * ) as "count"' )
                     ] )
                     ->pluck( 'count', 'date' );
        $enquries = $dates->merge( $enquiry );   
        
    $order_in_mounts=DB::table('crm_orders')->select(DB::raw('count(id) as `data`'), DB::raw("DATE_FORMAT(created_at, '%M-%Y') new_date"),  DB::raw('YEAR(created_at) year, MONTH(created_at) month'))->groupby('year','month')->take(6)->get();
   
       if($request->ajax()){

         return response()->view('frontend.user.seller.crm.dashboard_ajax',compact('total_order_amount','total_quotation','total_pi','total_order','orders','quotations','pis','enquries','order_in_mounts'));

        }

         return view('frontend.user.seller.crm.dashboard',compact('total_order_amount','total_quotation','total_pi','total_order','orders','quotations','pis','enquries','order_in_mounts'));

   }



    public function enquiry(Request $request){

         

         

        $data=ContactFormFollowup::where('added_by',Auth::user()->id)->groupBy('contact_enquiry_id')->orderBy('id','desc');

        $data2=ContactFormFollowup::where('added_by',Auth::user()->id)->where('next_date_of_contact','<=',date('Y-m-d'))->groupBy('contact_enquiry_id')->orderBy('id','desc')->get();

        

        

        $condition_lead_status=[];

        $condition_lead_source=[];

        $lead_status=explode(",",$request->lead_status);

        $lead_source=explode(",",$request->lead_source);

        $search=$request->search;

        

        if($request->lead_status!=null)

        {

            foreach($lead_status as $leadstatus)

            {

                array_push($condition_lead_status,['lead_status'=>$leadstatus]);

            }

        }

        if($request->lead_source!=null)

        {

            foreach($lead_source as $leadsource)

            {

                array_push($condition_lead_source,['lead_source'=>$leadsource]);

            }

        }

        

         if($request->lead_status!=null)

        {

            $data= $data->where(function ($query) use ($condition_lead_status){

            foreach ($condition_lead_status as $key=>$value)

            {

                $query->orWhere($value);

            }

            });

        }

        if($request->lead_source!=null)

        {

            $data= $data->where(function ($query) use ($condition_lead_source){

            foreach ($condition_lead_source as $key=>$value)

            {

                $query->orWhere($value);

            }

            });

        }

        if($search != null)

        {

             $ids = ContactForm::where(function($user) use ($search){

                $user->where('contact_name', 'like', '%'.$search.'%')->orWhere('email', 'like', '%'.$search.'%');

            })->pluck('id')->toArray();

            $data = $data->where(function($customer) use ($ids){

                $customer->whereIn('contact_enquiry_id', $ids);

            });

        }

        if($request->last_date_of_contact!=null)

        {

            $date_var = explode(" - ", $request->last_date_of_contact);

            $startDate = Carbon::createFromFormat('Y/m/d', $date_var[0])->format('Y-m-d');

            $endDate = Carbon::createFromFormat('Y/m/d', $date_var[1])->format('Y-m-d');

            $data = $data->whereBetween('last_date_of_contact', [$startDate,$endDate]);

        }

        if($request->next_date_of_contact!=null)

        {

            $date_var = explode(" - ", $request->next_date_of_contact);

            $startDate = Carbon::createFromFormat('Y/m/d', $date_var[0])->format('Y-m-d');

            $endDate = Carbon::createFromFormat('Y/m/d', $date_var[1])->format('Y-m-d');

            $data = $data->whereBetween('next_date_of_contact', [$startDate,$endDate]);

        }

        

        

        $data=$data->paginate(2);

         

         

       

       if($request->ajax()){

           if($request->enquiry=='yes'){

                return response()->view('frontend.user.seller.crm.enquiry.table',compact('data'));

           }

           

         return response()->view('frontend.user.seller.crm.enquiry.index_ajax',compact('data','data2'));

        }

         return view('frontend.user.seller.crm.enquiry.index',compact('data','data2'));

         

    }
    
    
     public function crm_seller_quotation(Request $request){


        $data=Quotation::orderBy('id','desc')->groupBy('quotation_number');
        
        $data=$data->paginate(2);
        

       if($request->ajax()){

           if($request->quotation=='yes'){

                return response()->view('frontend.user.seller.crm.quotation.table',compact('data'));

           }

         return response()->view('frontend.user.seller.crm.quotation.index_ajax',compact('data'));

        }

    }
    
     public function crm_seller_pi(Request $request){


        $data=Pi::orderBy('id','desc')->groupBy('pi_number');
        
        $data=$data->paginate(2);
        

       if($request->ajax()){

           if($request->pi=='yes'){

                return response()->view('frontend.user.seller.crm.pi.table',compact('data'));

           }

         return response()->view('frontend.user.seller.crm.pi.index_ajax',compact('data'));

        }

     }
    

    public function crm_seller_pi_edit($id){
         $data=Pi::where('pi_number',$id)->first();
         return response()->view('frontend.user.seller.crm.pi.edit',compact('data'));
    }


    public function index(Request $request)

    {   

        

        $data=ContactFormFollowup::where('added_by',Auth::user()->id)->groupBy('contact_enquiry_id')->orderBy('id','desc');

        $data2=ContactFormFollowup::where('added_by',Auth::user()->id)->where('next_date_of_contact','<=',date('Y-m-d'))->groupBy('contact_enquiry_id')->orderBy('id','desc')->get();

        

        

        $condition_lead_status=[];

        $condition_lead_source=[];

        $lead_status=explode(",",$request->lead_status);

        $lead_source=explode(",",$request->lead_source);

        $search=$request->search;

        

        if($request->lead_status!=null)

        {

            foreach($lead_status as $leadstatus)

            {

                array_push($condition_lead_status,['lead_status'=>$leadstatus]);

            }

        }

        if($request->lead_source!=null)

        {

            foreach($lead_source as $leadsource)

            {

                array_push($condition_lead_source,['lead_source'=>$leadsource]);

            }

        }

        

         if($request->lead_status!=null)

        {

            $data= $data->where(function ($query) use ($condition_lead_status){

            foreach ($condition_lead_status as $key=>$value)

            {

                $query->orWhere($value);

            }

            });

        }

        if($request->lead_source!=null)

        {

            $data= $data->where(function ($query) use ($condition_lead_source){

            foreach ($condition_lead_source as $key=>$value)

            {

                $query->orWhere($value);

            }

            });

        }

        if($search != null)

        {

             $ids = ContactForm::where(function($user) use ($search){

                $user->where('contact_name', 'like', '%'.$search.'%')->orWhere('email', 'like', '%'.$search.'%');

            })->pluck('id')->toArray();

            $data = $data->where(function($customer) use ($ids){

                $customer->whereIn('contact_enquiry_id', $ids);

            });

        }

        if($request->last_date_of_contact!=null)

        {

            $date_var = explode(" - ", $request->last_date_of_contact);

            $startDate = Carbon::createFromFormat('Y/m/d', $date_var[0])->format('Y-m-d');

            $endDate = Carbon::createFromFormat('Y/m/d', $date_var[1])->format('Y-m-d');

            $data = $data->whereBetween('last_date_of_contact', [$startDate,$endDate]);

        }

        if($request->next_date_of_contact!=null)

        {

            $date_var = explode(" - ", $request->next_date_of_contact);

            $startDate = Carbon::createFromFormat('Y/m/d', $date_var[0])->format('Y-m-d');

            $endDate = Carbon::createFromFormat('Y/m/d', $date_var[1])->format('Y-m-d');

            $data = $data->whereBetween('next_date_of_contact', [$startDate,$endDate]);

        }

        

        

        $data=$data->paginate(2);

        

        if($request->ajax()){

            if($request->page_id=='all_followup'){

                 return view('frontend.user.seller.enquiry.table_index', compact('data'));

            }

        }

        

        

        return view('frontend.user.seller.enquiry.index', compact('data','data2'));

        

    }





    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function create()

    {

        return response()->view('frontend.user.seller.crm.enquiry.create');

    }



    /**

     * Store a newly created resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */

    public function store(Request $request)

    {   

        

        $property_enquiry=ContactForm::where('id',$request->contact_enquiry_id)->first();

         if(empty($property_enquiry)){

        $property_enquiry=new ContactForm;

        $property_enquiry->company_name=$request->company_name;

        $property_enquiry->contact_name=$request->contact_name;

        $property_enquiry->email=$request->email;

        $property_enquiry->phone=$request->phone;

        $property_enquiry->phone2=$request->phone2;

        $property_enquiry->whatsapp_number=$request->whatsapp_number;

        $property_enquiry->country=$request->country;

        $property_enquiry->state=$request->state;

        $property_enquiry->city=$request->city;

        $property_enquiry->pincode=$request->postal_code;

        $property_enquiry->address=$request->address;

        $property_enquiry->website=$request->website;

        $property_enquiry->facebook_link=$request->facebook_link;

        $property_enquiry->instagram_link=$request->instagram_link;

        $property_enquiry->twitter_link=$request->twitter_link;

        $property_enquiry->youtube_link=$request->youtube_link;

        $property_enquiry->status='open';

        $property_enquiry->added_by=Auth::user()->id;

        $property_enquiry->save();

        

           $property_followup=new ContactFormFollowup;

           $property_followup->contact_enquiry_id=$property_enquiry->id;

           $property_followup->last_date_of_contact=$request->last_date;

           $property_followup->next_date_of_contact=$request->next_date;

           $property_followup->lead_status=$request->status_of_lead;

           $property_followup->lead_source=$request->source_of_lead;

           $property_followup->remark=$request->remark;

           $property_followup->added_by=Auth::user()->id;

           $property_followup->save();

        

         }else{

             

             if($property_enquiry->status == 'closed')

            {

               

                 $property_enquiry=new ContactForm;

        $property_enquiry->company_name=$request->company_name;

        $property_enquiry->contact_name=$request->contact_name;

        $property_enquiry->email=$request->email;

        $property_enquiry->phone=$request->phone;

        $property_enquiry->phone2=$request->phone2;

        $property_enquiry->whatsapp_number=$request->whatsapp_number;

        $property_enquiry->country=$request->country;

        $property_enquiry->state=$request->state;

        $property_enquiry->city=$request->city;

        $property_enquiry->pincode=$request->postal_code;

        $property_enquiry->address=$request->address;

        $property_enquiry->website=$request->website;

        $property_enquiry->facebook_link=$request->facebook_link;

        $property_enquiry->instagram_link=$request->instagram_link;

        $property_enquiry->twitter_link=$request->twitter_link;

        $property_enquiry->youtube_link=$request->youtube_link;

        $property_enquiry->status='open';

        $property_enquiry->added_by=Auth::user()->id;

        $property_enquiry->save();

        

           $property_followup=new ContactFormFollowup;

           $property_followup->contact_enquiry_id=$property_enquiry->id;

           $property_followup->last_date_of_contact=$request->last_date;

           $property_followup->next_date_of_contact=$request->next_date;

           $property_followup->lead_status=$request->status_of_lead;

           $property_followup->lead_source=$request->source_of_lead;

           $property_followup->remark=$request->remark;

           $property_followup->added_by=Auth::user()->id;

           $property_followup->save();

                   

                

            }

            else{

             $property_followup=new ContactFormFollowup;

           $property_followup->contact_enquiry_id=$property_enquiry->id;

           $property_followup->last_date_of_contact=$request->last_date;

           $property_followup->next_date_of_contact=$request->next_date;

           $property_followup->lead_status=$request->status_of_lead;

           $property_followup->lead_source=$request->source_of_lead;

           $property_followup->remark=$request->remark;

           $property_followup->added_by=Auth::user()->id;

           $property_followup->save();

                   

                

            }

       

   

             

    }     

        

         if($request->follow_up_form)

        {

           

           return 1;

        }

         

        return redirect()->route('crm.enquiry');

    }



    /**

     * Display the specified resource.

     *

     * @param  \App\ContactForm  $contactForm

     * @return \Illuminate\Http\Response

     */

    public function show(ContactForm $contactForm)

    {

        //

    }



    public function getConatactFollowup($contact_enquiry_id)

    {

        $list=ContactFormFollowup::where('contact_enquiry_id',$contact_enquiry_id)->paginate(20);
        
        $quotations=Quotation::where('contact_enquiry_id',$contact_enquiry_id)->groupBy('contact_enquiry_id')->paginate(20);
        $pis=Pi::where('contact_enquiry_id',$contact_enquiry_id)->paginate(20);
        $orders=CrmOrder::where('contact_enquiry_id',$contact_enquiry_id)->paginate(20);
        
        return response()->view('frontend.user.seller.crm.enquiry.enquiry_detail',compact('list','quotations','pis','orders'));

    }



   public function saveFollowupData(Request $request)

    {

      

        $input= $request->all();

        ContactFormFollowup::create($input);

        if($request->status=='closed'){

            $id=$request->contact_enquiry_id;

            $contact_form=ContactForm::find($id);

            $contact_form->status='closed';

            $contact_form->save();

        }

         $list=ContactFormFollowup::where('contact_enquiry_id',$request->contact_enquiry_id)->paginate(20);

        return response()->view('frontend.user.seller.crm.enquiry.enquiry_detail_table',compact('list'));

    }



    /**

     * Show the form for editing the specified resource.

     *

     * @param  \App\ContactForm  $contactForm

     * @return \Illuminate\Http\Response

     */

    public function edit($id)

    {

        $edit_data=ContactForm::find($id);

        return  response()->view('frontend.user.seller.crm.enquiry.edit', compact('edit_data'));



    }



    /**

     * Update the specified resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @param  \App\ContactForm  $contactForm

     * @return \Illuminate\Http\Response

     */

    public function update(Request $request, $id)

    {

        $input = $request->all();

        ContactForm::find($id)->update($input);

        return redirect()->route('crm.enquiry');

    }



    /**

     * Remove the specified resource from storage.

     *

     * @param  \App\ContactForm  $contactForm

     * @return \Illuminate\Http\Response

     */

    public function destroy($id)

    {

        //return $id;

        $var= ContactForm::where('id', $id)->update(array('delete_status' => 0));

        return redirect()->route('contactform.index');

    }



    public function filter (Request $request) {



        //return $request->date;



        $data = ContactForm::where( function($query) use($request){

                         return $request->status_of_lead ?

                                $query->from('contact_forms')->where('status_of_lead',$request->status_of_lead) : '';

                    })->where(function($query) use($request){

                         return $request->source_of_lead ?

                                $query->from('contact_forms')->where('source_of_lead',$request->source_of_lead) : '';

                    })->where(function($query) use($request){

                        return $request->date ?

                               $query->from('contact_forms')->whereDate('created_at',$request->date) : '';

                   })->get();

        

    

        return view('contact_form.index',compact('data'));

    

    }



    public function ajxfilter(Request $request){

        

        if(!empty($request->status_of_lead) && !empty($request->source_of_lead)){

            $data = ContactForm::where('status_of_lead', $request->status_of_lead)

                ->Where('source_of_lead', $request->source_of_lead)

                ->get();

        }else if(!empty($request->status_of_lead) || !empty($request->source_of_lead)){

            $data = ContactForm::where('status_of_lead', $request->status_of_lead)

                ->orWhere('source_of_lead', $request->source_of_lead)

                ->get();

        }else{

            $data = ContactForm::get();

        }

        

        return response()->json(array('data' => $data), 200);

        // return datatables()->of($data)->make(true);



    }



    public function importview(){

        return view('frontend.user.seller.enquiry.import');

    }



    public function export(){

        return Excel::download(new ContactFormExport, 'ContactData.xlsx');

    }

    

    public function digitalEnquiry(Request $request)

    {

        $list=Enquiry::where('business_id',Auth::user()->business_listings->id);

        $dat="";

        if(!empty($request->daterange))

        {

            $dates=explode('-',$request->daterange);

            $d1=strtotime($dates[0]);

            $d2=strtotime($dates[1]);

            $da1=date('Y-m-d',$d1);

            $da2=date('Y-m-d',$d2);

            $startDate = Carbon::createFromFormat('Y-m-d', $da1)->startOfDay();

            $endDate = Carbon::createFromFormat('Y-m-d', $da2)->endOfDay();

            

            $dat=$dates[0].' - '.$dates[1];

            

            $list = $list->whereBetween('created_at', [$startDate, $endDate]);

        }

        $list=$list->orderBy('created_at','desc')->paginate(20);

        return view('frontend.user.seller.enquiry.digital_enquiry', compact('list','dat'));

    }

    

     public function message_template_index(){

         return response()->view('frontend.user.seller.crm.message.send_message');

    }

    public function notification_template_index(){

         return view('frontend.user.seller.crm.message.send_notification');

    }

    public function message_send(Request $request){

     $seller_data=Auth::user()->seller;

      $template =  MessageTemplate::where('flow_id',$request->message_template)->first();

      foreach(json_decode($request->enquiry_id) as $user){

          $user_data=ContactForm::find($user);

          $variable=explode(',',$template->variable);

          if($seller_data->message_balance > 0){

          Msg91::sms()->to('91'.$user_data->phone)->flow($template->flow_id)->variable('OTP', '1234')->send();

          $data=new MessageTransactionReport;

          $data->user_id=Auth::user()->id;

          $data->phone=$user_data->phone;

          $data->message=str_replace('##OTP##','1234',$template->body);

          $data->save();

          $seller_data->message_balance=$seller_data->message_balance-1;

          $seller_data->save();

          }else{

              flash(translate('Wallet Balance Low Please Recharege'))->warning();

                return back();

          }

      }

      

       flash(translate('Message Send Successfully'))->success();

      return back();

    }

    

    

    public function notification_send(Request $request){

     $seller_data=Auth::user()->seller;

      $template =  NotificationTemplet::where('id',$request->message_template)->first();

      

      $click_action='';

        $tag='';

        if($request->notification_type == 'resume_maker')

        {

            $click_action='CREATE_RESUME';

        }

        if($request->notification_type == 'all_job')

        {

            $click_action='JOB_HOME';

        }

        if($request->notification_type == 'specific_job')

        {

            $click_action='JOB_DETAIL';

            $tag=$request->job;

        }

        if($request->notification_type == 'job_category')

        {

            $click_action='JOB_SEARCH';

            $tag=$request->job_cat_id;

        }

        

        $image='https://meraonlinebusiness.com/public/'.api_asset($request->image);

        

        if($request->job_user == 'all')

        {

         $list=User::whereNotNull('fcm_token')->get();

        }

        $job=JobPost::select('job_posts.*','business_listings.id as bu_id','business_listings.business_name')->leftjoin('business_listings','job_posts.bussiness_id','business_listings.id')->where('job_posts.id',$request->job)->first();

        $job_category=Job_category::where('id',$request->job_cat_id)->first();

      

      

      foreach(json_decode($request->enquiry_id) as $user){

          $user_data=ContactForm::find($user);

         $data=User::where('phone',$user_data->phone)->first();

         

          if($request->notification_type == 'resume_maker' || $request->notification_type == 'all_job')

            {

                $title=str_replace("[user_name]",$data->name,$request->title);

                $body=str_replace("[user_name]",$data->name,$request->body);

            }

            elseif($request->notification_type == 'specific_job')

            {

                $user_name=str_replace("[user_name]",$data->name,$request->title);

                $job_title=str_replace("[job_title]",$job->job_title,$user_name);

                $city_name=str_replace("[city_name]",$job->job_location_city,$job_title);

                $salary=str_replace("[salary]",$job->salary_to,$city_name);

                $business_name=str_replace("[business_name]",$job->business_name,$salary);

                $qualification=str_replace("[qualification]",$job->minimum_qualification,$business_name);

                $experience=str_replace("[experience]",$job->minimum_experience,$qualification);

                $knowledge=str_replace("[knowledge]",$job->english_knowledge,$experience);

                $interview_date=str_replace("[interview_date]",$job->interview_start_day,$knowledge);

                $interview_location=str_replace("[interview_location]",$job->interview_location,$interview_date);

                $title=$interview_location;

                $user_name_body=str_replace("[user_name]",$data->name,$request->body);

                $job_title_body=str_replace("[job_title]",$job->job_title,$user_name_body);

                $city_name_body=str_replace("[city_name]",$job->job_location_city,$job_title_body);

                $salary_body=str_replace("[salary]",$job->salary_to,$city_name_body);

                $business_name_body=str_replace("[business_name]",$job->business_name,$salary_body);

                $qualification_body=str_replace("[qualification]",$job->minimum_qualification,$business_name_body);

                $experience_body=str_replace("[experience]",$job->minimum_experience,$qualification_body);

                $knowledge_body=str_replace("[knowledge]",$job->english_knowledge,$experience_body);

                $interview_date_body=str_replace("[interview_date]",$job->interview_start_day,$knowledge_body);

                $interview_location_body=str_replace("[interview_location]",$job->interview_location,$interview_date_body);

                $body=$interview_location_body;

            }

            elseif($request->notification_type == 'job_category')

            {

                $user_name_title=str_replace("[user_name]",$data->name,$request->title);

                $title=str_replace("[category_title]",$job_category->name,$user_name_title);

                $user_name_body=str_replace("[user_name]",$data->name,$request->body);

                $body=str_replace("[category_title]",$job_category->name,$user_name_body);

            }

            

                $user_name_title=str_replace("[user_name]",$data->name,$request->title);

                $title=$request->title;

                $user_name_body=str_replace("[user_name]",$data->name,$request->body);

                $body=$request->body;

            

            fcm()->to([$data->fcm_token])->priority('normal')->timeToLive(0)->notification([

                'title'=>$title,

                'body'=>$body,

                'image'=>$image,

                'click_action'=>$click_action,

                'tag'=>$tag,

            ])->send();

         

         

      }

        return redirect()->back();

    }

    

    public function call_notification(Request $request){

        

         $data=User::where('phone',$request->phone)->first();

        fcm()->to([$data->fcm_token])->priority('normal')->timeToLive(0)->notification([

                'title'=>'To call '.$data->name,

                'body'=>$data->phone,

                'click_action'=>'call',

                'tag'=>$data->phone,

            ])->send();

            return redirect()->back();

            

    }

    

    public function message_transaction(Request $request){

        $data=MessageTransactionReport::where('user_id',Auth::user()->id)->get();

         return view('frontend.user.seller.message.message_transaction',compact('data'));

    }

     public function recharge_wallet(Request $request){

         $list=AlertTransactionWallet::get();

         return view('frontend.user.seller.message.recharge_wallets',compact('list'));

    }

     public function table(Request $request){

         return view('frontend.user.seller.crm.table');

    }

    

    public function notification_info(Request $request){

        $data = NotificationTemplet::findOrFail($request->id);

        return $data;

     }

    

   public function crm_quotation(Request $request){
            
         return response()->view('frontend.user.seller.crm.quotation.index');

    }

  
 public function crm_seller_quotation_edit($id){
         $data=Quotation::where('quotation_number',$id)->first();
         return response()->view('frontend.user.seller.crm.quotation.edit',compact('data'));
    }
  

  public function allproducts(Request $request){

        $col_name = null;

        $query = null;

        $seller_id = null;

        $brand_id=null;

        $sort_search = null;

        

        

        

        

        $products = ProductStock::where('id','>', 0);

        

        

    

        $products = $products->paginate(20);

        $type = 'All';



       if($request->ajax() && $request->form_search=='yes'){

           

            

                return response()->view('frontend.user.seller.crm.products.index_table_ajax', compact('products','type', 'col_name', 'query', 'seller_id', 'sort_search','brand_id'));

           

       }



        return response()->view('frontend.user.seller.crm.products.index', compact('products','type', 'col_name', 'query', 'seller_id', 'sort_search','brand_id'));

  }

    

  public function quotationwithuser(Request $request){
    
   // return $request->all();

                    $qu_no = Quotation::latest('id')->first();

                    if($qu_no==null){
                        $qu=1;
                      }else{
                        $qu = ++$qu_no->quotation_number;
                     }

                    foreach ($request->variant_id as $key => $variant) {

                        $product = ProductStock::where('id', $variant)->first();
                        $quotation = new Quotation;
                        $quotation->user_id = $request->user_id;
                        $quotation->reseller_id = '';
                        $quotation->quotation_number = $qu;
                        if(!empty($request->contact_enquiry_id)){
                         $quotation->contact_enquiry_id = $request->contact_enquiry_id;
                        }
                        $quotation->business_name = $request->business_name;
                        $quotation->name = $request->name;
                        $quotation->phone = $request->mobile1;
                        $quotation->email = $request->email;
                        $quotation->other_phone = $request->other_phone;
                        $quotation->other_name = $request->other_name;
                        $quotation->other_email = $request->other_email;
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
                        $quotation->total = $request->grand_total;
                        $quotation->save();

                    }
                    if($request->type_from=='enquiry'){
                         return redirect()->route('crm.enquiry');
                    }
                    if($request->type_from=='quotation'){
                         return redirect()->route('crm_seller.quotation');
                    }
                    
        }

 public function generate_pi($id){
    
   // return $request->all();

                    $pi_no = Pi::latest('id')->first();

                    if($pi_no==null){
                        $pi_no=1;
                      }else{
                        $pi_no = ++$pi_no->pi_number;
                     }

                    
                    $quotaion = Quotation::where('quotation_number',$id)->get();
                    foreach($quotaion as $q){
                    
                    $pi = Quotation::find($q->id);
                   
                    $pi_new = $pi->replicate();
                    $pi_new->setTable('pis');
                    $pi_new->pi_number = $pi_no ;
                    $pi_new->save();
                    
                    }
       
                     
                 return back();  
                    
        }
      
      
      public function crm_seller_orders(Request $request){


        $data=CrmOrder::orderBy('id','desc');
        
        $data=$data->paginate(2);
        

       if($request->ajax()){

           if($request->order=='yes'){

                return response()->view('frontend.user.seller.crm.order.table',compact('data'));

           }

         return response()->view('frontend.user.seller.crm.order.index_ajax',compact('data'));

        }

     } 
      
      
       public function crm_seller_order_detail($id){


        $order=CrmOrder::where('id',$id)->first();
        
         return response()->view('frontend.user.seller.crm.order.show',compact('order'));

      

     } 
      
      
     public function order_store(Request $request){
       $input =  $request->all();
         
         $pi_data=Pi::where('pi_number',$request->pi_number)->get();
         
         
        $order = new CrmOrder;
        $order->user_id = $request->user_id;
        $order->pi_number = $request->pi_number;
        if(!empty($request->contact_enquiry_id)){
             $order->contact_enquiry_id = $request->contact_enquiry_id;
        }
        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['phone'] = $request->mobile1;
        $shipping_info = $data;
        $order->shipping_address= json_encode($shipping_info);
        $order->delivery_viewed = '0';
        $order->payment_status_viewed = '0';
        $order->code = date('Ymd-His').rand(10,99);
        $order->date = strtotime('now');
        $order->grand_total = $request->grand_total;
        if($order->save()){
          
            //Order Details Storing

            foreach ($pi_data as $key => $pi){
                $order_detail = new CrmOrderDetail;
                $order_detail->order_id  =$order->id;
                $order_detail->seller_id = $pi->user_id;
                $order_detail->product_id = $pi->product_id;
                $order_detail->variant_id = $pi->variant_id;
                $order_detail->product_name =$input['product_name'][$key];
                $order_detail->mrp_price =$pi->base_price;
                $order_detail->price =$pi->wholesale_discount_price;
                $order_detail->quantity = $pi->wholesale_quintity;
                $order_detail->save();
            }
            $order->save();


        }
         
         
         
     } 
      
       

}

