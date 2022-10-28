@extends('backend.layouts.app')

@section('content')

<div class="col-lg-12 mx-auto">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6">{{translate('Update Seller')}}</h5>
        </div>

        <form class="form-horizontal" action="{{ route('crm.update', $SellerDetails->id) }}" method="POST" enctype="multipart/form-data">
            <input name="_method" type="hidden" value="PATCH">
        	@csrf
            <div class="card-body">
                
                <div class="row">
                <div class="col-sm-12">
                    <h6>{{ translate('Seller Information')}}</h6>
                </div>
                
                 <div class="col-sm-3">
                <div class="form-group">
                    <label class="col-from-label" for="name">{{translate('Name')}}</label>
                        <input type="text" placeholder="{{translate('Name')}}" id="name" name="name" class="form-control" value="{{ $SellerDetails->user->name }}" required>
                    </div>
                </div>
                 <div class="col-sm-3">
                <div class="form-group">
                    <label class="col-from-label" for="name">{{translate('Seller Type')}}</label>
                        <select name="user_type" required class="form-control aiz-selectpicker">
                           <option value="reseller" @php if($SellerDetails->user->user_type == "reseller") echo "selected"; @endphp>Reseller</option>
                           <option value="wholesaler" @php if($SellerDetails->user->user_type == "wholesaler") echo "selected"; @endphp>Wholesaler</option>
                        </select>
                    </div>
                </div>
                
                 <div class="col-sm-3">
                <div class="form-group">
                    <label class="col-from-label" for="email">{{translate('Email')}}</label>
                        <input type="email" placeholder="{{translate('Email')}}" id="email" name="email" class="form-control" value="{{$SellerDetails->user->email}}" required>
                    </div>
                </div>
                 <div class="col-sm-3">
                <div class="form-group">
                    <label class="col-from-label" for="mobile1">{{translate('Phone 1')}}</label>
                        <input type="number" placeholder="{{translate('Phone 1')}}" id="mobile1" name="mobile1" class="form-control" value="{{$SellerDetails->phone1}}" required>
                    </div>
                </div>
                 <div class="col-sm-3">
                <div class="form-group">
                    <label class="col-from-label" for="mobile2">{{translate('Phone 2')}}</label>
                        <input type="number" placeholder="{{translate('Phone 2')}}" id="mobile2" name="mobile2" class="form-control" value="{{$SellerDetails->phone2}}">
                    </div>
                </div>
                 <div class="col-sm-3">
                <div class="form-group">
                    <label class="col-from-label" for="whatsapp_number">{{translate('Whatsapp Number')}}</label>
                        <input type="number" placeholder="{{translate('Whatsapp Number')}}" id="whatsapp_number" name="whatsapp_number" class="form-control" value="{{$SellerDetails->whatsapp_number}}">
                    </div>
                </div>
                 <div class="col-sm-3">
                <div class="form-group">
                    <label class="col-from-label" for="city">{{translate('Gender')}}</label>
                    <br>
                        <input type="radio" name="gender" value="male" @php if($SellerDetails->gender == "male") echo "checked"; @endphp > Male
                        
                        <input type="radio" name="gender" value="female" @php if($SellerDetails->gender == "female") echo "checked"; @endphp > Female
                        
                    </div>
                </div>
                 <div class="col-sm-3">
                <div class="form-group">
                    <label class="col-from-label" for="dob">{{translate('DOB')}}</label>
                        <input type="date" placeholder="{{translate('DOB')}}" id="dob" name="dob" class="form-control" value="{{$SellerDetails->dob}}" >
                    </div>
                </div>
                 <div class="col-sm-3">
                <div class="form-group">
                    <label class="col-from-label" for="profession">{{translate('Profession')}}</label>
                        <input type="text" placeholder="{{translate('Profession')}}" id="profession" name="profession" class="form-control" value="{{$SellerDetails->profession}}">
                    </div>
                </div>
                 <div class="col-sm-3">
                <div class="form-group">
                    <label class="col-from-label" for="contact_position">{{translate('Contact Position')}}</label>
                        <input type="text" placeholder="{{translate('Contact Position')}}" id="contact_position" name="contact_position" class="form-control" value="{{$SellerDetails->contact_position}}">
                    </div>
                </div>
                 <div class="col-sm-3">
                <div class="form-group">
                    <label class="col-from-label" for="website">{{translate('Website')}}</label>
                        <input type="text" placeholder="{{translate('Website')}}" id="website" name="website" class="form-control" value="{{$SellerDetails->website}}">
                    </div>
                </div>
                
                 <div class="col-sm-12">
                <h6>{{translate('Address')}}</h6>
                </div>
                 <div class="col-sm-3">
                <div class="form-group">
                    <label class="col-from-label" for="street">{{translate('Street Address')}}</label>
                        <input type="text" placeholder="{{translate('Street Address')}}" id="street_address" name="street_address" class="form-control" value="{{$SellerDetails->street_address}}">
                    </div>
                </div>
                
                 <div class="col-sm-3">
                <div class="form-group">
                    <label class="col-from-label" for="city">{{translate('City')}}</label>
                        <input type="text" placeholder="{{translate('City')}}" id="city" name="city" class="form-control" value="{{$SellerDetails->city}}">
                    </div>
                </div>
                 <div class="col-sm-3">
                <div class="form-group">
                    <label class="col-from-label" for="state">{{translate('State')}}</label>
                        <input type="text" placeholder="{{translate('State')}}" id="state" name="state" class="form-control" value="{{$SellerDetails->state}}">
                    </div>
                </div>
                 <div class="col-sm-3">
                <div class="form-group">
                    <label class="col-from-label" for="country">{{translate('Country')}}</label>
                        <input type="text" placeholder="{{translate('Country')}}" id="country" name="country" class="form-control" value="{{$SellerDetails->country}}">
                    </div>
                </div>
                
                 <div class="col-sm-3">
                <div class="form-group">
                    <label class="col-from-label" for="pincode">{{translate('Zip Code / Pincode')}}</label>
                        <input type="text" placeholder="{{translate('Zip Code / Pincode')}}" id="pincode" name="pincode" class="form-control" value="{{$SellerDetails->pincode}}">
                    </div>
                </div>
                
                 <div class="col-sm-3">
                <div class="form-group">
                    <label class="col-from-label" for="delivery_address">{{translate('Delivery Address')}}</label>
                        <input type="text" placeholder="{{translate('Delivery Address')}}" id="delivery_address" name="delivery_address" class="form-control" value="{{$SellerDetails->delivery_address}}">
                    </div>
                </div>
                
                 <div class="col-sm-12">
                <h6>{{translate('Social Media Links')}}</h6>
                </div>
                
                 <div class="col-sm-3">
                <div class="form-group">
                    <label class="col-from-label" for="facebook">{{translate('Facebook')}}</label>
                        <input type="text" placeholder="{{translate('Facebook')}}" id="facebook" name="facebook" class="form-control" value="{{$SellerDetails->facebook}}">
                    </div>
                </div>
                 <div class="col-sm-3">
                <div class="form-group">
                    <label class="col-from-label" for="instagram">{{translate('Instagram')}}</label
                        <input type="text" placeholder="{{translate('Instagram')}}" id="instagram" name="instagram" class="form-control" value="{{$SellerDetails->instagram}}">
                    </div>
                </div>
                 <div class="col-sm-3">
                <div class="form-group">
                    <label class="col-from-label" for="twitter">{{translate('Twitter')}}</label>
                        <input type="text" placeholder="{{translate('Twitter')}}" id="twitter" name="twitter" class="form-control" value="{{$SellerDetails->twitter}}">
                    </div>
                </div>
                 <div class="col-sm-12">
                <h6>{{translate('Other Information')}}</h6>
                </div>
                 <div class="col-sm-3">
                <div class="form-group">
                    <label class="col-from-label" for="anniversary">{{translate('Anniversary')}}</label>
                        <input type="date" placeholder="{{translate('Anniversary')}}" id="anniversary" name="anniversary" class="form-control" value="{{$SellerDetails->anniversary}}">
                    </div>
                </div>
                 <div class="col-sm-3">
                <div class="form-group">
                    <label class="col-from-label" for="business_name">{{translate('Business Name')}}</label>
                        <input type="text" placeholder="{{translate('Business Name')}}" id="business_name" name="business_name" class="form-control" value="{{$SellerDetails->business_name}}">
                    </div>
                </div>
                 <div class="col-sm-3">
                <div class="form-group">
                    <label class="col-from-label" for="name">{{translate('Tax ID Type')}}</label>
                        <select name="tax_id_type" class="form-control aiz-selectpicker">
                           <option value="pan" @php if($SellerDetails->tax_id_type == "pan") echo "selected"; @endphp>PAN</option>
                           <option value="gst" @php if($SellerDetails->tax_id_type == "gst") echo "selected"; @endphp>GST</option>
                           <option value="other" @php if($SellerDetails->tax_id_type == "other") echo "selected"; @endphp>Other</option>
                        </select>
                    </div>
                </div>
                 <div class="col-sm-3">
                <div class="form-group">
                    <label class="col-from-label" for="tax_id">{{translate('Tax ID')}}</label>
                        <input type="text" placeholder="{{translate('Tax ID')}}" id="tax_id" name="tax_id" class="form-control" value="{{$SellerDetails->tax_id}}">
                    </div>
                </div>
                {{-- <div class="col-lg-6 mx-auto" onclick="add_new_address()">
                    <div class="border p-3 rounded mb-3 c-pointer text-center bg-light">
                        <i class="la la-plus la-2x"></i>
                        <div class="alpha-7">{{ translate('Add New Address') }}</div>
                    </div>
                </div> --}}
                 <div class="col-sm-12">
                <div class="form-group mb-0 text-right">
                    <button type="submit" class="btn btn-sm btn-primary">{{translate('Save')}}</button>
                    </div>
                </div>
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
@endsection

