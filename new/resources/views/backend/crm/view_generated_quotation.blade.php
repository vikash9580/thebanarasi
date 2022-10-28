@extends('backend.layouts.app')

@section('content')

<div class="col-lg-10 mx-auto">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6">{{translate('Generated Quotation')}}</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('crm.ordernow') }}" method="POST">
                @csrf
                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}" class="form-control">
                <input type="hidden" name="reseller_id" value="{{ $quotation[0]->reseller->id }}" class="form-control">
                <div class="form-group row">
                    <label class="col-sm-3 control-label" for="name">{{translate('Quotation Title')}}</label>
                    <div class="col-sm-9">
                        <input type="text" placeholder="{{translate('Quotation Title')}}" id="name" name="title" class="form-control" value="{{ $quotation[0]->quotation_name }}" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 control-label" for="name">{{translate('Quotation Number')}}</label>
                    <div class="col-sm-9">
                        <input type="text" placeholder="{{translate('Quotation ID')}}" id="name" name="quotation_number" class="form-control" value="{{ $quotation[0]->quotation_number }}" readonly>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 control-label" for="name">{{translate('Seller Name')}}</label>
                    <div class="col-sm-9">
                        <input type="text" placeholder="{{translate('Seller Name')}}" id="name" name="seller_name" class="form-control" value="{{ $quotation[0]->reseller->name }}" disabled>
                    </div>
                </div>
                
                <div class="form-group row">
                    <label class="col-sm-3 col-from-label" for="products">{{translate('Products')}}</label>
                    <div class="col-sm-9">
                        <select name="products[]" id="products" class="form-control aiz-selectpicker" multiple required data-placeholder="{{ translate('Choose Products') }}" data-live-search="true" disabled>
                            @foreach(\App\Product::all() as $product)
                                @php
                                    $flash_deal_product = \App\Quotation::where('quotation_number', $quotation[0]->quotation_number)->where('product_id', $product->id)->first();
                                @endphp
                                <option value="{{$product->id}}" <?php if($flash_deal_product != null) echo "selected";?> >{{ $product->getTranslation('name') }}</option>
                            @endforeach
                        </select>
                        @foreach($quotation as $quotat)
                            <input type="hidden" name="products[]" value="{{$quotat->product_id}}">
                        @endforeach
                    </div>
                </div>
                <div class="form-group row md-3" id="variant_data">
                    <label class="col-sm-3 control-label" for="variant_data">{{translate('Variant')}}</label>
                    <div class="col-sm-9"> 
                        <select class="form-control aiz-selectpicker" name="variant[]" id="variant" multiple required data-placeholder="{{ translate('Choose Products') }}" data-live-search="true" disabled>
                        @foreach (\App\ProductStock::all() as $variant)
                            @php
                                $variant_data = \App\Quotation::where('quotation_number', $quotation[0]->quotation_number)->where('variant_id', $variant->id)->get();
                            @endphp 
                            @foreach ( $variant_data as $data )
                                <option value="{{$variant->id}}" <?php if($data != null) echo "selected"; ?> >{{ $variant->variant }}</option>
                            @endforeach 
                        @endforeach   
                        </select>
                        @foreach($quotation as $quotat)
                            <input type="hidden" name="variant[]" value="{{$quotat->variant_id}}">
                        @endforeach
                    </div>
                </div>
                <br>
                <div class="form-group row" id="product_table">
                    <div class="col-sm-12">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <td class="text-center" width="40%"><label class="control-label">{{translate('Product')}}</label></td>
                                    <td class="text-center" width="15%"><label class="control-label">{{translate('Base Price')}}</label></td>
                                    <td class="text-center"><label class="control-label">{{translate('Discount')}}</label></td>
                                    <td class="text-center" width="15%"><label class="control-label">{{translate('DiscountType')}}</label></td>
                                    <td class="text-center" width="15%"><label class="control-label">{{translate('Quantity')}}</label></td>
                                    <td class="text-center" width="15%"><label class="control-label">{{translate('DiscountPrice')}}</label></td>
                                </tr>
                            </thead>
                                <tbody>
                                    @foreach ($quotation as $quotation_data)
                                        <tr>
                                            <td>
                                                <div class="from-group row">
                                                    <div class="col-sm-5"><label for="" class="col-from-label"> {{$quotation_data->product->name}}</label></div>
                                                </div>
                                            </td>
                                            <td><input type="number" name="wholesale_unit[]" id="wholesale_unit" min="0" step="1" class="form-control all" value="{{$quotation_data->base_price}}" required readonly></td>
                                            <td><input type="number" name="wholesale_discount[]" id="wd" min="0" step="1" class="form-control all" value="{{$quotation_data->wholesale_discount}}" required readonly></td>
                                            <td>
                                                <select class="form-control aiz-selectpicker all" name="wholesale_discount_type[]" id="wholesale_discount_type" disabled>
                                                    <option value="$" @if(isset($quotation_data['wholesale_discount_type']) && $quotation_data['wholesale_discount_type']== '$'){{ 'selected' }}@endif>$</option>
                                                    <option value="%" @if(isset($quotation_data['wholesale_discount_type']) && $quotation_data['wholesale_discount_type']== '%'){{ 'selected' }}@endif>%</option>
                                                </select>
                                                <input type="hidden"  name="wholesale_discount_type[]" value="{{$quotation_data['wholesale_discount_type']}}">
                                            </td>
                                            <td>
                                                <input type="number" name="wholesale_quintity[]" id="wholesale_quintity" min="0" step="1" class="form-control all" value="{{$quotation_data->wholesale_quintity}}" readonly>
                                                <select class="form-control aiz-selectpicker all" name="type[]" id="type" disabled>
                                                    <option value="meters" @if(isset($quotation_data['type']) && $quotation_data['type']== 'meters'){{ 'selected' }}@endif>Meters</option>
                                                    <option value="pieces" @if(isset($quotation_data['type']) && $quotation_data['type']== 'pieces'){{ 'selected' }}@endif>Pieces</option>
                                                </select>
                                                 <input type="hidden"  name="type[]" value="{{$quotation_data['type']}}">
                                            </td>
                                            <td><input type="number" name="wholesale_discount_price[]" id="wholesale_discount_price" min="0" step="1" class="form-control all" value="{{$quotation_data->wholesale_discount_price}}" required readonly></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                <div class="row">
                    <div class="col-md-3">
                        <label class="control-label" for="variant_data">{{translate('Delivery / Courier Charge')}}</label>
                        <div class="form-group">
                            <input type="text" placeholder="{{translate('Delivery / Courier Charge')}}" id="courier_charge" name="courier_charge" value="{{$quotation[0]->courier_charge}}" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-md-6"></div>
                    <div class="col-md-3">
                        <label class="control-label" for="variant_data">{{translate('Total')}}</label>
                        <div class="form-group">
                            
                            <input type="text" placeholder="{{translate('total')}}" id="total" name="total" class="form-control" value="{{$quotation[0]->total}}" readonly>
                        </div>
                    </div>
                </div>
                
                <div class="form-group row">
                    <label class="col-sm-3 control-label" for="name">{{translate('Delivery Date')}}</label>
                    <div class="col-sm-9">
                        <input type="date" placeholder="{{translate('Delivery Date')}}" id="delivery_date" name="delivery_date" class="form-control " >
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 control-label" for="name">{{translate('Remarks')}}</label>
                    <div class="col-sm-9">
                        <textarea class="form-control" name="remarks"></textarea>
                    </div>
                </div>
                <div class="shadow-sm p-4 rounded mb-4">
                    <div class="row gutters-5">
                        @php
                            $addresses = App\Address::where('user_id', $quotation[0]->reseller->id)->get();
                        @endphp
                        @foreach ($addresses as $key => $address)
                            <div class="col-md-6 mb-3">
                                <label class="aiz-megabox d-block mb-0">
                                    <input type="radio" name="address_id" value="{{ $address->id }}" checked required>
                                    <span class="d-flex p-3 border p-3 rounded mb-3 c-pointer bg-light">
                                        <span class="aiz-rounded-check flex-shrink-0 mt-1"></span>
                                        <span class="flex-grow-1 pl-3 text-left">
                                            <div>
                                                <span class="opacity-60">{{ translate('Address') }}:</span>
                                                <span class="fw-600 ml-2">{{ $address->address }}</span>
                                            </div>
                                            <div>
                                                <span class="opacity-60">{{ translate('Postal Code') }}:</span>
                                                <span class="fw-600 ml-2">{{ $address->postal_code }}</span>
                                            </div>
                                            <div>
                                                <span class="opacity-60">{{ translate('City') }}:</span>
                                                <span class="fw-600 ml-2">{{ $address->city }}</span>
                                            </div>
                                             <div>
                                                <span class="opacity-60">{{ translate('State') }}:</span>
                                                <span class="fw-600 ml-2">{{ $address->state }}</span>
                                            </div>
                                            <div>
                                                <span class="opacity-60">{{ translate('Country') }}:</span>
                                                <span class="fw-600 ml-2">{{ $address->country }}</span>
                                            </div>
                                            <div>
                                                <span class="opacity-60">{{ translate('Phone') }}:</span>
                                                <span class="fw-600 ml-2">{{ $address->phone }}</span>
                                            </div>
                                        </span>
                                    </span>
                                </label>
                            </div>
                        @endforeach
                        <input type="hidden" name="checkout_type" value="logged">
                        <div class="col-lg-6 mx-auto" onclick="add_new_address()">
                            <lable class="col-from-label">
                                <div class="border p-3 rounded mb-3 c-pointer text-center bg-light">
                                    <i class="la la-plus la-2x"></i>
                                    <div class="alpha-7">{{ translate('Add New Address') }}</div>
                                </div>
                            </lable>
                        </div>
                    </div>
                </div>
                @if(sizeof($addresses) > 0)
                    <div class="form-group mb-0 text-right">
                        <button type="submit" class="btn btn-primary">{{translate('Order Now')}}</button>
                    </div>
                @endif
            </form>
        </div>
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
                <form class="form-default" role="form" action="{{ route('crm.newaddress') }}" method="POST">
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
                                    <input type="text" class="form-control mb-3" placeholder="{{ translate('Your phone number')}}" name="phone" value="{{$quotation[0]->reseller->phone}}" title="Start With 6,7,8,9 (Contain 10 Digits)"  pattern="[6789][0-9]{9}" required>
                                    @error('phone')
	                                 <p style="color:red;">Start With 6,7,8,9 (Contain 10 Digits)</p>
                                     @enderror
                                </div>
                            </div>
                            <input type="hidden" name="customer_id" value="{{ $quotation[0]->reseller->id }}">
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
    $(document).ready(function(){
        var total = 0;
        $('#products').change(function() {
            var product_ids = $('#products').val();
             var variant_ids = $('#variant').val();
           
            //console.log(product_ids);
            if(product_ids.length > 0){
                $.post('{{ route('crm.variant') }}', {_token:'{{ csrf_token() }}', product_ids:product_ids,variant_ids:variant_ids}, function(data){
                    console.log(data);
                    $("#variant").empty();
                    
                    if(data.variants_ids!=''){
                        $.each(data.variants,function(key,value){
                             $.each(data.variants_ids,function(index,item){
                                 if(item==value.id){
                               $("#variant").append('<option value="'+value.id+'" selected >'+value.variant+'</option>');
                                 }
                                 
                                 if(item!=value.id){
                               $("#variant").append('<option value="'+value.id+'"  >'+value.variant+'</option>');
                                 } 
                                 
                             });
                        });
                    }else{
                        $.each(data.variants,function(key,value){
                            
                               $("#variant").append('<option value="'+value.id+'"  >'+value.variant+'</option>');
                           
                        });
                    }
                  
                    //$(".aiz-selectpicker").selectpicker();
                });
            }
            
            
        });
        
        $('#variant').change(function() {
            var variant_ids = $('#variant').val();
                
            //console.log(variant_ids);
        
            if(variant_ids.length > 0){
                $.post('{{ route('crm.allproducts') }}', {_token:'{{ csrf_token() }}', variant_ids:variant_ids}, function(data){
                    
                    if(data.products){
                        console.log(data);
                          $('#product_table').html(null);
                        var wdp = 0;
                        $.each(data.products,function(key,value){
                        // $('#product_table').append('<table class="table table-bordered"><tbody><tr><td><div class="from-group row"><div class="col-sm-5"><label for="" class="col-from-label">'+data.products.name+'</label></div></div></td><td><input type="number" name="wholesale_unit[]" id="wholesale_unit_'+ data.i +'"value="'+data.products.wholesale_unit_price+'" min="0" step="1" class="form-control all_'+ data.i +'"required></td><td><input type="number" name="wholesale_discount[]" id="wd_'+ data.i +'"value="'+data.products.wholesale_discount+'" min="0" step="1" class="form-control all_'+ data.i +'"required></td><td><select class="form-control aiz-selectpicker all_'+ data.i +'" name="wholesale_discount_type[]"id="wholesale_discount_type_'+data.i+'"><option value="0" selected disabled>Select</option><option value="$">$</option><option value="%">%</option></select></td><td><input type="number" name="wholesale_quintity[]" id="wholesale_quintity_'+data.i+'" min="0" step="1"class="form-control all_'+ data.i +'" value="1"></td><td><input type="number" name="wholesale_discount_price[]" id="wholesale_discount_price_'+data.i+'" min="0"step="1" class="form-control all_'+ data.i +'" required></td></tr></tbody></table>');
                        $('#product_table').append('<tr><td><div class="from-group row"><div class="col-sm-5"><label for="" class="col-from-label">'+value.name+'</label></div></div></td><td><input type="number" name="wholesale_unit[]" id="wholesale_unit_'+ key +'" value="'+value.wholesale_unit_price+'" min="0" step="1" class="form-control all_'+ key +'"required></td><td><input type="number" name="wholesale_discount[]" id="wd_'+ key +'"value="'+value.wholesale_discount+'" min="0" step="1" class="form-control all_'+ key +'"required></td><td><select class="form-control aiz-selectpicker all_'+ key +'" name="wholesale_discount_type[]"id="wholesale_discount_type_'+key+'"><option value="$">$</option><option value="%">%</option></select></td><td><input type="number" name="wholesale_quintity[]" id="wholesale_quintity_'+key+'" min="0" step="1"class="form-control all_'+ key +'" value="1"> <select class="form-control aiz-selectpicker all_'+ key +'" name="type[]" id="type_'+key+'"><option value="meters">Meters</option><option value="pieces">Pieces</option></select></td><td><input type="number" name="wholesale_discount_price[]" id="wholesale_discount_price_'+key+'" value="'+value.wholesale_unit_price+'" min="0"step="1" class="form-control all_'+ key +'" required></td></tr>');
                        
                            $(".all_"+key).on('change', function(){
                                var wholesale_unit = $('#wholesale_unit_'+key).val();
                                var wd = $('#wd_'+key).val();
                                var wholesale_discount_type =$('#wholesale_discount_type_'+key).val();
                                var whole_quintity = $('#wholesale_quintity_'+key).val();
                                var final_total1 = $('#total').val();
                                // $('#total').val(' ');
                                
                                if(wholesale_discount_type=="$"){
                                    var wdp1 = wholesale_unit - wd;
                                    wdp = wdp1 * whole_quintity;
                                    $("#wholesale_discount_price_"+key).val(wdp);
                                    total =  parseFloat(total) + parseFloat(wdp);
                                    // $('#total').val(total);
                                    final_total();
                                    
                                }
                                if(wholesale_discount_type=="%"){
                                    var wper = wholesale_unit / 100 * wd;
                                    wdp1 = wholesale_unit - wper;
                                    wdp = wdp1 * whole_quintity;
                                    $("#wholesale_discount_price_"+key).val(wdp);
                                    total =  parseFloat(total) + parseFloat(wdp);
                                    // $('#total').val(total);
                                    final_total();
                                   
                                }
                                
                            }); 
                            
                            
                        });
                        final_total();

                        
                    }
                });
            }else{
                $('#product_table').html(null);
            }
        });
        
        $('#courier_charge').change(function(){
           final_total();
        }); 
        
        
        function final_total() {
            total_new=0;
            $('input[name="wholesale_discount_price[]"]').each(function() {
                total_new=parseInt(total_new)+parseInt($(this).val());
                // $('#total').val(total_new); 
       
            });
            var courier_charge = $('#courier_charge').val();
             total = parseFloat(total_new) + parseFloat(courier_charge);
               $('#total').val(total); 
            
        }
    });
</script>

<script type="text/javascript">
    function add_new_address() {
        $('#new-address-modal').modal('show');
    }

    $('.new-email-verification').on('click', function () {
        $(this).find('.loading').removeClass('d-none');
        $(this).find('.default').addClass('d-none');
        var email = $("input[name=email]").val();

        $.post('{{ route('user.new.verify') }}', { _token: '{{ csrf_token() }}', email: email }, function (data) {
            data = JSON.parse(data);
            $('.default').removeClass('d-none');
            $('.loading').addClass('d-none');
            if (data.status == 2)
                AIZ.plugins.notify('warning', data.message);
            else if (data.status == 1)
                AIZ.plugins.notify('success', data.message);
            else
                AIZ.plugins.notify('danger', data.message);
        });
    });


    $(document).ready(function () {
        $('#countries_name').change(function () {

            var country_name = $('#countries_name').val();

            $.post('{{ route('addresses.state_list') }}', { _token: '{{ csrf_token() }}', id: country_name }, function (data) {

                $('#state_name').empty();
                $('#state_name').append('<option value="">Select State</option>');
                $.each(data.list, function (item, i) {
                    $('#state_name').append('<option value="' + i.state_name + '">' + i.state_name + '</option>');
                });

            });


        });
        $('#state_name').change(function () {

            var state_name = $('#state_name').val();

            $.post('{{ route('addresses.city_list') }}', { _token: '{{ csrf_token() }}', id: state_name }, function (data) {

                $('#city_name').empty();
                $('#city_name').append('<option value="">Select City</option>');
                $.each(data.list, function (item, i) {
                    $('#city_name').append('<option value="' + i.city_name + '">' + i.city_name + '</option>');
                });

            });


        })


        $('#city_name').change(function () {

            var city_name = $('#city_name').val();
            $.post('{{ route('addresses.pincode_list') }}', { _token: '{{ csrf_token() }}', id: city_name }, function (data) {

                $('#postal_code_name').empty();
                $('#postal_code_name').append('<option value="">Select Pincode</option>');
                $.each(data.list, function (item, i) {
                    $('#postal_code_name').append('<option value="' + i.pincode + '">' + i.pincode + '</option>');
                });

            });
        })
    });
</script>

<script type="text/javascript">
    $(function(){
        var dtToday = new Date();
        
        var month = dtToday.getMonth() + 1;
        var day = dtToday.getDate();
        var year = dtToday.getFullYear();
        if(month < 10)
            month = '0' + month.toString();
        if(day < 10)
            day = '0' + day.toString();
        
        var minDate= year + '-' + month + '-' + day;
        
        $('#delivery_date').attr('min', minDate);
    });
</script>
@endsection
