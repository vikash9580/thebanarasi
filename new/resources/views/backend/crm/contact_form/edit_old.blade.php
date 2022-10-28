@extends('backend.layouts.app')

@section('content')

<div class="col-lg-6 mx-auto">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6">{{translate('Update')}}</h5>
        </div>

        <form class="form-horizontal" action="{{ route('contact.update', $SellerDetails->id) }}" method="POST" enctype="multipart/form-data">
            <input name="_method" type="hidden" value="PATCH">
        	@csrf
            <div class="card-body">
                <h6 class="text-center">{{ translate('Seller Information')}}</h6>
                <div class="form-group row">
                    <label class="col-sm-3 col-from-label" for="name">{{translate('Name')}}</label>
                    <div class="col-sm-9">
                        <input type="text" placeholder="{{translate('Name')}}" id="name" name="name" class="form-control" value="{{ $SellerDetails->user->name }}" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-from-label" for="name">{{translate('Seller Type')}}</label>
                    <div class="col-sm-9">
                        <select name="user_type" required class="form-control aiz-selectpicker">
                           <option value="reseller" @php if($SellerDetails->user->user_type == "reseller") echo "selected"; @endphp>Reseller</option>
                           <option value="wholesaler" @php if($SellerDetails->user->user_type == "wholesaler") echo "selected"; @endphp>Wholesaler</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-from-label" for="email">{{translate('Email')}}</label>
                    <div class="col-sm-9">
                        <input type="text" placeholder="{{translate('Email')}}" id="email" name="email" class="form-control" value="{{$SellerDetails->user->email}}" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-from-label" for="mobile1">{{translate('Phone 1')}}</label>
                    <div class="col-sm-9">
                        <input type="text" placeholder="{{translate('Phone 1')}}" id="mobile1" name="mobile1" class="form-control" value="{{$SellerDetails->phone1}}" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-from-label" for="mobile2">{{translate('Phone 2')}}</label>
                    <div class="col-sm-9">
                        <input type="text" placeholder="{{translate('Phone 2')}}" id="mobile2" name="mobile2" class="form-control" value="{{$SellerDetails->phone2}}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-from-label" for="whatsapp_number">{{translate('Whatsapp Number')}}</label>
                    <div class="col-sm-9">
                        <input type="text" placeholder="{{translate('Whatsapp Number')}}" id="whatsapp_number" name="whatsapp_number" class="form-control" value="{{$SellerDetails->whatsapp_number}}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-from-label" for="city">{{translate('Gender')}}</label>
                    <div class="col-sm-9">
                        <input type="radio" name="gender" value="male" @php if($SellerDetails->gender == "male") echo "checked"; @endphp > Male
                        <br>
                        <input type="radio" name="gender" value="female" @php if($SellerDetails->gender == "female") echo "checked"; @endphp > Female
                        
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-from-label" for="dob">{{translate('DOB')}}</label>
                    <div class="col-sm-9">
                        <input type="date" placeholder="{{translate('DOB')}}" id="dob" name="dob" class="form-control" value="{{$SellerDetails->dob}}" >
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-from-label" for="profession">{{translate('Profession')}}</label>
                    <div class="col-sm-9">
                        <input type="text" placeholder="{{translate('Profession')}}" id="profession" name="profession" class="form-control" value="{{$SellerDetails->profession}}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-from-label" for="contact_position">{{translate('Contact Position')}}</label>
                    <div class="col-sm-9">
                        <input type="text" placeholder="{{translate('Contact Position')}}" id="contact_position" name="contact_position" class="form-control" value="{{$SellerDetails->contact_position}}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-from-label" for="website">{{translate('Website')}}</label>
                    <div class="col-sm-9">
                        <input type="text" placeholder="{{translate('Website')}}" id="website" name="website" class="form-control" value="{{$SellerDetails->website}}">
                    </div>
                </div>
                <h6 class="text-center">{{translate('Address')}}</h6>
                <div class="form-group row">
                    <label class="col-sm-3 col-from-label" for="street">{{translate('Street Address')}}</label>
                    <div class="col-sm-9">
                        <input type="text" placeholder="{{translate('Street Address')}}" id="street_address" name="street_address" class="form-control" value="{{$SellerDetails->street_address}}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-from-label" for="city">{{translate('City')}}</label>
                    <div class="col-sm-9">
                        <input type="text" placeholder="{{translate('City')}}" id="city" name="city" class="form-control" value="{{$SellerDetails->city}}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-from-label" for="state">{{translate('State')}}</label>
                    <div class="col-sm-9">
                        <input type="text" placeholder="{{translate('State')}}" id="state" name="state" class="form-control" value="{{$SellerDetails->state}}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-from-label" for="country">{{translate('Country')}}</label>
                    <div class="col-sm-9">
                        <input type="text" placeholder="{{translate('Country')}}" id="country" name="country" class="form-control" value="{{$SellerDetails->country}}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-from-label" for="pincode">{{translate('Zip Code / Pincode')}}</label>
                    <div class="col-sm-9">
                        <input type="text" placeholder="{{translate('Zip Code / Pincode')}}" id="pincode" name="pincode" class="form-control" value="{{$SellerDetails->pincode}}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-from-label" for="delivery_address">{{translate('Delivery Address')}}</label>
                    <div class="col-sm-9">
                        <input type="text" placeholder="{{translate('Delivery Address')}}" id="delivery_address" name="delivery_address" class="form-control" value="{{$SellerDetails->delivery_address}}">
                    </div>
                </div>
                <h6 class="text-center">{{translate('Social Media Links')}}</h6>
                <div class="form-group row">
                    <label class="col-sm-3 col-from-label" for="facebook">{{translate('Facebook')}}</label>
                    <div class="col-sm-9">
                        <input type="text" placeholder="{{translate('Facebook')}}" id="facebook" name="facebook" class="form-control" value="{{$SellerDetails->facebook}}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-from-label" for="instagram">{{translate('Instagram')}}</label>
                    <div class="col-sm-9">
                        <input type="text" placeholder="{{translate('Instagram')}}" id="instagram" name="instagram" class="form-control" value="{{$SellerDetails->instagram}}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-from-label" for="twitter">{{translate('Twitter')}}</label>
                    <div class="col-sm-9">
                        <input type="text" placeholder="{{translate('Twitter')}}" id="twitter" name="twitter" class="form-control" value="{{$SellerDetails->twitter}}">
                    </div>
                </div>
                <h6 class="text-center">{{translate('Other Information')}}</h6>
                <div class="form-group row">
                    <label class="col-sm-3 col-from-label" for="anniversary">{{translate('Anniversary')}}</label>
                    <div class="col-sm-9">
                        <input type="date" placeholder="{{translate('Anniversary')}}" id="anniversary" name="anniversary" class="form-control" value="{{$SellerDetails->anniversary}}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-from-label" for="business_name">{{translate('Business Name')}}</label>
                    <div class="col-sm-9">
                        <input type="text" placeholder="{{translate('Business Name')}}" id="business_name" name="business_name" class="form-control" value="{{$SellerDetails->business_name}}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-from-label" for="name">{{translate('Tax ID Type')}}</label>
                    <div class="col-sm-9">
                        <select name="tax_id_type" class="form-control aiz-selectpicker">
                           <option value="pan" @php if($SellerDetails->tax_id_type == "pan") echo "selected"; @endphp>PAN</option>
                           <option value="gst" @php if($SellerDetails->tax_id_type == "gst") echo "selected"; @endphp>GST</option>
                           <option value="other" @php if($SellerDetails->tax_id_type == "other") echo "selected"; @endphp>Other</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-from-label" for="tax_id">{{translate('Tax ID')}}</label>
                    <div class="col-sm-9">
                        <input type="text" placeholder="{{translate('Tax ID')}}" id="tax_id" name="tax_id" class="form-control" value="{{$SellerDetails->tax_id}}">
                    </div>
                </div>

                <h6 class="text-center">{{translate('Follow Up')}}</h6>
                @if(!empty($SellerDetails['interested_product']))
                @php
                    $in_product=json_decode($SellerDetails['interested_product']);
                @endphp
                
                <div class="form-group row">
                    <label for="" class="col-sm-3 col-from-label">Interested Product</label>
                    <div class="col-sm-9">
                        <ul>
                            @foreach ($in_product as $ip)
                                @php $allproduct = App\Product::where('id', $ip)->first(); @endphp
                                <li>{{$allproduct->name}}</li>
                            @endforeach
                        </ul>
                        
                    </div>
                </div>
                @endif

                <div class="form-group row mb-3">
                    <label class="col-sm-3 control-label" for="products">{{translate('Product')}}</label>
                    
                    <div class="col-sm-9">
                        <select name="products[]" id="products" class="form-control aiz-selectpicker" multiple data-placeholder="{{ translate('Choose Products') }}" data-live-search="true">
                            @foreach(\App\Product::orderBy('created_at', 'desc')->get() as $product)
                                <option value="{{$product->id}}" >{{ $product->getTranslation('name') }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-3 col-from-label">Date Of Last Contact</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="start" name="last_date" value="@if(isset($SellerDetails['last_date'])){{ $SellerDetails['last_date'] }}@endif" readonly> 
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-3 col-from-label">Date Of Next Contact</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="end" name="next_date" value="@if(isset($SellerDetails['next_date'])){{ $SellerDetails['next_date'] }}@endif" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-from-label" for="status_of_lead">{{translate('Status Of Lead')}}</label>
                    <div class="col-sm-9">
                        <select class="form-control aiz-selectpicker" name="status_of_lead">
                            <option selected disabled value="">-- Select --</option>
                            <option value="Attempted to contact" @if(isset($SellerDetails['status_of_lead']) && $SellerDetails['status_of_lead']== 'Attempted to contact'){{ 'selected' }}@endif>Attempted to contact</option>
                            <option value="Contact in future" @if(isset($SellerDetails['status_of_lead']) && $SellerDetails['status_of_lead']== 'Contact in future'){{ 'selected' }}@endif>Contact in future</option>
                            <option value="Contacted" @if(isset($SellerDetails['status_of_lead']) && $SellerDetails['status_of_lead']== 'Contacted'){{ 'selected' }}@endif>Contacted</option>
                            <option value="Junk lead" @if(isset($SellerDetails['status_of_lead']) && $SellerDetails['status_of_lead']== 'Junk lead'){{ 'selected' }}@endif>Junk lead</option>
                            <option value="Lost lead" @if(isset($SellerDetails['status_of_lead']) && $SellerDetails['status_of_lead']== 'Lost lead'){{ 'selected' }}@endif>Lost lead</option>
                            <option value="Not contacted" @if(isset($SellerDetails['status_of_lead']) && $SellerDetails['status_of_lead']== 'Not contacted'){{ 'selected' }}@endif>Not contacted</option>  
                            <option value="Pre-qualified" @if(isset($SellerDetails['status_of_lead']) && $SellerDetails['status_of_lead']== 'Pre-qualified'){{ 'selected' }}@endif>Pre-qualified</option>
                            <option value="Not qualified" @if(isset($SellerDetails['status_of_lead']) && $SellerDetails['status_of_lead']== 'Not qualified'){{ 'selected' }}@endif>Not qualified</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 col-from-label" for="source_of_lead">{{translate('Source Of Lead')}}</label>
                    <div class="col-sm-9">
                        <select class="form-control aiz-selectpicker" name="source_of_lead">
                            <option selected disabled value="">-- Select --</option>
                            <option value="Sales Team" @if(isset($SellerDetails['source_of_lead']) && $SellerDetails['source_of_lead']== 'Sales Team'){{ 'selected' }}@endif>Sales Team</option>
                            <option value="Social Media" @if(isset($SellerDetails['source_of_lead']) && $SellerDetails['source_of_lead']== 'Social Media'){{ 'selected' }}@endif>Social Media</option>
                            <option value="Telecalling" @if(isset($SellerDetails['source_of_lead']) && $SellerDetails['source_of_lead']== 'Telecalling'){{ 'selected' }}@endif>Telecalling</option>
                            <option value="Whatsapp" @if(isset($SellerDetails['source_of_lead']) && $SellerDetails['source_of_lead']== 'Whatsapp'){{ 'selected' }}@endif>Whatsapp</option>
                            <option value="Referral" @if(isset($SellerDetails['source_of_lead']) && $SellerDetails['source_of_lead']== 'Referral'){{ 'selected' }}@endif>Referral</option>
                            <option value="Facebook Ads" @if(isset($SellerDetails['source_of_lead']) && $SellerDetails['source_of_lead']== 'Facebook Ads'){{ 'selected' }}@endif>Facebook Ads</option>
                            <option value="Google Ads" @if(isset($SellerDetails['source_of_lead']) && $SellerDetails['source_of_lead']== 'Google Ads'){{ 'selected' }}@endif>Google Ads</option>  
                            <option value="Website" @if(isset($SellerDetails['source_of_lead']) && $SellerDetails['source_of_lead']== 'Website'){{ 'selected' }}@endif>Website</option>
                            <option value="App" @if(isset($SellerDetails['source_of_lead']) && $SellerDetails['source_of_lead']== 'App'){{ 'selected' }}@endif>App</option>
                            <option value="Self Visit" @if(isset($SellerDetails['source_of_lead']) && $SellerDetails['source_of_lead']== 'Self Visit'){{ 'selected' }}@endif>Self Visit</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 col-from-label" for="remark">{{translate('Remarks')}}</label>
                    <div class="col-sm-9">
                        <textarea class="form-control" id="remark" name="remark">{{$SellerDetails->remark}}</textarea>
                        {{-- <input type="text" placeholder="{{translate('Remark')}}" id="remark" name="remark" class="form-control" value="{{$SellerDetails->remark}}"> --}}
                    </div>
                </div>

                {{-- <div class="col-lg-6 mx-auto" onclick="add_new_address()">
                    <div class="border p-3 rounded mb-3 c-pointer text-center bg-light">
                        <i class="la la-plus la-2x"></i>
                        <div class="alpha-7">{{ translate('Add New Address') }}</div>
                    </div>
                </div> --}}
                <div class="form-group mb-0 text-right">
                    <button type="submit" class="btn btn-sm btn-primary">{{translate('Save')}}</button>
                </div>
            </div>
        </form>

    </div>
</div>

@endsection

@section('modal')
    <div class="modal fade" id="new-address-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ translate('New Address') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="form-default" role="form" action="{{ route('addresses.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="p-3">
                            <div class="row">
                                <label class="col-md-2 col-form-label">{{ translate('Address') }}</label>
                                <div class="col-md-10">
                                    <textarea class="form-control  mb-3" placeholder="{{ translate('Your Address') }}" rows="1" name="address" required></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-2 col-form-label">{{ translate('Country') }}</label>
                                <div class="col-md-10">
                                    <div class="mb-3">
                                        <select class="form-control aiz-selectpicker" data-live-search="true" data-placeholder="{{translate('Select your country')}}" name="country" id="countries_name" required>
                                            @foreach (\App\Country::where('status', 1)->get() as $key => $country)
                                                <option value="{{ $country->name }}">{{ $country->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                              <div class="row">
                            <div class="col-md-2">
                                <label>{{ translate('State')}}</label>
                            </div>
                            <div class="col-md-10">
                                <select class="form-control mb-3 aiz-selectpicker" data-live-search="true" name="state" id="state_name" required>
                                   
                                </select>
                            </div>
                        </div>
                      <div class="row">
                            <div class="col-md-2">
                                <label>{{ translate('City')}}</label>
                            </div>
                            <div class="col-md-10">
                                <select class="form-control mb-3 aiz-selectpicker" data-live-search="true" name="city"  id="city_name" required>
                                    
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <label>{{ translate('Pincode')}}</label>
                            </div>
                            <div class="col-md-10">
                                <select class="form-control mb-3 aiz-selectpicker" data-live-search="true" name="postal_code"  id="postal_code_name" required>
                                   
                                </select>
                            </div>
                        </div>
                            <div class="row">
                                <label class="col-md-2 col-form-label">{{ translate('Phone') }}</label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control mb-3" placeholder="{{ translate('Your phone number')}}" name="phone" value="" title="Start With 6,7,8,9 (Contain 10 Digits)"  pattern="[6789][0-9]{9}" required>
                                    @error('phone')
	                                 <p style="color:red;">Start With 6,7,8,9 (Contain 10 Digits)</p>
                                     @enderror
                                </div>
                            </div>
                            <div class="form-group text-right">
                                <button type="submit" class="btn btn-sm btn-primary">{{translate('Save')}}</button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection

@section('script')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datepicker/1.0.10/datepicker.min.css" integrity="sha512-YdYyWQf8AS4WSB0WWdc3FbQ3Ypdm0QCWD2k4hgfqbQbRCJBEgX0iAegkl2S1Evma5ImaVXLBeUkIlP6hQ1eYKQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> 
<script type="text/javascript">
    $('#start').datepicker({
        maxDate:new Date,
        // maxDate: '<?php echo $SellerDetails['next_date']; ?>',
        onSelect: function(dateText, inst){
            $('#end').datepicker('option', 'minDate', new Date(dateText));
        },
    });

    $('#end').datepicker({
        //minDate: '<?php echo $SellerDetails['last_date']; ?>',
        minDate: new Date,
        onSelect: function(dateText, inst){
            $('#start').datepicker('option', 'maxDate', new Date(dateText));
        }
    });
    
</script>

<script type="text/javascript">
    function add_new_address(){
        $('#new-address-modal').modal('show');
    }

    $('.new-email-verification').on('click', function() {
        $(this).find('.loading').removeClass('d-none');
        $(this).find('.default').addClass('d-none');
        var email = $("input[name=email]").val();

        $.post('{{ route('user.new.verify') }}', {_token:'{{ csrf_token() }}', email: email}, function(data){
            data = JSON.parse(data);
            $('.default').removeClass('d-none');
            $('.loading').addClass('d-none');
            if(data.status == 2)
                AIZ.plugins.notify('warning', data.message);
            else if(data.status == 1)
                AIZ.plugins.notify('success', data.message);
            else
                AIZ.plugins.notify('danger', data.message);
        });
    });
    
    
    $(document).ready(function(){
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
           
           $('#city_name').empty();
            $('#city_name').append('<option value="">Select City</option>');
             $.each(data.list,function(item,i){
                $('#city_name').append('<option value="'+i.city_name+'">'+i.city_name+'</option>');
             });
                
            });
      
      
  })


  $('#city_name').change(function() {
      
     var city_name= $('#city_name').val(); 
     $.post('{{ route('addresses.pincode_list') }}', {_token:'{{ csrf_token() }}', id:city_name}, function(data){
           
           $('#postal_code_name').empty();
            $('#postal_code_name').append('<option value="">Select Pincode</option>');
             $.each(data.list,function(item,i){
                $('#postal_code_name').append('<option value="'+i.pincode+'">'+i.pincode+'</option>');
             });
                
            });
  })
});
</script>


<script type="text/javascript">
    $(document).ready(function(){
        var total = 0;
        $('#products').on('change', function(){
            var product_ids = $('#products').val();
            //console.log(product_ids);
            if(product_ids.length > 0){
                $.post('{{ route('crm.variant') }}', {_token:'{{ csrf_token() }}', product_ids:product_ids}, function(data){
                    //console.log(data.variants);
                        $.each(data.variants,function(key,value){
                            $("#variant").append('<option value="'+value.id+'">'+value.variant+'</option>');
                        });
                    $('#product_table').html(data);
                    //$(".aiz-selectpicker").selectpicker();
                });
            }
            else{
                $("#variant").empty();
                $('#product_table').html(null);
               
            }
        });
        
        $('#variant').on('change', function(){
            var variant_ids = $('#variant').val();
            
            //console.log(variant_ids);

            if(variant_ids.length > 0){
                $.post('{{ route('crm.allproducts') }}', {_token:'{{ csrf_token() }}', variant_ids:variant_ids}, function(data){
                    
                    if(data.products){
                        //console.log(data.i);
                        var wdp = 0;
                        
                        // $('#product_table').append('<table class="table table-bordered"><tbody><tr><td><div class="from-group row"><div class="col-sm-5"><label for="" class="col-from-label">'+data.products.name+'</label></div></div></td><td><input type="number" name="wholesale_unit[]" id="wholesale_unit_'+ data.i +'"value="'+data.products.wholesale_unit_price+'" min="0" step="1" class="form-control all_'+ data.i +'"required></td><td><input type="number" name="wholesale_discount[]" id="wd_'+ data.i +'"value="'+data.products.wholesale_discount+'" min="0" step="1" class="form-control all_'+ data.i +'"required></td><td><select class="form-control aiz-selectpicker all_'+ data.i +'" name="wholesale_discount_type[]"id="wholesale_discount_type_'+data.i+'"><option value="0" selected disabled>Select</option><option value="$">$</option><option value="%">%</option></select></td><td><input type="number" name="wholesale_quintity[]" id="wholesale_quintity_'+data.i+'" min="0" step="1"class="form-control all_'+ data.i +'" value="1"></td><td><input type="number" name="wholesale_discount_price[]" id="wholesale_discount_price_'+data.i+'" min="0"step="1" class="form-control all_'+ data.i +'" required></td></tr></tbody></table>');
                        $('#product_table').append('<tr><td><div class="from-group row"><div class="col-sm-5"><label for="" class="col-from-label">'+data.products.name+'</label></div></div></td><td><input type="number" name="wholesale_unit[]" id="wholesale_unit_'+ data.i +'" value="'+data.products.wholesale_unit_price+'" min="0" step="1" class="form-control all_'+ data.i +'"required></td><td><input type="number" name="wholesale_discount[]" id="wd_'+ data.i +'"value="'+data.products.wholesale_discount+'" min="0" step="1" class="form-control all_'+ data.i +'"required></td><td><select class="form-control aiz-selectpicker all_'+ data.i +'" name="wholesale_discount_type[]"id="wholesale_discount_type_'+data.i+'"><option value="$">$</option><option value="%">%</option></select></td><td><input type="number" name="wholesale_quintity[]" id="wholesale_quintity_'+data.i+'" min="0" step="1"class="form-control all_'+ data.i +'" value="1"><select class="form-control aiz-selectpicker all_'+ data.i +'" name="type[]" id="type_'+data.i+'"><option value="meters">Meters</option><option value="pieces">Pieces</option></select></td><td><input type="number" name="wholesale_discount_price[]" id="wholesale_discount_price_'+data.i+'" value="'+data.products.wholesale_unit_price+'" min="0"step="1" class="form-control all_'+ data.i +'" required></td></tr>');
                            final_total();

                        $(".all_"+data.i).on('change', function(){
                            var wholesale_unit = $('#wholesale_unit_'+data.i).val();
                            var wd = $('#wd_'+data.i).val();
                            var wholesale_discount_type =$('#wholesale_discount_type_'+data.i).val();
                            var whole_quintity = $('#wholesale_quintity_'+data.i).val();
                            var final_total1 = $('#total').val();
                            //$('#total').val(' ');
                            final_total();
                            
                            if(wholesale_discount_type=="$"){
                                var wdp1 = wholesale_unit - wd;
                                wdp = wdp1 * whole_quintity;
                                $("#wholesale_discount_price_"+data.i).val(wdp);
                                total =  parseFloat(total) + parseFloat(wdp);
                                //$('#total').val(total);
                                final_total();
                                
                            }
                            if(wholesale_discount_type=="%"){
                                var wper = wholesale_unit / 100 * wd;
                                wdp1 = wholesale_unit - wper;
                                wdp = wdp1 * whole_quintity;
                                $("#wholesale_discount_price_"+data.i).val(wdp);
                                total =  parseFloat(total) + parseFloat(wdp);
                                //$('#total').val(total);
                                final_total();
                               
                            }
                            
                        });
                    }
                });
            }else{
                $('#product_table').html(null);
            }
        });
        $('#courier_charge').change(function(){
            var courier_charge = $('#courier_charge').val();
            console.log(courier_charge);
            total = parseFloat(total) + parseFloat(courier_charge);
            $('#total').val(total); 
        });
        
        function final_total() {
            total_new=0;
            $('input[name="wholesale_discount_price[]"]').each(function() {
                total_new=parseInt(total_new)+parseInt($(this).val());
                $('#total').val(total_new); 
       
            });

        }
    });
</script>
@endsection

