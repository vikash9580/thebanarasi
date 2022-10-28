@extends('backend.layouts.app')

@section('content')
<div class="aiz-titlebar text-left mt-2">
    <h5 class="mb-0 h6">{{translate('Add New Product')}}</h5>
</div>
<div class="frm">
<div class="col-md-11 mx-auto">
	<form class="box form form-horizontal mar-top" action="{{route('products.store')}}" method="POST" enctype="multipart/form-data" id="choice_form" onsubmit="check_product_name()">
		@csrf
		<input type="hidden" name="added_by" value="admin">
		<div class="card">
			<div class="card-header">
				<h5 class="mb-0 h6">{{translate('Product Information')}}</h5>
			</div>
			<div class="card-body">
				<div class="form-group row">
					<label class="col-md-3 col-from-label">Product Name</label>
					<div class="col-md-8">
						<input type="text" class="form-control" name="name" id="name" placeholder="Product Name" required>
						<span id="product_name_error"></span>
					</div>
				</div>
				
					<div class="form-group row">
					<label class="col-md-3 col-from-label">Vendors</label>
					<div class="col-md-8">
					<select class="form-control aiz-selectpicker" name="vendor[]" id="vendor"  data-live-search="true" multiple>
					    	<option value="">Select Vendor</option>	
									 @foreach (\App\Vendor::where('status', 1)->get() as $key => $vendor)
                                         <option value="{{ $vendor->id }}">{{ $vendor->name }}</option>
                                     @endforeach
							
						
						</select>
					</div>
				</div>
				
				
					<div class="form-group row">
					<label class="col-md-3 col-from-label">{{translate('Product Type')}}</label>
					<div class="col-md-8">
					<select class="form-control aiz-selectpicker" name="product_type" id="product_type"  data-live-search="true" >
					        	<option value="">Select Product Type</option>	
								<option value="generic">Generic</option>	
								<option value="patent">Patent</option>
								<option value="surgical">Surgical</option>
							    <option value="general">General</option>
		                    	<option value="eye drop">Eye Drop</option>
		                    	<option value="costly item">Costly Item</option>
		                    	<option value="miscellaneous">Miscellaneous</option>
						</select>
					</div>
				</div>
				
				
				<div class="form-group row" id="category">
					<label class="col-md-3 col-from-label">{{translate('Category')}}</label>
					<div class="col-md-8">
						<select class="form-control aiz-selectpicker" name="category_id" id="category_id"  data-live-search="true" required>
							@foreach($categories as $category)
								<option value="{{$category->id}}">{{ $category->getTranslation('name') }}</option>
							@endforeach
						</select>
					</div>
				</div>
				<div class="form-group row" id="subcategory">
					<label class="col-md-3 col-from-label">{{translate('Subcategory')}}</label>
					<div class="col-md-8">
						<select class="form-control aiz-selectpicker" name="subcategory_id" id="subcategory_id"  data-live-search="true" required>

						</select>
					</div>
				</div>
				<div class="form-group row" id="subsubcategory">
					<label class="col-md-3 col-from-label">{{translate('Sub Subcategory')}}</label>
					<div class="col-md-8">
						<select class="form-control aiz-selectpicker" name="subsubcategory_id" id="subsubcategory_id"  data-live-search="true">

						</select>
					</div>
				</div>
				<div class="form-group row" id="brand">
					<label class="col-md-3 col-from-label">{{translate('Brand')}}</label>
					<div class="col-md-8">
						<select class="form-control aiz-selectpicker" name="brand_id" id="brand_id"  data-live-search="true">
							<option value="">{{ ('Select Brand') }}</option>
							@foreach (\App\Brand::all() as $brand)
								<option value="{{ $brand->id }}">{{ $brand->getTranslation('name') }}</option>
							@endforeach
						</select>
					</div>
				</div>
				<div class="form-group row" id="brand">
					<label class="col-md-3 col-from-label">{{translate('IS RX')}}</label>
					<div class="col-md-8">
						<select class="form-control aiz-selectpicker" name="is_rx" id="is_rx"  data-live-search="true">
							<option value="">{{ ('Select RX') }}</option>
							<option value="yes">Yes</option>
							<option value="no">No</option>	
						</select>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-md-3 col-from-label">{{translate('Unit')}}</label>
					<div class="col-md-8">
						<input type="text" class="form-control" name="unit" placeholder="{{ translate('Unit (e.g. KG, Pc etc)') }}" required>
					</div>
				</div>
                <div class="form-group row">
					<label class="col-md-3 col-from-label">{{translate('Minimum Qty')}}</label>
					<div class="col-md-8">
						<input type="number" class="form-control" name="min_qty" value="1" min="1" required>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-md-3 col-from-label">Maximum Qty</label>
					<div class="col-md-8">
						<input type="number" class="form-control" name="max_qty" value="1" min="1" required>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-md-3 col-from-label">HSN/SAC Code</label>
					<div class="col-md-8">
						<input type="number" class="form-control" name="hsn_code" placeholder="{{ translate('HSN/SAC Code') }}" required>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-md-3 col-from-label">{{translate('Tags')}}</label>
					<div class="col-md-8">
                        <input type="text" class="form-control aiz-tag-input" name="tags[]" placeholder="{{ translate('Type and hit enter to add a tag') }}" required>
					</div>
				</div>

				@php
				    $pos_addon = \App\Addon::where('unique_identifier', 'pos_system')->first();
				@endphp
				@if ($pos_addon != null && $pos_addon->activated == 1)
					<div class="form-group row">
						<label class="col-md-3 col-from-label">{{translate('Barcode')}}</label>
						<div class="col-md-8">
							<input type="text" class="form-control" name="barcode" placeholder="{{ translate('Barcode') }}">
						</div>
					</div>
				@endif

				@php
				    $refund_request_addon = \App\Addon::where('unique_identifier', 'refund_request')->first();
				@endphp
				@if ($refund_request_addon != null && $refund_request_addon->activated == 1)
					<div class="form-group row">
						<label class="col-md-3 col-from-label">{{translate('Refundable')}}</label>
						<div class="col-md-8">
                          <label class="aiz-switch aiz-switch-success mb-0">
                              <input type="checkbox" name="refundable" checked>
                              <span></span>
                          </label>
						</div>
					</div>
				@endif
			</div>
		</div>
		<div class="card">
			<div class="card-header">
				<h5 class="mb-0 h6">{{translate('Product Images')}}</h5>
			</div>
			<div class="card-body">
        <div class="form-group row">
            <label class="col-md-3 col-form-label" for="signinSrEmail">{{translate('Gallery Images')}}</label>
            <div class="col-md-8">
                <div class="input-group" data-toggle="aizuploader" data-type="image" data-multiple="true">
                    <div class="input-group-prepend">
                        <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
                    </div>
                    <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                    <input type="hidden" name="photos" class="selected-files">
                </div>
                <div class="file-preview box sm">
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-3 col-form-label" for="signinSrEmail">{{translate('Thumbnail Image')}} <small>(290x300)</small></label>
            <div class="col-md-8">
                <div class="input-group" data-toggle="aizuploader" data-type="image">
                    <div class="input-group-prepend">
                        <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
                    </div>
                    <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                    <input type="hidden" name="thumbnail_img" class="selected-files">
                </div>
                <div class="file-preview box sm">
                </div>
            </div>
        </div>
			</div>
		</div>
		<div class="card">
			<div class="card-header">
				<h5 class="mb-0 h6">{{translate('Product Videos')}}</h5>
			</div>
			<div class="card-body">
				<div class="form-group row">
					<label class="col-md-3 col-from-label">{{translate('Video Provider')}}</label>
					<div class="col-md-8">
						<select class="form-control aiz-selectpicker" name="video_provider" id="video_provider">
							<option value="youtube">{{translate('Youtube')}}</option>
							<option value="dailymotion">{{translate('Dailymotion')}}</option>
							<option value="vimeo">{{translate('Vimeo')}}</option>
						</select>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-md-3 col-from-label">{{translate('Video Link')}}</label>
					<div class="col-md-8">
						<input type="text" class="form-control" name="video_link" placeholder="{{ translate('Video Link') }}">
					</div>
				</div>
			</div>
		</div>
		<div class="card">
			<div class="card-header">
				<h5 class="mb-0 h6">{{translate('Product Variation')}}</h5>
			</div>
			<div class="card-body">
				<div class="form-group row">
					<div class="col-md-3">
						<input type="text" class="form-control" value="{{translate('Colors')}}" disabled>
					</div>
					<div class="col-md-8">
						<select class="form-control aiz-selectpicker" data-live-search="true" name="colors[]" id="colors" multiple disabled>
							@foreach (\App\Color::orderBy('name', 'asc')->get() as $key => $color)
								<option  value="{{ $color->code }}" data-content="<span><span class='size-15px d-inline-block mr-2 rounded border' style='background:{{ $color->code }}'></span><span>{{ $color->name }}</span></span>"></option>
							@endforeach
						</select>
					</div>
					<div class="col-md-1">
						<label class="aiz-switch aiz-switch-success mb-0">
							<input value="1" type="checkbox" name="colors_active">
							<span></span>
						</label>
					</div>
				</div>

				<div class="form-group row">
    				<div class="col-md-3">
    					<input type="text" class="form-control" value="{{translate('Attributes')}}" disabled>
    				</div>
		            <div class="col-md-8">
						<select name="choice_attributes[]" id="choice_attributes" class="form-control aiz-selectpicker" data-live-search="true" multiple data-placeholder="{{ translate('Choose Attributes') }}">
							@foreach (\App\Attribute::all() as $key => $attribute)
							<option value="{{ $attribute->id }}">{{ $attribute->getTranslation('name') }}</option>
							@endforeach
						</select>
		            </div>
	        	</div>
				<div>
					<p>{{ translate('Choose the attributes of this product and then input values of each attribute') }}</p>
					<br>
				</div>

				<div class="customer_choice_options" id="customer_choice_options">
					
				</div>
			</div>
		</div>
		<div class="card">
			<div class="card-header">
				<h5 class="mb-0 h6">{{translate('Product price + stock')}}</h5>
			</div>
			<div class="card-body">
				<div class="form-group row">
					<label class="col-md-3 col-from-label">{{translate('Unit price')}}</label>
					<div class="col-md-6">
						<input type="number" min="0" value="0" step="0.01" placeholder="{{ translate('Unit price') }}" name="unit_price" class="form-control" required>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-md-3 col-from-label">{{translate('Purchase price')}}</label>
					<div class="col-md-6">
						<input type="number" min="0" value="0" step="0.01" placeholder="{{ translate('Purchase price') }}" name="purchase_price" class="form-control" required>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-md-3 col-from-label">{{translate('Tax')}}</label>
					<div class="col-md-6">
						<input type="number" min="0" value="0" step="0.01" placeholder="{{ translate('Tax') }}" name="tax" class="form-control" required>
					</div>
					<div class="col-md-3">
						<select class="form-control aiz-selectpicker" name="tax_type">
							<option value="amount">{{translate('Flat')}}</option>
							<option value="percent">{{translate('Percent')}}</option>
						</select>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-md-3 col-from-label">{{translate('Discount')}}</label>
					<div class="col-md-6">
						<input type="number" min="0" value="0" step="0.01" placeholder="{{ translate('Discount') }}" name="discount" class="form-control" required>
					</div>
					<div class="col-md-3">
						<select class="form-control aiz-selectpicker" name="discount_type">
							<option value="amount">{{translate('Flat')}}</option>
							<option value="percent">{{translate('Percent')}}</option>
						</select>
					</div>
				</div>
				<div class="form-group row" id="quantity">
					<label class="col-md-3 col-from-label">{{translate('Quantity')}}</label>
					<div class="col-md-6">
						<input type="number" min="0" value="0" step="1" placeholder="{{ translate('Quantity') }}" name="current_stock" class="form-control" required>
					</div>
				</div>
				<br>
				<div class="sku_combination" id="sku_combination">

				</div>
			</div>
		</div>
		<div class="card">
			<div class="card-header">
				<h5 class="mb-0 h6">{{translate('Product Description')}}</h5>
			</div>
			<div class="card-body">
				<div class="form-group row">
					<label class="col-md-3 col-from-label">{{translate('About')}}</label>
					<div class="col-md-8">
						<textarea class="aiz-text-editor" name="description"></textarea>
					</div>
				</div>
					<div class="form-group row">
					<label class="col-md-3 col-from-label">{{translate('Composition')}}</label>
					<div class="col-md-8">
						<textarea class="aiz-text-editor" name="composition"></textarea>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-md-3 col-from-label">{{translate('Specification')}}</label>
					<div class="col-md-8">
						<textarea class="aiz-text-editor" name="specification"></textarea>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-md-3 col-from-label">{{translate('Caution')}}</label>
					<div class="col-md-8">
						<textarea class="aiz-text-editor" name="caution"></textarea>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-md-3 col-from-label">{{translate('Side Effect')}}</label>
					<div class="col-md-8">
						<textarea class="aiz-text-editor" name="side_effect"></textarea>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-md-3 col-from-label">{{translate('How To Use')}}</label>
					<div class="col-md-8">
						<textarea class="aiz-text-editor" name="how_to_use"></textarea>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-md-3 col-from-label">{{translate('FAQs')}}</label>
					<div class="col-md-8">
						<textarea class="aiz-text-editor" name="faq"></textarea>
					</div>
				</div>
			</div>
		</div>
        @if (\App\BusinessSetting::where('type', 'shipping_type')->first()->value == 'product_wise_shipping')
            <div class="card">
				<div class="card-header">
					<h5 class="mb-0 h6">{{translate('Product Shipping Cost')}}</h5>
				</div>
				<div class="card-body">
					<div class="form-group row">
						<div class="col-md-3">
							<div class="card-heading">
								<h5 class="mb-0 h6">{{translate('Free Shipping')}}</h5>
							</div>
						</div>
						<div class="col-md-9">
							<div class="form-group row">
								<label class="col-md-3 col-from-label">{{translate('Status')}}</label>
								<div class="col-md-8">
									<label class="aiz-switch aiz-switch-success mb-0">
										<input type="radio" name="shipping_type" value="free" checked>
										<span></span>
									</label>
								</div>
							</div>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-md-3">
							<div class="card-heading">
								<h5 class="mb-0 h6">{{translate('Flat Rate')}}</h5>
							</div>
						</div>
						<div class="col-md-9">
							<div class="form-group row">
								<label class="col-md-3 col-from-label">{{translate('Status')}}</label>
								<div class="col-md-8">
									<label class="aiz-switch aiz-switch-success mb-0">
										<input type="radio" name="shipping_type" value="flat_rate" checked>
										<span></span>
									</label>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-md-3 col-from-label">{{translate('Shipping cost')}}</label>
								<div class="col-md-8">
									<input type="number" min="0" value="0" step="0.01" placeholder="{{ translate('Shipping cost') }}" name="flat_shipping_cost" class="form-control" required>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
        @endif
		<div class="card">
			<div class="card-header">
				<h5 class="mb-0 h6">{{translate('PDF Specification')}}</h5>
			</div>
			<div class="card-body">
          <div class="form-group row">
              <label class="col-md-3 col-form-label" for="signinSrEmail">{{translate('PDF Specification')}}</label>
              <div class="col-md-8">
                  <div class="input-group" data-toggle="aizuploader" data-type="document">
                      <div class="input-group-prepend">
                          <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
                      </div>
                      <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                      <input type="hidden" name="pdf" class="selected-files">
                  </div>
                  <div class="file-preview box sm">
                  </div>
              </div>
          </div>

				{{-- <div class="form-group row">
					<label class="col-md-3 col-from-label">{{translate('PDF Specification')}}</label>
					<div class="col-md-8">
                        <div class="custom-file __web-inspector-hide-shortcut__">
							<label class="custom-file-label">
								<input type="file" class="custom-file-input" name="pdf" accept="application/pdf">
								<span class="custom-file-name">{{ translate('Choose file') }}</span>
							</label>
						</div>
					</div>
				</div> --}}
			</div>
		</div>
		<div class="card">
			<div class="card-header">
				<h5 class="mb-0 h6">{{translate('SEO Meta Tags')}}</h5>
			</div>
			<div class="card-body">
				<div class="form-group row">
					<label class="col-md-3 col-from-label">{{translate('Meta Title')}}</label>
					<div class="col-md-8">
						<input type="text" class="form-control" name="meta_title" placeholder="{{ translate('Meta Title') }}">
					</div>
				</div>
				<div class="form-group row">
					<label class="col-md-3 col-from-label">{{translate('Description')}}</label>
					<div class="col-md-8">
						<textarea name="meta_description" rows="8" class="form-control"></textarea>
					</div>
				</div>
                <div class="form-group row">
                    <label class="col-md-3 col-form-label" for="signinSrEmail">{{ translate('Meta Image') }}</label>
                    <div class="col-md-8">
                        <div class="input-group" data-toggle="aizuploader" data-type="image">
                            <div class="input-group-prepend">
                                <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
                            </div>
                            <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                            <input type="hidden" name="meta_img" class="selected-files">
                        </div>
                        <div class="file-preview box sm">
                        </div>
                    </div>
                </div>
			</div>
		</div>
		<div class="mar-all text-right">
			<button type="submit" name="button" class="btn btn-info" >{{ translate('Add New Product') }}</button>
		</div>
	</form>
</div>
</div>

@endsection

@section('script')

<script type="text/javascript">
    function add_more_customer_choice_option(i, name){
        $('#customer_choice_options').append('<div class="form-group row"><div class="col-md-3"><input type="hidden" name="choice_no[]" value="'+i+'"><input type="text" class="form-control" name="choice[]" value="'+name+'" placeholder="{{ translate('Choice Title') }}" readonly></div><div class="col-md-8"><input type="text" class="form-control aiz-tag-input" name="choice_options_'+i+'[]" placeholder="{{ translate('Enter choice values') }}" data-on-change="update_sku"></div></div>');
		
    	AIZ.plugins.tagify();
    }

	$('input[name="colors_active"]').on('change', function() {
	    if(!$('input[name="colors_active"]').is(':checked')){
			$('#colors').prop('disabled', true);
		}
		else{
			$('#colors').prop('disabled', false);
		}
		update_sku();
	});

	$('#colors').on('change', function() {
	    update_sku();
	});

	$('input[name="unit_price"]').on('keyup', function() {
	    update_sku();
	});

	$('input[name="name"]').on('keyup', function() {
	    update_sku();
	});

	function delete_row(em){
		$(em).closest('.form-group row').remove();
		update_sku();
	}

    function delete_variant(em){
		$(em).closest('.variant').remove();
	}

	function update_sku(){
		$.ajax({
		   type:"POST",
		   url:'{{ route('products.sku_combination') }}',
		   data:$('#choice_form').serialize(),
		   success: function(data){
			   $('#sku_combination').html(data);
			   if (data.length > 1) {
				   $('#quantity').hide();
			   }
			   else {
					$('#quantity').show();
			   }
		   }
	   });
	}
	
	function check_product_name(){
	   event.preventDefault();
	   
	    	$.ajax({
		   type:"POST",
		   url:'{{ route('products.store') }}',
		   data:$('#choice_form').serialize(),
		   success: function(data){
			  if(data==0){
			      $('#product_name_error').html('<p style="color:red;">Product With Same Name Exits!</p>')
			       AIZ.plugins.notify('danger', '{{ translate('Product With Same Name Exits!') }}');
			       
			  }
			 if(data==1){
			     location.reload();
			     
			  }
		   }
	   });
	   
	}	
	
	
	

	function get_subcategories_by_category(){
		var category_id = $('#category_id').val();
		$.post('{{ route('subcategories.get_subcategories_by_category') }}',{_token:'{{ csrf_token() }}', category_id:category_id}, function(data){
		    $('#subcategory_id').html(null);
		    for (var i = 0; i < data.length; i++) {
		        $('#subcategory_id').append($('<option>', {
		            value: data[i].id,
		            text: data[i].name
		        }));
		        $(".aiz-selectpicker").selectpicker();
		    }
		    get_subsubcategories_by_subcategory();
		});
	}

	function get_subsubcategories_by_subcategory(){
		var subcategory_id = $('#subcategory_id').val();
		$.post('{{ route('subsubcategories.get_subsubcategories_by_subcategory') }}',{_token:'{{ csrf_token() }}', subcategory_id:subcategory_id}, function(data){
		    $('#subsubcategory_id').html(null);
			$('#subsubcategory_id').append($('<option>', {
				value: null,
				text: null
			}));
		    for (var i = 0; i < data.length; i++) {
		        $('#subsubcategory_id').append($('<option>', {
		            value: data[i].id,
		            text: data[i].name
		        }));
		        $(".aiz-selectpicker").selectpicker();
		    }
		    //get_brands_by_subsubcategory();
			//get_attributes_by_subsubcategory();
		});
	}

	function get_brands_by_subsubcategory(){
		var subsubcategory_id = $('#subsubcategory_id').val();
		$.post('{{ route('subsubcategories.get_brands_by_subsubcategory') }}',{_token:'{{ csrf_token() }}', subsubcategory_id:subsubcategory_id}, function(data){
		    $('#brand_id').html(null);
		    for (var i = 0; i < data.length; i++) {
		        $('#brand_id').append($('<option>', {
		            value: data[i].id,
		            text: data[i].name
		        }));
		        $(".aiz-selectpicker").selectpicker();
		    }
		});
	}

	function get_attributes_by_subsubcategory(){
		var subsubcategory_id = $('#subsubcategory_id').val();
		$.post('{{ route('subsubcategories.get_attributes_by_subsubcategory') }}',{_token:'{{ csrf_token() }}', subsubcategory_id:subsubcategory_id}, function(data){
		    $('#choice_attributes').html(null);
		    for (var i = 0; i < data.length; i++) {
		        $('#choice_attributes').append($('<option>', {
		            value: data[i].id,
		            text: data[i].name
		        }));
		    }
			$(".aiz-selectpicker").selectpicker();
		});
	}

	$(document).ready(function(){
	    get_subcategories_by_category();
	});

	$('#category_id').on('change', function() {
	    get_subcategories_by_category();
	});

	$('#subcategory_id').on('change', function() {
	    get_subsubcategories_by_subcategory();
	});

	$('#subsubcategory_id').on('change', function() {
	    // get_brands_by_subsubcategory();
		//get_attributes_by_subsubcategory();
	});

	$('#choice_attributes').on('change', function() {
		$('#customer_choice_options').html(null);
		$.each($("#choice_attributes option:selected"), function(){
            add_more_customer_choice_option($(this).val(), $(this).text());
        });
		update_sku();
	});


</script>

@endsection
