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
 
 
 <form class="row g-3 needs-validation" id="contact_form" method="POST" action="{{route('crm.contact_form_update', $edit_data['id'])}}" novalidate>
              @csrf
               <div class="col-md-6">
                  <label for="" class="form-label">Company Name</label>
                  <input type="text" class="form-control" name="company_name" value="@if(isset($edit_data['company_name'])){{ $edit_data['company_name'] }}@endif">
                  <div class="invalid-feedback">
                     Please Enter Company Name
                  </div>
               </div>
               <div class="col-md-6">
                  <label for="" class="form-label">Contact Name <span style="color:red">*</span></label>
                  <input type="text" class="form-control" name="contact_name" value="@if(isset($edit_data['contact_name'])){{ $edit_data['contact_name'] }}@endif" required>
                  <div class="invalid-feedback">
                     Please Enter Contact Name
                  </div>
               </div>
               <div class="col-md-3">
                  <label for="" class="form-label">Email Address</label>
                  <div class="input-group has-validation">
                     <span class="input-group-text" id="inputGroupPrepend">@</span>
                     <input type="email" class="form-control" name="email" value="@if(isset($edit_data['email'])){{ $edit_data['email'] }}@endif" aria-describedby="inputGroupPrepend">
                     <div class="invalid-feedback">
                        Please Enter Valid Email Address
                     </div>
                  </div>
               </div>
               <div class="col-md-3">
                  <label for="" class="form-label">Phone <span style="color:red">*</span></label>
                  <div class="input-group has-validation">
                     <input type="number" class="form-control" name="phone" value="@if(isset($edit_data['phone'])){{ $edit_data['phone'] }}@endif" aria-describedby="inputGroupPrepend" required>
                     <div class="invalid-feedback">
                        Please Enter Phone Number
                     </div>
                  </div>
               </div>
               <div class="col-md-3">
                  <label for="" class="form-label">Phone 2</label>
                  <div class="input-group has-validation">
                     <input type="number" class="form-control" name="phone2" value="@if(isset($edit_data['phone2'])){{ $edit_data['phone2'] }}@endif" aria-describedby="inputGroupPrepend" >
                     <div class="invalid-feedback">
                        Please Enter Second Phone Number
                     </div>
                  </div>
               </div>
               <div class="col-md-3">
                  <label for="" class="form-label">Whatsapp Number</label>
                  <div class="input-group has-validation">
                     <input type="number" class="form-control" name="whatsapp_number" value="@if(isset($edit_data['whatsapp_number'])){{ $edit_data['whatsapp_number'] }}@endif" aria-describedby="inputGroupPrepend" >
                     <div class="invalid-feedback">
                        Please Enter Second Phone Number
                     </div>
                  </div>
               </div>
              <div class="col-md-3">
                  <label for="" class="form-label">Country</label>
              <select class="form-control js-example-basic-single" name="country" id='countries_name' >
                                    @foreach (\App\Country::where('delete_status', 1)->get() as $key => $country)
                                        <option value="{{ $country->name }}" @if($edit_data['country']== $country->name ){{ 'selected' }}@endif>{{ $country->name }}</option>
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
            <textarea class="form-control" name="address" >@if(isset($edit_data['address'])){{ $edit_data['address'] }}@endif</textarea>
         </div>
        
         <div class="col-md-3">
            <label for="" class="form-label">Website</label>
            <input type="text" class="form-control" name="website" value="@if(isset($edit_data['website'])){{ $edit_data['website'] }}@endif">
         </div>
        
         <div class="col-md-12">
          <h3 style="margin:20px 0;">Social Media Links</h3>
         </div>
         <div class="col-md-3">
            <label for="" class="form-label">Facebook Link</label>
            <input type="text" class="form-control" name="facebook_link" value="@if(isset($edit_data['facebook_link'])){{ $edit_data['facebook_link'] }}@endif">
         </div>
         <div class="col-md-3">
            <label for="" class="form-label">Instagram Link</label>
            <input type="text" class="form-control" name="instagram_link" value="@if(isset($edit_data['instagram_link'])){{ $edit_data['instagram_link'] }}@endif">
         </div>
         <div class="col-md-3">
            <label for="" class="form-label">Twitter Link</label>
            <input type="text" class="form-control" name="twitter_link" value="@if(isset($edit_data['twitter_link'])){{ $edit_data['twitter_link'] }}@endif">
         </div>
         <div class="col-md-3">
            <label for="" class="form-label">YouTube Link</label>
            <input type="text" class="form-control" name="youtube_link" value="@if(isset($edit_data['youtube_link'])){{ $edit_data['youtube_link'] }}@endif">
         </div>
         
       
         
          <div class="col-md-12 mt-3">
           <button type="submit" onclick="data_save()" class="btn btn-primary">Update</button>
            
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
   
   
   
   function  getState(id){
           var country_name= $('#countries_name').val(); 
         $.post('{{ route('addresses.state_list') }}', {_token:'{{ csrf_token() }}', id:country_name}, function(data){
           
           $('#state_name').empty();
            $('#state_name').append('<option value="">Select State</option>');
             $.each(data.list,function(item,i){
                 var sel=""
                 if(id==i.state_name){
                     sel="selected";
                 }
                $('#state_name').append('<option value="'+i.state_name+'"'+sel+' >'+i.state_name+'</option>');
             });
                
            });
      }
      
   function  getCity(id){
         var state_name= $('#state_name').val(); 
      $.post('{{ route('addresses.city_list') }}', {_token:'{{ csrf_token() }}', id:state_name}, function(data){
           
           $('#city_names').empty();
            $('#city_names').append('<option value="">Select City</option>');
             $.each(data.list,function(item,i){
                  var sel=""
                 if(id==i.city_name){
                     sel="selected";
                 }
                $('#city_names').append('<option value="'+i.city_name+'"'+sel+'>'+i.city_name+'</option>');
             });
                
            });
        
      }
      
   function  getPincode(id){
          var city_name= $('#city_names').val(); 
         $.post('{{ route('addresses.pincode_list') }}', {_token:'{{ csrf_token() }}', id:city_name}, function(data){
           
           $('#postal_code_name').empty();
            $('#postal_code_name').append('<option value="">Select Pincode</option>');
             $.each(data.list,function(item,i){
                  var sel=""
                 if(id==i.pincode){
                     sel="selected";
                 }
                $('#postal_code_name').append('<option value="'+i.pincode+'"'+sel+'>'+i.pincode+'</option>');
             });
                
            });
   };
        var country_id="{{$edit_data['country']}}" ; 
        var state_id="{{$edit_data['state']}}" ;
        var city_id="{{$edit_data['city']}}" ;
        var pincode_id="{{$edit_data['postal_code']}}" ;
        
      getState(state_id);
      getCity(city_id);
      getPincode(pincode_id);
   
   
 </script>
        