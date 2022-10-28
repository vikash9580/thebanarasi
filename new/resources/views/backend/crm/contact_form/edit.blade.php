@extends('backend.layouts.app')

@section('content')

    <div class="col-lg-12 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">{{translate('Follow-UP')}}</h5>
            </div>

            <form class="form-horizontal" action="{{ route('contact.update', $Followup->id) }}" method="POST" enctype="multipart/form-data">
                <input name="_method" type="hidden" value="PATCH">
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
                                <input type="number" placeholder="{{translate('Phone')}}" id="mobile" name="mobile1" class="form-control" value="{{ $Followup->reseller->phone}}" required readonly>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="col-from-label" for="name">{{translate('Name')}}</label>
                                <input type="text" placeholder="{{translate('Name')}}" id="name" name="name" class="form-control" value="{{ $Followup->reseller->name }}" required readonly>
                            </div>
                        </div>
                        
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label class="col-from-label" for="name">{{translate('Seller Type')}}</label>
                                <select name="user_type" id="user_type" required class="form-control aiz-selectpicker">
                                    <option value="reseller" @if($Followup->reseller->user_type == "reseller") {{"selected"}}@endif>Reseller</option>
                                    <option value="wholesaler"  @if($Followup->reseller->user_type == "wholesaler") {{"selected"}}@endif>Wholesaler</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="col-from-label" for="email">{{translate('Email')}}</label>
                                <input type="email" placeholder="{{translate('Email')}}" id="email" name="email" class="form-control" value="{{$Followup->reseller->email}}" readonly>
                            </div>
                        </div>
                        <div class="col-sm-1">
                            <div class="form-group" style="margin-top: 40px;">
                               <input type="checkbox" id="other" name="for_other" value="1" readonly @if($Followup->for_other == "1") {{"checked"}}@endif> <label class="col-from-label">For Other </label>
                            </div>
                        </div>
                        @if($Followup->for_other == "1")
                            <div class="row quotaion_information_data col-sm-12" id="quotaion_information_data">
                                <div class="col-sm-12">
                                    <h6>{{ translate('Quotation Information')}}</h6>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="col-from-label" for="other_phone">{{translate('Phone')}}</label>
                                        <input type="number" placeholder="{{translate('Phone')}}" id="other_phone" name="other_phone" class="form-control" value="{{$Followup->other_phone}}" >
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="col-from-label" for="other_name">{{translate('Name')}}</label>
                                        <input type="text" placeholder="{{translate('Name')}}" id="other_name" name="other_name" class="form-control" value="{{$Followup->other_name}}" >
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="col-from-label" for="other_email">{{translate('Email')}}</label>
                                        <input type="email" placeholder="{{translate('Email')}}" id="other_email" name="other_email" class="form-control" value="{{$Followup->other_email}}" >
                                    </div>
                                </div>
                            </div>
                            @else
                            <div class="row quotaion_information col-sm-12" id="quotaion_information">
                                <div class="col-sm-12">
                                    <h6>{{ translate('Quotation Information')}}</h6>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="col-from-label" for="other_phone">{{translate('Phone')}}</label>
                                        <input type="number" placeholder="{{translate('Phone')}}" id="other_phone" name="other_phone" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="col-from-label" for="other_name">{{translate('Name')}}</label>
                                        <input type="text" placeholder="{{translate('Name')}}" id="other_name" name="other_name" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="col-from-label" for="other_email">{{translate('Email')}}</label>
                                        <input type="text" placeholder="{{translate('Email')}}" id="other_email" name="other_email" class="form-control">
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="col-md-12">
                            <h6>{{translate('Lead Status')}}</h6>
                        </div>

                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="" class="col-from-label">Date Of Last Contact</label>
                                <input type="text" class="form-control" id="start" name="last_date" value="{{$Followup->last_date}}" readonly> 
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="" class="col-from-label">Date Of Next Contact</label>
                                <input type="date" placeholder="{{translate('Date')}}" name="next_date" id="next_date" class="form-control" value="{{$Followup->next_date}}">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="" class="col-from-label">Time Of Next Contact</label>
                                <input type="time" placeholder="{{translate('Date')}}" name="next_time" id="next_time" class="form-control" value="{{$Followup->next_time}}">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="col-from-label" for="status_of_lead">{{translate('Status Of Lead')}}</label>
                                <select class="form-control aiz-selectpicker" name="status_of_lead" data-live-search="true">
                                    <!--<option selected disabled value="">-- Select --</option>-->
                                    <option value="Attempted to contact" @if($Followup->status_of_lead == "Attempted to contact") {{"selected"}}@endif>Attempted to contact</option>
                                    <option value="Contact in future" @if($Followup->status_of_lead == "Contact in future") {{"selected"}}@endif>Contact in future</option>
                                    <option value="Contacted" @if($Followup->status_of_lead == "Contacted") {{"selected"}}@endif>Contacted</option>
                                    <option value="Junk lead" @if($Followup->status_of_lead == "Junk lead") {{"selected"}}@endif>Junk lead</option>
                                    <option value="Lost lead" @if($Followup->status_of_lead == "Lost lead") {{"selected"}}@endif>Lost lead</option>
                                    <option value="Not contacted" @if($Followup->status_of_lead == "Not contacted") {{"selected"}}@endif>Not contacted</option>  
                                    <option value="Pre-qualified" @if($Followup->status_of_lead == "Pre-qualified") {{"selected"}}@endif>Pre-qualified</option>
                                    <option value="Not qualified" @if($Followup->status_of_lead == "Not qualified") {{"selected"}}@endif>Not qualified</option>
                                </select>
                            </div>
                        </div>
        
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="col-from-label" for="source_of_lead">{{translate('Source Of Lead')}}</label>
                                <select class="form-control aiz-selectpicker" name="source_of_lead" data-live-search="true">
                                    <option selected disabled value="">-- Select --</option>
                                    <option value="Sales Team" @if($Followup->source_of_lead == "Sales Team") {{"selected"}}@endif>Sales Team</option>
                                    <option value="Social Media" @if($Followup->source_of_lead == "Social Media") {{"selected"}}@endif>Social Media</option>
                                    <option value="Telecalling" @if($Followup->source_of_lead == "Telecalling") {{"selected"}}@endif>Telecalling</option>
                                    <option value="Whatsapp" @if($Followup->source_of_lead == "Whatsapp") {{"selected"}}@endif >Whatsapp</option>
                                    <option value="Referral" @if($Followup->source_of_lead == "Referral") {{"selected"}}@endif >Referral</option>
                                    <option value="Facebook Ads" @if($Followup->source_of_lead == "Facebook Ads") {{"selected"}}@endif>Facebook Ads</option>
                                    <option value="Google Ads" @if($Followup->source_of_lead == "Google Ads") {{"selected"}}@endif >Google Ads</option>  
                                    <option value="Website" @if($Followup->source_of_lead == "Website") {{"selected"}}@endif >Website</option>
                                    <option value="App" @if($Followup->source_of_lead == "App") {{"selected"}}@endif >App</option>
                                    <option value="Self Visit" @if($Followup->source_of_lead == "Self Visit") {{"selected"}}@endif >Self Visit</option>
                                    <option value="Indiamart" @if($Followup->source_of_lead == "App") {{ 'selected' }} @endif>Indiamart</option>
                                    <option value="Database" @if($Followup->source_of_lead == "Self Visit") {{ 'selected' }} @endif>Database</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="col-from-label" for="remark"> {{translate('Remark')}}</label>
                                <textarea class="form-control" name="remark"> {{$Followup->remark}}</textarea>
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
                                    @php
                                        $selected_product = \App\Quotation::where('quotation_number', $Followup->quotation_number)->where('product_id', $product->id)->first();
                                    @endphp
                                        <option value="{{$product->id}}" <?php if($selected_product != null) echo "selected";?> >{{ $product->getTranslation('name') }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6"> 
                            <div class="form-group" id="variant_data">
                                <label class="col-form-label" for="variant_data">{{translate('Variant')}}</label>
                                <select class="form-control aiz-selectpicker" name="variant[]" id="variant" multiple data-placeholder="{{ translate('Choose Products') }}" data-live-search="true">
                                    @foreach (\App\ProductStock::all() as $variant)
                                        @php
                                            $variant_data = \App\Quotation::where('quotation_number', $Followup->quotation_number)->where('variant_id', $variant->id)->get();
                                        @endphp 
                                        @foreach ( $variant_data as $data )
                                            <option value="{{$variant->id}}" <?php if($data != null) echo "selected"; ?> >{{ $variant->variant }}</option>
                                        @endforeach 
                                    @endforeach
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
                                    @if($Followup->quotation_number !="")
                                    @php
                                        $i=0;
                                    @endphp
                                        @foreach (\App\Quotation::where('quotation_number', $Followup->quotation_number)->get(); as $quotation_data)
                                            <tr>
                                                <td>
                                                    <div class="from-group row">
                                                        <div class="col-sm-5"><label for="" class="col-from-label"> {{$quotation_data->product->name}}</label></div>
                                                    </div>
                                                </td>
                                                <td><input type="number" name="wholesale_unit[]" id="wholesale_unit_{{$i}}" min="0" step="1" class="form-control all_{{$i}}" value="{{$quotation_data->base_price}}" onchange="calculation({{$i}})" required></td>
                                                <td><input type="number" name="wholesale_discount[]" id="wd_{{$i}}" min="0" step="1" class="form-control all_{{$i}}" value="{{$quotation_data->wholesale_discount}}" onchange="calculation({{$i}})" required></td>
                                                <td>
                                                    <select class="form-control aiz-selectpicker all_{{$i}}" name="wholesale_discount_type[]" id="wholesale_discount_type_{{$i}}" onchange="calculation({{$i}})" readonly>
                                                        <option value="0" selected disabled>Select</option>
                                                        <option value="$" @if(isset($quotation_data['wholesale_discount_type']) && $quotation_data['wholesale_discount_type']== '$'){{ 'selected' }}@endif>$</option>
                                                        <option value="%" @if(isset($quotation_data['wholesale_discount_type']) && $quotation_data['wholesale_discount_type']== '%'){{ 'selected' }}@endif>%</option>
                                                    </select></td>
                                                <td>
                                                    <input type="number" name="wholesale_quintity[]" id="wholesale_quintity_{{$i}}" min="0" step="1" class="form-control all_{{$i}}" onchange="calculation({{$i}})" value="{{$quotation_data->wholesale_quintity}}">
                                                    <select class="form-control aiz-selectpicker all_{{$i}}" name="type[]" id="type_{{$i}}">
                                                        <option value="meters" @if(isset($quotation_data['type']) && $quotation_data['type']== 'meters'){{ 'selected' }}@endif>Meters</option>
                                                        <option value="pieces" @if(isset($quotation_data['type']) && $quotation_data['pieces']== 'meters'){{ 'selected' }}@endif>Pieces</option>
                                                    </select>
                                                </td>
                                                <td><input type="number" name="wholesale_discount_price[]" id="wholesale_discount_price_{{$i}}" min="0" step="1" class="form-control all_{{$i}}" onchange="calculation({{$i}})" value="{{$quotation_data->wholesale_discount_price}}"></td>
                                            </tr>
                                            @php
                                                $i++;
                                            @endphp
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-3">
                            <label class="control-label" for="variant_data">{{translate('Delivery / Courier Charge')}}</label>
                            <div class="form-group">
                                <input type="number" placeholder="{{translate('Delivery / Courier Charge')}}" id="courier_charge" name="courier_charge" class="form-control" @if($Followup->quotation_number !="") value="{{$quotation_data->courier_charge}}" @else value="0" @endif >
                            </div>
                        </div>
                        <div class="col-md-6">
                            {{-- <input type="checkbox" id="vehicle1" name="convert_quotation" value="0">
                            <label for="vehicle1"> {{translate('Convert to Quotation')}}</label> --}}
                        </div>
                        <div class="col-md-3">
                            <label class="control-label" for="variant_data">{{translate('Total')}}</label>
                            <div class="form-group">
                                
                                <input type="number" placeholder="{{translate('total')}}" id="total" name="total" class="form-control" @if($Followup->quotation_number !="") value="{{$quotation_data->total}}" @else value="0" @endif readonly>
                               
                            </div>
                        </div>
                        
                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}" class="form-control">
                        <input type="hidden" name="reseller_id" id="reseller_id" value="{{$Followup->reseller->id}}"class="form-control">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <input type="submit" class="btn btn-sm btn-primary" name="update" value="{{translate('Update')}}"></input>
                            </div>
                        </div>
                        <div class="col-sm-6"></div>
                        <div class="col-sm-3">
                            <div class="form-group">
                            @if($Followup->quotation_number !="")
                                <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#new_quotation">
                                    {{translate(' Convert to Quotation')}}
                                </button>
                            @endif
                            </div>
                        </div>
                    </div>

                </div>
            </form>

        </div>
    </div>

@endsection
@section('modal')

    <div class="container">
    <!-- The Modal -->
        <div class="modal fade" id="new_quotation">
            <div class="modal-dialog" style="max-width: 70%;">
                <div class="modal-content">
    
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <center> <span class="modal-title">Quotation</span></center>
                        <button type="button" class="close" data-dismiss="modal">×</button>
                    </div>
                    <form class="form-horizontal" action="{{ route('contact.update', $Followup->id) }}" method="POST" enctype="multipart/form-data">
                        <input name="_method" type="hidden" value="PATCH">
                        @csrf
                        <!-- Modal body -->
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <h6>{{translate('Quotation')}}</h6>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-control-label">{{translate('Business Name')}}</label>
                                        <select name="business_name" id="business_name" class="form-control aiz-selectpicker" required data-placeholder="{{ translate('Sellect Bussiness Name') }}">
                                            <option value="mz_group_textiles">{{translate('MZ GROUP TEXTILES') }}</option>
                                            <option value="the_banarasi_saree">{{translate('THE BANARASI SAREE') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for="name">{{translate('Quotation Title')}}</label>
                                        <input type="text" placeholder="{{translate('Quotation Tilte')}}" id="quotation_name" name="quotation_name" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for="date">{{translate('Date')}}</label>
                                        <input type="date" placeholder="{{translate('Date')}}" name="date" id="quotation_date" class="form-control" value='<?php echo date('Y-m-d');?>'>
                                    </div>
                                </div>
                                <div class="col-sm-9"></div>
                                <div class="col-sm-3">
                                    <div class="form-group mb-0">
                                       <input type="submit" class="btn btn-sm btn-info" name="convert_quotaion" value = "{{translate(' Convert to Quotation')}}"></input>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section ('script')
<script>
    $(document).ready(function(){
        $( "#quotaion_information" ).hide();
        
        $("#other_phone").attr('required', false);
       
        $("#other_name").attr('required', false);
        
        $("#other").on("click", function(){
         if (this.checked) { 
            $("#quotaion_information" ).show();
            
            $("#other_phone").attr('required', true);
            
            $("#other_name").attr('required', true);
           
        }else{
            $( "#quotaion_information" ).hide();
            
            $("#other_phone").attr('required', false);
           
            $("#other_name").attr('required', false);
            
            
            }
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
        $('#quotation_date').attr('min', minDate);
    });
</script>

<script>
    function calculation(id) {
          var total =$('#total').val();
            var key=id;
          
        
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
                                    final_totals();
                                    
                                }
                                if(wholesale_discount_type=="%"){
                                    var wper = wholesale_unit / 100 * wd;
                                    wdp1 = wholesale_unit - wper;
                                    wdp = wdp1 * whole_quintity;
                                    $("#wholesale_discount_price_"+key).val(wdp);
                                    total =  parseFloat(total) + parseFloat(wdp);
                                    // $('#total').val(total);
                                    final_totals();
                                   
                                }
                                
                                
                       function final_totals() {
            total_new=0;
            $('input[name="wholesale_discount_price[]"]').each(function() {
                total_new=parseInt(total_new)+parseInt($(this).val());
                // $('#total').val(total_new); 
       
            });
            var courier_charge = $('#courier_charge').val();
             total = parseFloat(total_new) + parseFloat(courier_charge);
               $('#total').val(total); 
            
        }          
                                
                                
                           
        }
</script>

@endsection