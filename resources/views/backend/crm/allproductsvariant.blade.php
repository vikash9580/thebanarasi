@if(count($variant_ids) > 0)

<div class="col-sm-12">
  <table class="table table-bordered">
    <thead>
    	<tr>
    		<td class="text-center" width="40%">
            <label class="control-label">{{translate('Product')}}</label>
    		</td>
        
        <td class="text-center">
            <label class="control-label">{{translate('Wholeasle Base Price')}}</label>
    		</td>
    		<td class="text-center">
            <label class="control-label">{{translate('Wholesale Discount')}}</label>
    		</td>
        <td class="text-center" width="15%">
            <label class="control-label">{{translate('Wholesale Discount Type')}}</label>
        </td>
        <td class="text-center" width="15%">
            <label class="control-label">{{translate('Quintity')}}</label>
        </td>
        <td class="text-center" width="15%">
            <label class="control-label">{{translate('Wholesale Discount Price')}}</label>
        </td>
    	</tr>
    </thead>
    <tbody>
        @foreach ($variant_ids as $key => $id)
        	@php
        		$variant = \App\ProductStock::findOrFail($id);
            $product = \App\Product::where('id', $variant->product_id)->first();
        	@endphp    
   
          <tr>
            <td>
              <div class="from-group row">
                <div class="col-sm-5">
                  <img class="w-100px" src="{{ uploaded_asset($product->thumbnail_img)}}" alt="Image">
                
                  <label for="" class="col-from-label">{{  $product->name  }}</label>
                </div>
              </div>
            </td>
            
            <td>
                <input type="number" name="wholesale_unit_{{ $product->id }}" id="wholesale_unit_{{$id}}" value="{{ $product->wholesale_unit_price }}" min="0" step="1" class="form-control wholesale_unit_{{$id}}" required>
            </td>
            <td>
                
                <input type="number" name="wholesale_discount_{{ $product->id }}" id="wd_{{$id}}" value="{{ $product->wholesale_discount }}" min="0" step="1" class="form-control wd_{{$id}}" required>
            </td>
            <td>
                <select class="form-control aiz-selectpicker wholesale_discount_type_{{$id}}" name="wholesale_discount_type_{{ $product->id }}" id="wholesale_discount_type_{{$id}}">
                  <option value="0">Select</option>
                  <option value="$">$</option>
                  <option value="%">%</option>
                </select>
            </td>
            <td>
                <input type="number" name="wholesale_quintity_{{ $product->id }}" id="wholesale_quintity_{{$id}}" min="0" step="1" class="form-control wholesale_quintity_{{$id}}" required>
            </td>
            <td>
                <input type="number" name="wholesale_discount_price_{{ $product->id }}" id="wholesale_discount_price_{{$id}}"  min="0" step="1" class="form-control wholesale_discount_price_{{$id}}" required>
            </td>
          </tr>
        @endforeach
    </tbody>
  </table>
</div>
@endif
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>



<script type="text/javascript">
  $(document).ready(function(){
    var id = "<?php echo $id; ?>";
    var wdp = "0";
    //console.log(id);
   
    $('#wholesale_discount_type_'+id).on('change', function(){
      var wholesale_unit = $('#wholesale_unit_'+id).val();
      var wd = $('#wd_'+id).val();
      var wholesale_discount_type =$('#wholesale_discount_type_'+id).val();
      var whole_quintity = $('#wholesale_quintity_'+id).val();
      
      if(whole_quintity=" "){
        if(wholesale_discount_type=="$"){
          wdp = wholesale_unit - wd;
          $("#wholesale_discount_price_"+id).val(wdp);
          //console.log(wdp);
        }else if(wholesale_discount_type=="%"){
          var wper = wholesale_unit / 100 * wd;
          wdp = wholesale_unit-wper;
          $("#wholesale_discount_price_"+id).val(wdp);
          //console.log(wdp);
        }else{
          $("#wholesale_discount_price_"+id).val(wdp);
          //console.log(wdp);
        } 
      }else{
        if(wholesale_discount_type=="$"){
          wdp = whole_quintity * wholesale_unit - wd;
          $("#wholesale_discount_price_"+id).val(wdp);
          //console.log(wdp);
        }else if(wholesale_discount_type=="%"){
          var wper = wholesale_unit / 100 * wd;
          wdp1 = wholesale_unit - wper;
          wdp = whole_quintity * wdp1
          $("#wholesale_discount_price_"+id).val(wdp);
          //console.log(wdp);
        }else{
          $("#wholesale_discount_price_"+id).val(wdp);
          //console.log(wdp);
        }
      }
    });
    
    $('#wholesale_quintity_'+id).on('change', function(){

      var wholesale_unit = $('#wholesale_unit_'+id).val();
      var wd = $('#wd_'+id).val();
      var wholesale_discount_type =$('#wholesale_discount_type_'+id).val();
      var whole_quintity = $('#wholesale_quintity_'+id).val();
      
      if(wholesale_discount_type=="$"){
        wdp = whole_quintity * wholesale_unit - wd;
        $("#wholesale_discount_price_"+id).val(wdp);
        //console.log(wdp);
      }else if(wholesale_discount_type=="%"){
        var wper = wholesale_unit / 100 * wd;
        wdp1 = wholesale_unit - wper;
        wdp = whole_quintity * wdp1
        $("#wholesale_discount_price_"+id).val(wdp);
        //console.log(wdp);
      }else{
        $("#wholesale_discount_price_"+id).val(wdp);
        //console.log(wdp);
      }

      // whole_quintity = $('#wholesale_quintity_'+id).val();
      // wdp = wdp * whole_quintity;
      // $("#wholesale_discount_price_"+id).val(wdp);
    });

  });
</script>
