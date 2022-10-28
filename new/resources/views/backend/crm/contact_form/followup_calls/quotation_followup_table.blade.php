<div class="col-lg-12 table-responsive">
    				<table class="table table-bordered invoice-summary">
        				<thead>
            				<tr class="bg-trans-dark">
                                <td class="text-center" width="40%"><label class="control-label">{{translate('Product')}}</label></td>
                                        <td class="text-center" width="15%"><label class="control-label">{{translate('Base Price')}}</label></td>
                                        <td class="text-center"><label class="control-label">{{translate('Discount')}}</label></td>
                                        <td class="text-center" width="15%"><label class="control-label">{{translate('DiscountType')}}</label></td>
                                        <td class="text-center" width="15%"><label class="control-label">{{translate('Quantity')}}</label></td>
                                        <td class="text-center" width="15%"><label class="control-label">{{translate('DiscountPrice')}}</label></td>
            				</tr>
        				</thead>
        				<tbody>
        				   
        				    @foreach($shortlisted_product as $key => $quotation_data)
                       <tr>
                                                <td>
                                                    <div class="from-group row">
                                                        <div class="col-sm-5"><label for="" class="col-from-label"> {{$quotation_data->product->name}}</label></div>
                                                    </div>
                                                </td>
                                                <td>{{$quotation_data->base_price}}</td>
                                                <td>{{$quotation_data->wholesale_discount}}</td>
                                                <td>
                                                    @if( $quotation_data->wholesale_discount_type== '$'){{'Flat'}} @else {{'Percent'}} @endif
                                                </td>
                                                <td>{{$quotation_data->wholesale_quintity}}</td>
                                                <td>{{$quotation_data->wholesale_discount_price}}</td>
                                            </tr>
                        @endforeach
            </tbody>
    				</table>
    				<div class="aiz-pagination">
             @if ($shortlisted_product->lastPage() > 1)
<ul class="followup_call pagination">
    <li class="{{ ($shortlisted_product->currentPage() == 1) ? ' disabled' : '' }} page-item">
        <a class="page-link" href="{{ $shortlisted_product->url(1) }}"><</a>
    </li>
    @for ($i = 1; $i <= $shortlisted_product->lastPage(); $i++)
        <li class="{{ ($shortlisted_product->currentPage() == $i) ? ' active' : '' }} page-item">
            <a class="page-link" href="{{ $shortlisted_product->url($i) }}">{{ $i }}</a>
        </li>
    @endfor
    <li class="{{ ($shortlisted_product->currentPage() == $shortlisted_product->lastPage()) ? ' disabled' : '' }} page-item">
        <a class="page-link" href="{{ $shortlisted_product->url($shortlisted_product->currentPage()+1) }}" >></a>
    </li>
</ul>
@endif
        </div>
    			</div>