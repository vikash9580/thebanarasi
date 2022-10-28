 <div class="content">
    <!-- Start Content-->
     <div class="container-fluid">
    
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title">Enquiry</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">MOB</a></li>
                            <li class="breadcrumb-item active">Leads</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    
        <div class="row">
                          <div class="card-body">
 
 
 <form class="row g-3 needs-validation" id="contact_form" method="POST" action="{{route('crm.contact_form_save')}}" novalidate>
              @csrf
               <div class="col-md-6">
                  <label for="" class="form-label">Company Name</label>
                  <input type="text" class="form-control" name="company_name" >
                  <div class="invalid-feedback">
                     Please Enter Company Name
                  </div>
               </div>
               <div class="col-md-6">
                  <label for="" class="form-label">Contact Name <span style="color:red">*</span></label>
                  <input type="text" class="form-control" name="contact_name"  required>
                  <div class="invalid-feedback">
                     Please Enter Contact Name
                  </div>
               </div>
               <div class="col-md-3">
                  <label for="" class="form-label">Email Address</label>
                  <div class="input-group has-validation">
                     <span class="input-group-text" id="inputGroupPrepend">@</span>
                     <input type="email" class="form-control" name="email"  aria-describedby="inputGroupPrepend">
                     <div class="invalid-feedback">
                        Please Enter Valid Email Address
                     </div>
                  </div>
               </div>
               <div class="col-md-3">
                  <label for="" class="form-label">Phone <span style="color:red">*</span></label>
                  <div class="input-group has-validation">
                     <input type="number" class="form-control" name="phone"  aria-describedby="inputGroupPrepend" required>
                     <div class="invalid-feedback">
                        Please Enter Phone Number
                     </div>
                  </div>
               </div>
               <div class="col-md-3">
                  <label for="" class="form-label">Phone 2</label>
                  <div class="input-group has-validation">
                     <input type="number" class="form-control" name="phone2"  aria-describedby="inputGroupPrepend" >
                     <div class="invalid-feedback">
                        Please Enter Second Phone Number
                     </div>
                  </div>
               </div>
               <div class="col-md-3">
                  <label for="" class="form-label">Whatsapp Number</label>
                  <div class="input-group has-validation">
                     <input type="number" class="form-control" name="whatsapp_number"  aria-describedby="inputGroupPrepend" >
                     <div class="invalid-feedback">
                        Please Enter Second Phone Number
                     </div>
                  </div>
               </div>
              <div class="col-md-3">
                  <label for="" class="form-label">Country</label>
              <select class="form-control js-example-basic-single" name="country" id='countries_name' >
                                    @foreach (\App\Country::where('delete_status', 1)->get() as $key => $country)
                                        <option value="{{ $country->name }}" >{{ $country->name }}</option>
                                    @endforeach
                                </select>
            </div>
            <div class="col-md-3">
               <label for="" class="form-label">State</label>
               
            <select class="form-control js-example-basic-single"  name="state" id="state_name" >
                                   
                                </select>
         </div>
         <div class="col-md-3">
            <label for="" class="form-label">City</label>
            <select class="form-control js-example-basic-single"  name="city"  id="city_names" >
                
            </select>
         </div>
         <div class="col-md-3">
            <label for="" class="form-label">Pincode / Zip Code</label>
            <select class="form-control js-example-basic-single"  name="postal_code"  id="postal_code_name" >
                                   
                                </select>
         </div>
         <div class="col-md-12">
            <label for="" class="form-label">Address</label>
            <textarea class="form-control" name="address" ></textarea>
         </div>
        
         <div class="col-md-3">
            <label for="" class="form-label">Website</label>
            <input type="text" class="form-control" name="website" >
         </div>
        
         <div class="col-md-12">
          <h3 style="margin:20px 0;">Social Media Links</h3>
         </div>
         <div class="col-md-3">
            <label for="" class="form-label">Facebook Link</label>
            <input type="text" class="form-control" name="facebook_link" >
         </div>
         <div class="col-md-3">
            <label for="" class="form-label">Instagram Link</label>
            <input type="text" class="form-control" name="instagram_link" >
         </div>
         <div class="col-md-3">
            <label for="" class="form-label">Twitter Link</label>
            <input type="text" class="form-control" name="twitter_link" >
         </div>
         <div class="col-md-3">
            <label for="" class="form-label">YouTube Link</label>
            <input type="text" class="form-control" name="youtube_link" >
         </div>
         
       <div class="col-md-12">
         <h3 style="margin:20px 0;">Funnel</h3>
         </div>
         
         <div class="col-md-3">
            <label for="" class="form-label">Date Of Last Contact</label>
            <input type="date" class="form-control"  name="last_date" value="@if(isset($edit_data['last_date'])){{ $edit_data['last_date'] }}@endif" >
         </div>
         <div class="col-md-3">
            <label for="" class="form-label">Date Of Next Contact</label>
            <input type="date" class="form-control" name="next_date" value="@if(isset($edit_data['next_date'])){{ $edit_data['next_date'] }}@endif">
         </div>
         <div class="col-md-3">
            <label for="" class="form-label">Status Of Lead</label>
            
            <select class="form-control" name="status_of_lead">
               <option selected disabled value="">-- Select --</option>
               <option value="Attempted to contact" @if(isset($edit_data['status_of_lead']) && $edit_data['status_of_lead']== 'Attempted to contact'){{ 'selected' }}@endif>Attempted to contact</option>
               <option value="Contact in future" @if(isset($edit_data['status_of_lead']) && $edit_data['status_of_lead']== 'Contact in future'){{ 'selected' }}@endif>Contact in future</option>
               <option value="Contacted" @if(isset($edit_data['status_of_lead']) && $edit_data['status_of_lead']== 'Contacted'){{ 'selected' }}@endif>Contacted</option>
               <option value="Junk lead" @if(isset($edit_data['status_of_lead']) && $edit_data['status_of_lead']== 'Junk lead'){{ 'selected' }}@endif>Junk lead</option>
               <option value="Lost lead" @if(isset($edit_data['status_of_lead']) && $edit_data['status_of_lead']== 'Lost lead'){{ 'selected' }}@endif>Lost lead</option>
               <option value="Not contacted" @if(isset($edit_data['status_of_lead']) && $edit_data['status_of_lead']== 'Not contacted'){{ 'selected' }}@endif>Not contacted</option>
               <option value="Pre-qualified" @if(isset($edit_data['status_of_lead']) && $edit_data['status_of_lead']== 'Pre-qualified'){{ 'selected' }}@endif>Pre-qualified</option>
               <option value="Not qualified" @if(isset($edit_data['status_of_lead']) && $edit_data['status_of_lead']== 'Not qualified'){{ 'selected' }}@endif>Not qualified</option>
            </select>
         </div>
         <div class="col-md-3">
            <label for="" class="form-label">Source Of Lead</label>
            <select class="form-control" name="source_of_lead">
               <option selected disabled value="">-- Select --</option>
               <option value="Sales Team" @if(isset($edit_data['source_of_lead']) && $edit_data['source_of_lead']== 'Sales Team'){{ 'selected' }}@endif>Sales Team</option>
               <option value="Social Media" @if(isset($edit_data['source_of_lead']) && $edit_data['source_of_lead']== 'Social Media'){{ 'selected' }}@endif>Social Media</option>
               <option value="Telecalling" @if(isset($edit_data['source_of_lead']) && $edit_data['source_of_lead']== 'Telecalling'){{ 'selected' }}@endif>Telecalling</option>
               <option value="Whatsapp" @if(isset($edit_data['source_of_lead']) && $edit_data['source_of_lead']== 'Whatsapp'){{ 'selected' }}@endif>Whatsapp</option>
               <option value="Referral" @if(isset($edit_data['source_of_lead']) && $edit_data['source_of_lead']== 'Referral'){{ 'selected' }}@endif>Referral</option>
               <option value="Facebook Ads" @if(isset($edit_data['source_of_lead']) && $edit_data['source_of_lead']== 'Facebook Ads'){{ 'selected' }}@endif>Facebook Ads</option>
               <option value="Google Ads" @if(isset($edit_data['source_of_lead']) && $edit_data['source_of_lead']== 'Google Ads'){{ 'selected' }}@endif>Google Ads</option>
               <option value="Website" @if(isset($edit_data['source_of_lead']) && $edit_data['source_of_lead']== 'Website'){{ 'selected' }}@endif>Website</option>
               <option value="App" @if(isset($edit_data['source_of_lead']) && $edit_data['source_of_lead']== 'App'){{ 'selected' }}@endif>App</option>
               <option value="Self Visit" @if(isset($edit_data['source_of_lead']) && $edit_data['source_of_lead']== 'Self Visit'){{ 'selected' }}@endif>Self Visit</option>
            </select>
         </div>
          <div class="col-md-12">
            <label for="" class="form-label">Next Action to Take</label>
             <select class="form-control" name="next_action_to_take">
               <option selected disabled value="">-- Select --</option>
            </select>
         </div>
         <div class="col-md-12">
            <label for="" class="form-label">Remark</label>
            <textarea class="form-control" name="remark">@if(isset($edit_data['remark'])){{ $edit_data['remark'] }}@endif</textarea>
         </div>
         <input type="hidden" name="added_by" id="added_by" value="{{Auth::user()->id}}" class="form-control">
         <input type="hidden" name="contact_enquiry_id" id="contact_enquiry_id" value="" class="form-control">
         
          <div class="col-md-12 mt-3">
           <button type="submit" onclick="data_save()" class="btn btn-primary">Save</button>
            
         </div>
            
         </div>
      </form>
      
          </div>
        </div>
        
        </div>
 </div>
 
 <script src="{{asset('public/crm/libs/select2/js/select2.min.js')}}"></script>
 <script>
     $(document).ready(function(){
         $('.js-example-basic-single').select2();
        $('#countries_name').change(function() {
        var country_name= $('#countries_name').val(); 
         $.post('{{ route('addresses.state_list') }}', {_token:'{{ csrf_token() }}', id:country_name}, function(data){
           
           $('#state_name').empty();
            $('#state_name').append('<option value="">Select State</option>');
             $.each(data.list,function(item,i){
                $('#state_name').append('<option value="'+i.state_name+'">'+i.state_name+'</option>');
             });
                
            });
      
      
  });
        $('#state_name').change(function() {
      
     var state_name= $('#state_name').val(); 

      $.post('{{ route('addresses.city_list') }}', {_token:'{{ csrf_token() }}', id:state_name}, function(data){
           
           $('#city_names').empty();
            $('#city_names').append('<option value="">Select City</option>');
             $.each(data.list,function(item,i){
                $('#city_names').append('<option value="'+i.city_name+'">'+i.city_name+'</option>');
             });
                
            });
      
      
  });
        $('#city_names').change(function() {
      
     var city_name= $('#city_names').val(); 
     $.post('{{ route('addresses.pincode_list') }}', {_token:'{{ csrf_token() }}', id:city_name}, function(data){
           
           $('#postal_code_name').empty();
            $('#postal_code_name').append('<option value="">Select Pincode</option>');
             $.each(data.list,function(item,i){
                $('#postal_code_name').append('<option value="'+i.pincode+'">'+i.pincode+'</option>');
             });
                
            });
  });
  
       
  
     
  
     }); 
   
   function data_save(){
        event.preventDefault();
        var formUrl = $('#contact_form').attr('action');
         $.ajax({
            beforeSend: function() {
                $('#preloader').css("display", "block");
            },
            type: "POST",
            url: formUrl ,
            data:$('#contact_form').serialize(),
            success: function(data) {
                $('#page_content').html(data);    
            },
            complete: function() {
               $('#preloader').css("display", "none");
            }
        });
   }
   
   
   
  
       
        
      
   
   
 </script>
        