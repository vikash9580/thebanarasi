@extends('backend.layouts.app')

@section('content')
<style>
   
    /*Hidden class for adding and removing*/
    .lds-dual-ring.hidden {
        display: none;
    }


.overlay {
    position: absolute;
        margin: 50px auto;
    top: 30% !important;
    background-color: transparent !important;
}

   label {
    font-size: 13px;
}
 
    /*Add an overlay to the entire page blocking any further presses to buttons or other elements.*/
    .overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100vh;
        background: rgba(0,0,0,.8);
        z-index: 999;
        opacity: 1;
        transition: all 0.5s;
    }
     
    /*Spinner Styles*/
    .lds-dual-ring {
        display: inline-block;
        width: 80px;
        height: 80px;
    }
    .lds-dual-ring:after {
        content: " ";
        display: block;
        width: 40px;
        height: 40px;
        margin: 10% auto;
        border-radius: 50%;
        border: 6px solid #f7f8fa;
        border-color: #bdc0c6 transparent #bdc0c6 transparent;
        animation: lds-dual-ring 1.2s linear infinite;
    }
    @keyframes lds-dual-ring {
        0% {
            transform: rotate(0deg);
        }
        100% {
            transform: rotate(360deg);
        }
    }
</style>
    <div class="col-lg-12 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">{{translate('Follow-UP')}}</h5>
            </div>

            <form class="form-horizontal" action="{{ route('contact.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <h6>{{ translate('Seller Information')}}</h6>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="col-from-label" for="mobile1">{{translate('Phone')}}</label>
                                <input type="number" placeholder="{{translate('Phone')}}" id="mobile" name="mobile1" class="form-control" value="{{old('mobile1')}}" required>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="col-from-label" for="name">{{translate('Name')}}</label>
                                <input type="text" placeholder="{{translate('Name')}}" id="name" name="name" class="form-control" value="{{ old('name') }}" required>
                            </div>
                        </div>
                        
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label class="col-from-label" for="name">{{translate('Seller Type')}}</label>
                                <select name="user_type" id="user_type" required class="form-control aiz-selectpicker">
                                    <option value="reseller" @if (old('user_type') == "reseller") {{ 'selected' }} @endif>Reseller</option>
                                    <option value="wholesaler" @if (old('user_type') == "wholesaler") {{ 'selected' }} @endif>Wholesaler</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="col-from-label" for="email">{{translate('Email')}}</label>
                                <input type="email" placeholder="{{translate('Email')}}" id="email" name="email" class="form-control" value="{{ old('email') }}">
                            </div>
                        </div>
                        
                        <div class="col-sm-1">
                            <div class="form-group" style="margin-top: 40px;">
                               <input type="checkbox" id="other" name="for_other" value="1" @if(old('for_other') == "1") {{"checked"}}@endif> <label class="col-from-label">For Other </label>
                            </div>
                        </div>
                        
                        <div class="row quotaion_information col-sm-12" id="quotaion_information">
                            <div class="col-sm-12">
                                <h6>{{ translate('Quotation Information')}}</h6>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label class="col-from-label" for="other_phone">{{translate('Phone')}}</label>
                                    <input type="number" placeholder="{{translate('Phone')}}" id="other_phone" name="other_phone" class="form-control" value="{{ old('other_phone') }}">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label class="col-from-label" for="other_name">{{translate('Name')}}</label>
                                    <input type="text" placeholder="{{translate('Name')}}" id="other_name" name="other_name" class="form-control" value="{{ old('other_name') }}">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label class="col-from-label" for="other_email">{{translate('Email')}}</label>
                                    <input type="email" placeholder="{{translate('Email')}}" id="other_email" name="other_email" class="form-control" value="{{ old('other_email') }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <h6>{{translate('Lead Status')}}</h6>
                        </div>

                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="" class="col-from-label">Date Of Last Contact</label>
                                <input type="text" class="form-control" id="start" name="last_date" value='<?php echo date('Y-m-d H:i');?>' readonly> 
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="" class="col-from-label">Date Of Next Contact </label>
                                <input type="date" placeholder="{{translate('Date')}}" name="next_date" id="next_date" class="form-control" value="{{ old('next_date') }}">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="" class="col-from-label">Time Of Next Contact</label>
                                <input type="time" placeholder="{{translate('Date')}}" name="next_time" id="next_time" class="form-control" value="{{ old('next_time') }}">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="col-from-label" for="status_of_lead">{{translate('Status Of Lead')}}</label>
                                <select class="form-control aiz-selectpicker" name="status_of_lead" data-live-search="true">
                                    <!--<option selected disabled value="">-- Select --</option>-->
                                    <option value="Attempted to contact"  @if (old('status_of_lead') == "Attempted to contact") {{ 'selected' }} @endif>Attempted to contact</option>
                                    <option value="Contact in future"  @if (old('status_of_lead') == "Contact in future") {{ 'selected' }} @endif>Contact in future</option>
                                    <option value="Contacted"  @if (old('status_of_lead') == "Contacted") {{ 'selected' }} @endif>Contacted</option>
                                    <option value="Junk lead"  @if (old('status_of_lead') == "Junk lead") {{ 'selected' }} @endif>Junk lead</option>
                                    <option value="Lost lead"  @if (old('status_of_lead') == "Lost lead") {{ 'selected' }} @endif>Lost lead</option>
                                    <option value="Not contacted"  @if (old('status_of_lead') == "Not contacted") {{ 'selected' }} @endif>Not contacted</option>  
                                    <option value="Pre-qualified"  @if (old('status_of_lead') == "Pre-qualified") {{ 'selected' }} @endif>Pre-qualified</option>
                                    <option value="Not qualified"  @if (old('status_of_lead') == "Not qualified") {{ 'selected' }} @endif>Not qualified</option>
                                </select>
                            </div>
                        </div>
        
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="col-from-label" for="source_of_lead">{{translate('Source Of Lead')}}</label>
                                <select class="form-control aiz-selectpicker" name="source_of_lead" data-live-search="true">
                                    <option selected disabled value="">-- Select --</option>
                                    <option value="Sales Team" @if (old('source_of_lead') == "Sales Team") {{ 'selected' }} @endif>Sales Team</option>
                                    <option value="Social Media" @if (old('source_of_lead') == "Social Media") {{ 'selected' }} @endif>Social Media</option>
                                    <option value="Telecalling" @if (old('source_of_lead') == "Telecalling") {{ 'selected' }} @endif>Telecalling</option>
                                    <option value="Whatsapp" @if (old('source_of_lead') == "Whatsapp") {{ 'selected' }} @endif>Whatsapp</option>
                                    <option value="Referral" @if (old('source_of_lead') == "Referral") {{ 'selected' }} @endif>Referral</option>
                                    <option value="Facebook Ads" @if (old('source_of_lead') == "Facebook Ads") {{ 'selected' }} @endif>Facebook Ads</option>
                                    <option value="Google Ads" @if (old('source_of_lead') == "Google Ads") {{ 'selected' }} @endif>Google Ads</option>  
                                    <option value="Website" @if (old('source_of_lead') == "Website") {{ 'selected' }} @endif>Website</option>
                                    <option value="App" @if (old('source_of_lead') == "App") {{ 'selected' }} @endif>App</option>
                                    <option value="Self Visit" @if (old('source_of_lead') == "Self Visit") {{ 'selected' }} @endif>Self Visit</option>
                                    <option value="Indiamart" @if (old('source_of_lead') == "App") {{ 'selected' }} @endif>Indiamart</option>
                                    <option value="Database" @if (old('source_of_lead') == "Self Visit") {{ 'selected' }} @endif>Database</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="col-from-label" for="remark"> {{translate('Remark')}}</label>
                                <textarea class="form-control" name="remark"> {{ old('remark') }} </textarea>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <h6>{{translate('Item Interested')}}</h6>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="col-form-label" for="products">{{translate('Products')}}</label>
                                <select name="products[]" id="products" class="form-control aiz-selectpicker" multiple data-placeholder="{{ translate('Choose Products') }}" data-live-search="true">
                                    @foreach(\App\Product::orderBy('created_at', 'desc')->get() as $product)
                                        <option value="{{$product->id}}" @if (old('products') == $product->id ) {{ 'selected' }} @endif>{{ $product->getTranslation('name') }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6"> 
                            <div class="form-group" id="variant_data">
                                <label class="col-form-label" for="variant_data">{{translate('Variant')}}</label>
                                <select class="form-control aiz-selectpicker" name="variant[]" id="variant" multiple data-placeholder="{{ translate('Choose Products') }}" data-live-search="true">
                                    
                                </select>
                            </div>
                        </div>
                        
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
                                <tbody id="product_table">

                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-3">
                            <label class="control-label" for="variant_data">{{translate('Delivery / Courier Charge')}}</label>
                            <div class="form-group">
                                <input type="number" placeholder="{{translate('Delivery / Courier Charge')}}" id="courier_charge" name="courier_charge" value="0" class="form-control" >
                            </div>
                        </div>
                        <div class="col-md-6"></div>
                        <div class="col-md-3">
                            <label class="control-label" for="variant_data">{{translate('Total')}}</label>
                            <div class="form-group">
                                
                                <input type="number" placeholder="{{translate('total')}}" id="total" name="total" class="form-control" value="0" readonly>
                            </div>
                        </div> 
                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}" class="form-control">
                        <input type="hidden" name="reseller_id" id="reseller_id" class="form-control">
                        <div class="col-sm-12">
                            <div class="form-group mb-0">
                                <button type="submit" class="btn btn-sm btn-primary" id="save">{{translate('Save')}}</button>
                            </div>
                        </div>
                    </div>

                </div>
            </form>

        </div>
    </div>
<div id="loader" class="lds-dual-ring hidden overlay"></div>
@endsection

@section ('script')
<script>
    $(document).ready(function(){
        $( "#quotaion_information" ).hide();
        $("#other_phone").prop('disabled', true);
        $("#other_phone").attr('required', false);
        $("#other_name").prop('disabled', true);
        $("#other_name").attr('required', false);
        $("#other_email").prop('disabled', true);
        $("#other").on("click", function(){
            if (this.checked) { 
                $("#quotaion_information" ).show();
                $("#other_phone").prop('disabled', false);
                $("#other_phone").attr('required', true);
                $("#other_name").prop('disabled', false);
                $("#other_name").attr('required', true);
                $("#other_email").prop('disabled', false);
            }else{
                $( "#quotaion_information" ).hide();
                $("#other_phone").prop('disabled', true);
                $("#other_phone").attr('required', false);
                $("#other_name").prop('disabled', true);
                $("#other_name").attr('required', false);
                $("#other_email").prop('disabled', true);
            }
        });
    });
</script>

<script type="text/javascript">
    $( document ).ajaxStart(function() {
        $( "#loader" ).show();
    });
    $( document ).ajaxComplete(function() {
        $( "#loader" ).hide();
    });
</script>
<script type="text/javascript">
    $(document).ready(function(){
        $('#mobile').on('change', function(){
            var mobile = $('#mobile').val();
            //console.log(mobile);
            $.post('{{ route('crm.sellerinfo') }}', {_token:'{{ csrf_token() }}', mobile:mobile}, function(data){
                //console.log(data.seller);
                //if(data.followup_status){
                if(data.seller) {
                  if(data.followup_status.active!=1){
                    $('#name').val(data.seller.user.name);
                    $('#user_type').val(data.seller.user.user_type);
                    $('#email').val(data.seller.user.email);
                    $('#reseller_id').val(data.seller.user_id);
                    $("#name").prop('disabled', true);
                    $("#user_type").prop('disabled', true);
                    $("#email").prop('disabled', true);
                  }
                  else{
                     $("#name").prop('disabled', true);
                    $("#user_type").prop('disabled', true);
                    $("#email").prop('disabled', true);
                    $('#save').hide();
                    AIZ.plugins.notify('danger', '{{ translate('Last Followup Not Closed') }}');
                  }
                }else{
                   
                    $('#name').val('');
                    $('#user_type').val('');
                    $('#email').val('');
                    $('#reseller_id').val('');
                    $("#name").prop('disabled', false);
                    $("#user_type").prop('disabled', false);
                    $("#email").prop('disabled', false);
                 }
            //   }
          //else{
                   //  $("#name").prop('disabled', true);
                  //  $("#user_type").prop('disabled', true);
                 // $("#email").prop('disabled', true);
                //  $('#save').hide();
               //  AIZ.plugins.notify('danger', '{{ translate('Last Followup Not Closed') }}');
              //  }
            });
        });
    });

</script>

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
        
        $('#next_date').attr('min', minDate);
    });
</script>


@endsection