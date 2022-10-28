@extends('backend.layouts.app')
<style>
   
    /*Hidden class for adding and removing*/
    .lds-dual-ring.hidden {
        display: none;
    }


.overlay {
    position: absolute;
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
@section('content')

<div class="col-lg-10 mx-auto">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6">{{translate('Generate Quotation')}}</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('crm.generate_quotation') }}" method="POST">
                @csrf
                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}" class="form-control">
                <input type="hidden" name="reseller_id" value="{{ $user->id }}" class="form-control">
                <div class="form-group row">
                    <label class="col-sm-3 control-label" for="name">{{translate('Seller Name')}}</label>
                    <div class="col-sm-9">
                        <input type="text" placeholder="{{translate('Seller Name')}}" id="name" name="title" class="form-control" value="{{ $user->name }}" disabled>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label class="col-sm-3 control-label" for="products">{{translate('Business Name')}}</label>
                    <div class="col-sm-9">
                        <select name="business_name" id="business_name" class="form-control aiz-selectpicker" required data-placeholder="{{ translate('Sellect Bussiness Name') }}">
                            <option value="mz_group_textiles">{{translate('MZ GROUP TEXTILES') }}</option>
                            <option value="the_banarasi_saree">{{translate('THE BANARASI SAREE') }}</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 control-label" for="name">{{translate('Quotation Title')}}</label>
                    <div class="col-sm-9">
                        <input type="text" placeholder="{{translate('Quotation Tilte')}}" id="quotation_name" name="quotation_name" class="form-control" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 control-label" for="date">{{translate('Date')}}</label>
                    <div class="col-sm-9">
                        <input type="date" placeholder="{{translate('Date')}}" name="date" id="date" class="form-control" value='<?php echo date('Y-m-d');?>'>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label class="col-sm-3 control-label" for="products">{{translate('Products')}}</label>
                    <div class="col-sm-9">
                        <select name="products[]" id="products" class="form-control aiz-selectpicker" multiple required data-placeholder="{{ translate('Choose Products') }}" data-live-search="true">
                            @foreach(\App\Product::orderBy('created_at', 'desc')->get() as $product)
                                <option value="{{$product->id}}">{{ $product->getTranslation('name') }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row md-3" id="variant_data">
                    <label class="col-sm-3 control-label" for="variant_data">{{translate('Variant')}}</label>
                    <div class="col-sm-9"> 
                        <select class="form-control aiz-selectpicker" name="variant[]" id="variant" multiple required data-placeholder="{{ translate('Choose Products') }}" data-live-search="true">
                            
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
                <div class="row">
                    <div class="col-md-4">
                        <label class="control-label" for="variant_data">{{translate('Delivery / Courier Charge')}}</label>
                        <div class="form-group">
                            <input type="number" placeholder="{{translate('Delivery / Courier Charge')}}" id="courier_charge" name="courier_charge" value="0" class="form-control" min=0>
                        </div>
                    </div>
                    <div class="col-md-5"></div>
                    <div class="col-md-3">
                        <label class="control-label" for="variant_data">{{translate('Total')}}</label>
                        <div class="form-group">
                            
                            <input type="number" placeholder="{{translate('total')}}" id="total" name="total" value="0" class="form-control" readonly>
                        </div>
                    </div>
                </div>
                
                <div class="form-group mb-0 text-right">
                    <button type="submit" class="btn btn-primary">{{translate('Save')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="loader" class="lds-dual-ring hidden overlay"></div>
@endsection

@section('script')

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
            
            $('#date').attr('min', minDate);
        });
    </script>
@endsection
