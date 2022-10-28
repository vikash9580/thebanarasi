 <div class="content">

    <!-- Start Content-->

     <div class="container-fluid">

    

        <div class="row">

            <div class="col-12">

                <div class="page-title-box">

                    <h4 class="page-title">Quotation</h4>

                    <div class="page-title-right">

                        <ol class="breadcrumb m-0">

                            <li class="breadcrumb-item"><a href="javascript: void(0);">MOB</a></li>

                            <li class="breadcrumb-item active">Edit</li>

                        </ol>

                    </div>

                </div>

            </div>

        </div>

    

        <div class="row">

                          <div class="card-body">

                              <form class="form-horizontal needs-validation" id="quotation_form" action="{{route('crm_seller.quotationwithuser')}}" method="POST" enctype="multipart/form-data" novalidate >

                    @csrf
                        
                    <!-- Modal body -->

                    <div class="modal-body">

                        <div class="row">

                            <div class="col-sm-12">

                                <h6>{{ translate('Seller Information')}} </h6>

                            </div>
                         <input type="hidden" name="type_from" value="{{request('type')}}" />
                            <div class="col-sm-4">

                                <div class="form-group">

                                    <label class="col-from-label" for="mobile1">{{translate('Phone')}}</label>

                                    <input type="number" placeholder="{{translate('Phone')}}" id="mobile" name="mobile1" class="form-control" value="{{$data->phone}}" required>

                                </div>

                            </div>

                            <div class="col-sm-4">

                                <div class="form-group">

                                    <label class="col-from-label" for="name">{{translate('Name')}}</label>

                                    <input type="text" placeholder="{{translate('Name')}}" id="name" name="name" class="form-control"  value="{{$data->name}}" required>

                                </div>

                            </div>

                            

                            <div class="col-sm-4">

                                <div class="form-group">

                                    <label class="col-from-label" for="email">{{translate('Email')}}</label>

                                    <input type="email" placeholder="{{translate('Email')}}" id="email" name="email" class="form-control" value="{{$data->email}}"  >

                                </div>

                            </div>

                           

                            <div class="row quotaion_information col-sm-12" id="quotaion_information">

                                <div class="col-sm-12">

                                    <h6>{{ translate('Quotation Information')}}</h6>

                                </div>

                                <div class="col-sm-4">

                                    <div class="form-group">

                                        <label class="col-from-label" for="other_phone">{{translate('Phone')}}</label>

                                        <input type="number" placeholder="{{translate('Phone')}}" id="other_phone" name="other_phone" class="form-control" value="{{ $data->other_phone }}">

                                    </div>

                                </div>

                                <div class="col-sm-4">

                                    <div class="form-group">

                                        <label class="col-from-label" for="other_name">{{translate('Name')}}</label>

                                        <input type="text" placeholder="{{translate('Name')}}" id="other_name" name="other_name" class="form-control" value="{{ $data->other_name }}">

                                    </div>

                                </div>

                                <div class="col-sm-4">

                                    <div class="form-group">

                                        <label class="col-from-label" for="other_email">{{translate('Email')}}</label>

                                        <input type="email" placeholder="{{translate('Email')}}" id="other_email" name="other_email" class="form-control" value="{{ $data->other_email}}">

                                    </div>

                                </div>

                            </div>

                           

                         <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="col-form-label" for="name">{{translate('Business Name')}}</label>
                                    <select name="business_name" id="business_name" class="form-control " required data-placeholder="{{ translate('Sellect Bussiness Name') }}"  >
                                        <option value="MZ GROUP TEXTILES" @if($data->business_name == 'MZ GROUP TEXTILES') {{'selected'}} @endif >{{translate('MZ GROUP TEXTILES') }}</option>
                                        <option value="THE BANARASI SAREE" @if($data->business_name == 'THE BANARASI SAREE') {{'selected'}} @endif >{{translate('THE BANARASI SAREE') }}</option>
                                    </select>
                                </div>
                            </div>

                            

                            <div class="col-sm-4">

                                <div class="form-group">

                                    <label class="col-form-label" for="name">{{translate('Quotation Title')}}</label>

                                    <input type="text" placeholder="{{translate('Quotation Tilte')}}" id="quotation_name" name="quotation_name" class="form-control" value="{{$data->quotation_name}}" required>

                                </div>

                            </div>

                            <div class="col-sm-4">

                                <div class="form-group">

                                    <label class="col-form-label" for="date">{{translate('Date')}}</label>

                                    <input type="date" placeholder="{{translate('Date')}}" name="date" id="date" class="form-control" value='{{$data->date}}'>

                                </div>

                            </div>

                        

                            <div class="col-sm-12">

                              <div class="float-sm-end">

               <button type="button" class="btn btn-primary waves-effect waves-light product_all" data-bs-toggle="modal" data-bs-target="#con-close-modal">+</button>

             </div>

                                <br>

                                <table class="table table-bordered">

                                    <thead>

                                        <tr>

                                            <td class="text-center" width="40%"><label class="control-label">{{translate('Product')}}</label></td>

                                            <td class="text-center" width="15%"><label class="control-label">{{translate('Base Price')}}</label></td>

                                            <td class="text-center"><label class="control-label">{{translate('Discount')}}</label></td>

                                            <td class="text-center" width="15%"><label class="control-label">{{translate('DiscountType')}}</label></td>

                                            <td class="text-center" width="15%"><label class="control-label">{{translate('Quantity')}}</label></td>

                                            <td class="text-center" width="15%"><label class="control-label">Total</label></td>

                                        </tr>

                                    </thead>
 @php  $quotations = App\Quotation::where('quotation_number',$data->quotation_number)->get();   @endphp
                                    <tbody id="product_table_data" >

@foreach ($quotations as $key=>$quotation_data)
                                        <tr>
                                            <td>
                                                <div class="from-group row">
                                                    <div class="col-sm-5"><label for="" class="col-from-label"> {{$quotation_data->product->name}}</label></div>
                                                    <input type="hidden" name="product_name[]" value="{{$quotation_data->product->name}}" />
                                                </div>
                                            </td>
                                            <td><input type="number" name="wholesale_unit[]" id="wholesale_unit_{{$key}}" min="0" step="1" class="form-control all" data="{{$key}}" value="{{$quotation_data->base_price}}" required ></td>
                                            <td><input type="number" name="wholesale_discount[]" id="wd_{{$key}}" min="0" step="1" class="form-control all" value="{{$quotation_data->wholesale_discount}}" required ></td>
                                            <td>
                                                <select class="form-control aiz-selectpicker all" name="wholesale_discount_type[]" id="wholesale_discount_type_{{$key}}" data="{{$key}}" >
                                                    <option value="$" @if(isset($quotation_data['wholesale_discount_type']) && $quotation_data['wholesale_discount_type']== '$'){{ 'selected' }}@endif>$</option>
                                                    <option value="%" @if(isset($quotation_data['wholesale_discount_type']) && $quotation_data['wholesale_discount_type']== '%'){{ 'selected' }}@endif>%</option>
                                                </select>
                                                <input type="hidden"  name="wholesale_discount_type[]" value="{{$quotation_data['wholesale_discount_type']}}">
                                            </td>
                                            <td>
                                                <input type="number" name="wholesale_quintity[]" id="wholesale_quintity_{{$key}}" min="0" step="1" class="form-control all" data="{{$key}}" value="{{$quotation_data->wholesale_quintity}}" >
                                                <select class="form-control aiz-selectpicker all" name="type[]" id="type" disabled>
                                                    <option value="meters" @if(isset($quotation_data['type']) && $quotation_data['type']== 'meters'){{ 'selected' }}@endif>Meters</option>
                                                    <option value="pieces" @if(isset($quotation_data['type']) && $quotation_data['type']== 'pieces'){{ 'selected' }}@endif>Pieces</option>
                                                </select>
                                                 <input type="hidden"  name="type[]" value="{{$quotation_data['type']}}">
                                            </td>
                                            <td><input type="number" name="wholesale_discount_price[]" id="wholesale_discount_price_{{$key}}" min="0" step="1" data="{{$key}}" class="form-control all" value="{{$quotation_data->wholesale_discount_price}}" required ></td>
                                        </tr>
                                     @endforeach

                                    </tbody>

                                </table>

                            </div>

                            <div class="col-md-3">

                                <label class="control-label" for="variant_data">{{translate('Delivery / Courier Charge')}}</label>

                                <div class="form-group">

                                    <input type="number" placeholder="{{translate('Delivery / Courier Charge')}}" id="courier_charge" name="courier_charge" onchange="final_total_discount()" class="form-control" value="@if(!empty (old('courier_charge'))){{ old('courier_charge') }}@else{{'0'}}@endif" >

                                </div>

                            </div>

                            <div class="col-md-6"></div>

                            <div class="col-md-3">

                                <label class="control-label" for="variant_data">{{translate('Total')}}</label>

                                <div class="form-group">

                                    <input type="number" placeholder="{{translate('total')}}" id="total" name="total" class="form-control" value="{{ old('total') }}" readonly>

                                </div>

                            </div> 
                            <div class="col-md-9"></div>
                            
                            <div class="col-md-3">

                          <label class="control-label" for="discount_total">Discount Total</label>

                             <div class="form-group">

                             <input type="number" placeholder="Discount Total" id="discount_total" onkeyup="final_total_discount()" name="discount_total" class="form-control" value="@if(!empty (old('discount_total'))){{ old('discount_total') }}@else{{'0'}}@endif" >

                              </div>

                          </div> 

                          <div class="col-md-9"></div>
                            
                            <div class="col-md-3">

                          <label class="control-label" for="grand_total">Grand Total</label>

                             <div class="form-group">

                             <input type="number" placeholder="Discount Total" id="grand_total" name="grand_total" class="form-control" value="@if(!empty (old('grand_total'))){{ old('grand_total') }}@else{{'0'}}@endif" readonly >

                              </div>

                          </div> 



                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}" class="form-control">

                            <input type="hidden" name="reseller_id" id="reseller_id" class="form-control">

                            <div class="col-sm-12">

                                <div class="form-group mb-0">

                                    <button type="submit" onclick="data_save()" class="btn btn-sm btn-primary">{{translate('Save')}}</button>

                                </div>

                            </div>

                        </div>

                        

                    </div>

                </form>

                           </div>

        </div>

        

        </div>

 </div>



<div id="con-close-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">

  <div class="modal-dialog modal-full-width">

                                                <div class="modal-content">

                                                    <div class="modal-header">

                                                        <h4 class="modal-title">Product List</h4>

                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                                                    </div>

                                                    <div class="modal-body p-4" id="modal_body">

                                                      

                                                    </div>

                                                </div>

                                            </div>

                                        </div>

<script>



   $(document).on('click', '.product_all', function(event) {

        event.preventDefault();

        $.ajax({

            beforeSend: function() {

                $('#preloader').css("display", "block");

            },

            url:"{{route('crm_seller.allproducts')}}",

            success: function(data) {

                $('#modal_body').html(data);    

            },

            complete: function() {

               $('#preloader').css("display", "none");

            }

        });

     

     });

function varinat_product_list(data) {
            var variant_ids = data;
                
            console.log(variant_ids);
        
            if(variant_ids.length > 0){
                $.post('{{ route('crm.allproducts') }}', {_token:'{{ csrf_token() }}', variant_ids:variant_ids}, function(data){
                    
                    if(data.products){
                        console.log(data);
                          $('#product_table_data').html(null);
                        var wdp = 0;
                        $.each(data.products,function(key,value){
                        $('#product_table_data').append('<tr><td><div class="from-group row"><div class="col-sm-5"><label for="" class="col-from-label">'+value.name+'</label></div></div></td><td><input type="hidden" name="variant_id[]" id="variant_id_'+ key +'" value="'+value.id+'"  ><input type="number" name="wholesale_unit[]" id="wholesale_unit_'+ key +'" value="'+value.wholesale_price+'" min="0" step="1" class="form-control all_'+ key +'"required></td><td><input type="number" name="wholesale_discount[]" id="wd_'+ key +'"value="'+value.wholesale_discount+'" min="0" step="1" class="form-control all_'+ key +'"required></td><td><select class="form-control aiz-selectpicker all_'+ key +'" name="wholesale_discount_type[]"id="wholesale_discount_type_'+key+'"><option value="$">$</option><option value="%">%</option></select></td><td><input type="number" name="wholesale_quintity[]" id="wholesale_quintity_'+key+'" min="0" step="1"class="form-control all_'+ key +'" value="1"> <select class="form-control aiz-selectpicker all_'+ key +'" name="type[]" id="type_'+key+'"><option value="meters">Meters</option><option value="pieces">Pieces</option></select></td><td><input type="number" name="wholesale_discount_price[]" id="wholesale_discount_price_'+key+'" value="'+value.wholesale_price+'" min="0"step="1" class="form-control all_'+ key +'" required></td></tr>');
                        
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
                $('#product_table_data').html(null);
            }
        }

        function final_total() {
            total_new=0;
            $('input[name="wholesale_discount_price[]"]').each(function() {
                total_new=parseInt(total_new)+parseInt($(this).val());
                // $('#total').val(total_new); 
       
            });
            var courier_charge = $('#courier_charge').val();
            var total_discount = $('#discount_total').val();
             total = parseFloat(total_new) + parseFloat(courier_charge) - parseFloat(total_discount);
               $('#total').val(total); 
               final_total_discount();
            
        }
        function final_total_discount(){
            var subtotal = $('#total').val();
            var courier_charge = $('#courier_charge').val();
            var total_discount = $('#discount_total').val();
             total = parseFloat(subtotal) + parseFloat(courier_charge) - parseFloat(total_discount);
               $('#grand_total').val(total); 
          }


          function data_save(){

event.preventDefault();
var formUrl = $('#quotation_form').attr('action');

 $.ajax({

    beforeSend: function() {

        $('#preloader').css("display", "block");

    },

    type: "POST",

    url: formUrl ,

    data:$('#quotation_form').serialize(),

    success: function(data) {

        $('#page_content').html(data);    

    },

    complete: function() {

       $('#preloader').css("display", "none");

    }

});

}

final_total();


  $(".all").on('change', function(){
      var key=$(this).attr('data');
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

</script>