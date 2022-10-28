<h3>Quotation Invoice</h3>
<p>Quotation Name - {{ $quotation[0]->quotation_name }}</p>
<p>Quotation Number - {{ $quotation[0]->quotation_number }}</p>
<p>Seller Name - {{ $quotation[0]->reseller->name }}</p>
@php
	$product= \App\Product::where('id', $quotation[0]->product_id)->first();

@endphp
<p>Product Name - {{ $product->name}}</p>
@foreach ($quotation as $quotation_data)
	@php
		$variant = \App\ProductStock::where('id', $quotation_data->variant_id)->first();	
	@endphp
	<p>Variant Name - {{ $variant->variant}}
	<p>Wholeasle Base Price- {{$quotation_data->base_price}} </p>
	<p>Wholeasle Discount Price - {{$quotation_data->wholesale_discount_price}}</p>
	<p>Wholeasle Discount Type - {{$quotation_data->wholesale_discount_type}}</p>
	<p>Quintity - {{$quotation_data->wholesale_quintity}}</p>
	<p>Wholesale Discount Price - {{$quotation_data->wholesale_discount_price}}</p>
@endforeach

<p> Total - {{$quotation[0]->total}}</p>

</html>
