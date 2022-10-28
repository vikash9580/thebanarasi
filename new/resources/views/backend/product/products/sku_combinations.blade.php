@if(count($combinations[0]) > 0)
	<table class="table table-bordered">
		<thead>
			<tr>
				<td class="text-center">
					<label for="" class="control-label text-dark">{{translate('Variant')}}</label>
				</td>
				
				<td class="text-center">
					<label for="" class="control-label text-dark">{{translate('Variant Price')}}</label>
				</td>
				<td>	<label for="" class="control-label text-dark">{{translate('Variant Whole Sale Price')}}</label>
				</td>
					<td class="text-center">
					<label for="" class="control-label text-dark">Discount</label>
					</td>
				<td class="text-center">
					<label for="" class="control-label text-dark">Min/Max Qty</label>
				</td>
				<td class="text-center">
					<label for="" class="control-label text-dark">Wholesale Discount</label>
					</td>
				<td class="text-center">
					<label for="" class="control-label text-dark">Wholesale Min/Max Qty</label>
				</td>
				
				<td class="text-center">
					<label for="" class="control-label text-dark">Stock Ava.</label>
				</td>
				<td class="control-label text-dark" >Image</td>
			
			</tr>
		</thead>
		<tbody>


@foreach ($combinations as $key => $combination)
	@php
		$sku = '';
		foreach (explode(' ', $product_name) as $key => $value) {
			$sku .= substr($value, 0, 1);
		}

		$str = '';
		foreach ($combination as $key => $item){
			if($key > 0 ){
				$str .= '-'.str_replace(' ', '', $item);
				$sku .='-'.str_replace(' ', '', $item);
			}
			else{
				if($colors_active == 1){
					$color_name = \App\Color::where('code', $item)->first()->name;
					$str .= $color_name;
					$sku .='-'.$color_name;
				}
				else{
					$str .= str_replace(' ', '', $item);
					$sku .='-'.str_replace(' ', '', $item);
				}
			}
		}
	@endphp
	@if(strlen($str) > 0)
			<tr class="variant">
				<td>
					<label for="" class="control-label">{{ $str }}</label>
				</td>
					
				<td>
					<input type="number" name="price_{{ $str }}" value="{{ $unit_price }}" min="0" step="0.01" class="form-control" required>
				</td>
					<td>
					<input type="number" name="wholesale_price_{{ $str }}" value="{{ $wholesale_unit_price }}" min="0" step="0.01" class="form-control" required>
				</td>
				
					<td>
				    	
						<input type="number" min="0"  placeholder="{{ translate('Discount') }}" name="discount_{{ $str }}"  class="form-control" required>
				
						<select class="form-control aiz-selectpicker" name="discount_type_{{ $str }}">
							<option value="amount">{{translate('Flat')}}</option>
							<option value="percent">{{translate('Percent')}}</option>
						</select>
				
				</td>
				
				
				
			<td>
				  
				        <input type="number" name="min_qty_{{ $str }}"  min="1" step="1"  placeholder="Min Qty" class="form-control" required>
				
					     <input type="number" name="max_qty_{{ $str }}"   step="1" class="form-control"  placeholder="Max Qty" required>
				
				</td>
				
				
				<td>
				    	
						<input type="number" min="0"  placeholder="{{ translate('Wholesale Discount') }}" name="wholesale_discount_{{ $str }}"  class="form-control" required>
				
						<select class="form-control aiz-selectpicker" name="wholesale_discount_type_{{ $str }}">
							<option value="amount">{{translate('Flat')}}</option>
							<option value="percent">{{translate('Percent')}}</option>
						</select>
				
				</td>
				
				
				
			<td>
				  
				        <input type="number" name="wholesale_min_{{ $str }}"  min="1" step="1"  placeholder="Min Qty" class="form-control" required>
				
					     <input type="number" name="wholesale_max_{{ $str }}"   step="1" class="form-control"  placeholder="Max Qty" required>
				
				</td>
				
				
				
				<td>
					<input type="number" name="qty_{{ $str }}" value="10" min="0" step="1" class="form-control" required>
				</td>
				<td>
				    <div class="input-group" data-toggle="aizuploader" data-type="image">
                    <div class="form-control file-amount">{{ translate('Choose') }}</div>
                    <input type="hidden" name="thumbnail_img_{{ $str }}" class="selected-files">
                </div>
                <div class="file-preview box sm">
                </div>
				</td>
			</tr>
	@endif
@endforeach
	</tbody>
</table>
@endif
