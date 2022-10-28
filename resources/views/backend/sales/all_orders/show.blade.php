@extends('backend.layouts.app')

@section('content')
@if($order->user->user_type=='wholesaler' || $order->user->user_type=='reseller' )

 <div class="card">
        <div class="card-header">
          <h1 class="h2">{{ translate('Order Details') }}</h1>
        </div>
        <div class="card-header row gutters-5">
  			<div class="col text-center text-md-left">
  			</div>
              @php
                  $delivery_stat =\App\OrderDetail::where('order_id',$order->id )->get();
                  $no_of_products=count($delivery_stat);
                  $no_of_cancel=0;
                   $no_of_return=0;
                   $total_cancel_amount=0;
                   $total_tax_cancel=0;
                    $no_of_pending=0;
                    $no_of_confirmed=0;
                    $no_of_on_delivery=0;
                    $no_of_delivered=0;
                 foreach($delivery_stat as $delivery){
                  if($delivery->delivery_status =='pending'){
                  $delivery_status='pending';
                    $no_of_pending=$no_of_pending+1;
                  }
                  if($delivery->delivery_status=='confirmed'){
                  
                    $delivery_status='confirmed';
                      $no_of_confirmed=$no_of_confirmed+1;
                         
                  }
                  if($delivery->delivery_status=='on_delivery'){
                  
                    $delivery_status='on_delivery';
                      $no_of_on_delivery=$no_of_on_delivery+1;
                       
                  }
                   if($delivery->delivery_status=='delivered'){
                     
                    $delivery_status='delivered';
                      $no_of_delivered=$no_of_delivered+1;
                          }
                     if($delivery->delivery_status=='cancel'){
                        $total_cancel_amount=$total_cancel_amount+ $delivery->price;
                        $total_tax_cancel=$total_tax_cancel+$delivery->tax;
                        $no_of_cancel=$no_of_cancel+1;
                   
                          }
                          if($delivery->delivery_status=='return'){
                     
                        $no_of_return=$no_of_return+1;
                   
                          }
                  }
                  if($no_of_products==$no_of_cancel){
                   $delivery_status='cancel';
                  }
                  
                     if($no_of_pending<$no_of_return){
                   $delivery_status='return';
                  }
                  
                   if($no_of_confirmed<$no_of_return){
                   $delivery_status='return';
                  }
                   if($no_of_on_delivery<$no_of_return){
                   $delivery_status='return';
                  }
                   if($no_of_delivered<$no_of_return){
                   $delivery_status='return';
                  }
                 
                  $payment_status = $order->orderDetails->first()->payment_status;
              @endphp
              <div class="col-md-3 ml-auto">
                  <label for=update_payment_status"">{{translate('Payment Status')}}</label>
                  <select class="form-control aiz-selectpicker"  data-minimum-results-for-search="Infinity" id="update_payment_status">
                      <option value="paid" @if ($payment_status == 'paid') selected @endif>{{translate('Paid')}}</option>
                      <option value="unpaid" @if ($payment_status == 'unpaid') selected @endif>{{translate('Unpaid')}}</option>
                  </select>
              </div>
  			<div class="col-md-3 ml-auto">
                  <label for=update_delivery_status"">{{translate('Delivery Status')}}</label>
                  <select class="form-control aiz-selectpicker"  data-minimum-results-for-search="Infinity" id="update_delivery_status">
                      <option value="pending" @if ($delivery_status == 'pending') selected @endif>{{translate('Pending')}}</option>
                      <option value="confirmed" @if ($delivery_status == 'confirmed') selected @endif>{{translate('Confirmed')}}</option>
                      <option value="on_delivery" @if ($delivery_status == 'on_delivery') selected @endif>{{translate('On delivery')}}</option>
                      <option value="delivered" @if ($delivery_status == 'delivered') selected @endif>{{translate('Delivered')}}</option>
                      <option value="cancel" @if ($delivery_status == 'cancel') selected @endif>{{translate('Cancel')}}</option>
                       <option value="return" @if ($delivery_status == 'return') selected @endif>{{translate('Return')}}</option>
                  </select>
  			</div>
  		</div>
    	<div class="card-body">
        <div class="card-header row gutters-6">
  			<div class="col text-center text-md-left">
            <address>
                <strong class="text-main">{{ json_decode($order->shipping_address)->name }}</strong><br>
                {{ json_decode($order->shipping_address)->email }}<br>
                {{ json_decode($order->shipping_address)->phone }}<br>
                {{ json_decode($order->shipping_address)->address }}, {{ json_decode($order->shipping_address)->city }}, {{ json_decode($order->shipping_address)->postal_code }}<br>
                 {{ json_decode($order->shipping_address)->state }},
                {{ json_decode($order->shipping_address)->country }}
            </address>
            @if ($order->manual_payment && is_array(json_decode($order->manual_payment_data, true)))
                <br>
                <strong class="text-main">{{ translate('Payment Information') }}</strong><br>
                {{ translate('Name') }}: {{ json_decode($order->manual_payment_data)->name }}, {{ translate('Amount') }}: {{ single_price(json_decode($order->manual_payment_data)->amount) }}, {{ translate('TRX ID') }}: {{ json_decode($order->manual_payment_data)->trx_id }}
                <br>
                <a href="{{ uploaded_asset(json_decode($order->manual_payment_data)->photo) }}" target="_blank"><img src="{{ uploaded_asset(json_decode($order->manual_payment_data)->photo) }}" alt="" height="100"></a>
            @endif
  				</div>
  				<div class="col-md-4 ml-auto">
            <table>
        				<tbody>
            				<tr>
            					<td class="text-main text-bold">{{translate('Order #')}}</td>
            					<td class="text-right text-info text-bold">	{{ $order->code }}</td>
            				</tr>
            				<tr>
                                <td class="text-main text-bold">{{translate('Order Status')}}</td>
                                    @php
                                      $status = $delivery_status;
                                    @endphp
            					<td class="text-right">
                                    @if($status == 'delivered')
                                        <span class="badge badge-inline badge-success">{{ translate(ucfirst(str_replace('_', ' ', $status))) }}</span>
                                    @else
                                        <span class="badge badge-inline badge-info">{{ translate(ucfirst(str_replace('_', ' ', $status))) }}</span>
                                    @endif
      					        </td>
            				</tr>
            				<tr>
            					<td class="text-main text-bold">{{translate('Order Date')}}	</td>
            					<td class="text-right">{{ date('d-m-Y h:i A', $order->date) }}</td>
            				</tr>
                    <tr>
            					<td class="text-main text-bold">{{translate('Total amount')}}	</td>
            					<td class="text-right">
            						{{ single_price($order->grand_total) }}
            					</td>
            				</tr>
                    <tr>
            					<td class="text-main text-bold">{{translate('Payment method')}}</td>
            					<td class="text-right">{{ ucfirst(str_replace('_', ' ', $order->payment_type)) }}</td>
            				</tr>
        				</tbody>
    				</table>
  				</div>
  			</div>
    		<hr class="new-section-sm bord-no">
    		<div class="row">
    			<div class="col-lg-12 table-responsive">
    			    <form class="box form form-horizontal mar-top" action="{{route('wholesale_orders')}}" method="POST" enctype="multipart/form-data">
    			        	<input type="hidden" name="order_id" value="{{$order->id}}">
    			        	
    			        @csrf
    				<table class="table table-bordered invoice-summary">
        				<thead>
            				<tr class="bg-trans-dark">
                        <th class="min-col">#</th>
                        <th width="10%">{{translate('Photo')}}</th>
        					      <th class="text-uppercase">{{translate('Description')}}</th>
                       
              					<th class="min-col text-center text-uppercase">{{translate('Qty')}}</th>
              					<th class="min-col text-center text-uppercase">{{translate('Price')}}</th>
        					       <th class="min-col text-right text-uppercase">{{translate('Total')}}</th>
        					       <th class="min-col text-right text-uppercase">{{translate('Delivery Status')}}</th>
            				</tr>
        				</thead>
        				<tbody>
                    @foreach ($order->orderDetails as $key => $orderDetail)
                      <tr>
                        <td>{{ $key+1 }}</td>
                        <td>
                          @if ($orderDetail->product != null)
                          	<input type="hidden" name="product_id[]" value="{{$orderDetail->product_id}}">
                          		<input type="hidden" name="variation[]" value="{{$orderDetail->variation}}">
                            <a href="{{ route('product', $orderDetail->product->slug) }}" target="_blank"><img height="50" src={{ uploaded_asset($orderDetail->product->thumbnail_img) }}/></a>
                          @else
                            <strong>{{ translate('N/A') }}</strong>
                          @endif
                          </td>
                        <td>
                          @if ($orderDetail->product != null)
                            <strong><a href="{{ route('product', $orderDetail->product->slug) }}" target="_blank" class="text-muted">{{ $orderDetail->product->getTranslation('name') }}</a></strong>
                            <small>{{ $orderDetail->variation }}</small>
                          @else
                            <strong>{{ translate('Product Unavailable') }}</strong>
                          @endif
                        </td>
                       
                         <td class="text-center">	<input type="number" class="form-control order_quantity" name="order_quantity[]" id="order_quantity_{{$orderDetail->id}}"  value="{{ $orderDetail->quantity }}" min="1" required></td>
                        <td class="text-center">	<input type="number" class="form-control order_price" name="order_price[]" id="order_price_{{$orderDetail->id}}" value="{{ $orderDetail->price/$orderDetail->quantity }}" min="1" required></td>
                        <td class="text-center" id="order_detail_total_price_{{$orderDetail->id}}">{{ single_price($orderDetail->price) }}</td>
                        <td class="text-center">
                            @if($delivery_status !='on_delivery' && $delivery_status !='delivered' && $delivery_status !='cancel')
                        <select class="form-control aiz-selectpicker update_delivery_status_single"  data-minimum-results-for-search="Infinity" id="{{ $orderDetail->id }}" >
                      
                    
                      <option value="confirmed" @if ($orderDetail['product_status'] == 'confirmed') selected @endif>{{translate('Confirmed')}}</option>
                      <!--<option value="return" @if ($orderDetail['product_status'] == 'return') selected @endif>{{translate('Return')}}</option>-->
                      <option value="cancel" @if ($orderDetail['product_status'] == 'cancel') selected @endif>{{translate('Cancel')}}</option>
                        
                    
                  </select>
                   @elseif($delivery_status =='cancel')
                   <p>{{ $orderDetail['product_status'] }}</p>
                  @else
                  <p>{{ $orderDetail['product_status'] }}</p>
                  @endif
  			</td>
                      </tr>
                    @endforeach
                     <button type="submit"  class="btn btn-success" style="margin-top: 15px;"> Order Save </button>
    				
        				</tbody>
    				</table>
    					<strong class="text-muted">{{translate('Shipping/Courier Cost')}} :</strong>
    				<input type="text" class="col-md-3 form-control" name="shipping_cost" id="shipping_cost" value="{{$order->orderDetails->sum('shipping_cost')}}">
    				</form>
    			</div>
    		</div>
    		<div class="clearfix float-right" id="order_calculation">
    			<table class="table">
        			<tbody>
        			<tr>
        				<td>
        					<strong class="text-muted">{{translate('Sub Total')}} :</strong>
        				</td>
        				<td>
        					{{ single_price($order->orderDetails->sum('price')-$total_cancel_amount) }}
        				</td>
        			</tr>
              @if(json_decode($order->shipping_address)->state!='Uttar Pradesh')   
              <tr>
                <td>
                  <strong class="text-muted">{{translate('IGST')}} :</strong>
                </td>
                <td>
                  {{ single_price($order->orderDetails->sum('tax')) }}
                </td>
              </tr>
              
              @endif
              @if(json_decode($order->shipping_address)->state=='Uttar Pradesh')   
        			<tr>
        				<td>
        					<strong class="text-muted">{{translate('CGST')}} :</strong>
        				</td>
        				<td>
        					{{ single_price($order->orderDetails->sum('tax')/2-($total_tax_cancel/2)) }}
        				</td>
        			</tr>
              <tr>
                <td>
                  <strong class="text-muted">{{translate('SGST')}} :</strong>
                </td>
                <td>
                  {{ single_price($order->orderDetails->sum('tax')/2-($total_tax_cancel/2)) }}
                </td>
              </tr>
              @endif
                    <tr>
        				<td>
        					<strong class="text-muted">{{translate('Shipping')}} :</strong>
        				</td>
        				<td>
        					{{ single_price($order->orderDetails->sum('shipping_cost')) }}
        				</td>
        			</tr>
        				<tr>
        				<td>
        					<strong class="text-muted">{{translate('Coupon')}} :</strong>
        				</td>
        				<td >
        					{{ single_price($order->coupon_discount) }}
        				</td>
        			</tr>
        				<tr>
        				<td>
        					<strong class="text-muted">{{translate('Cancel Amount')}} :</strong>
        				</td>
        				<td >
        				  {{ single_price($total_cancel_amount) }}
        				</td>
        			</tr>
        			<tr>
        				<td>
        					<strong class="text-muted">{{translate('TOTAL')}} :</strong>
        				</td>
        				<td class="text-muted h5">
        				   	<input type="hidden" name="grand_total" id="grand_total" value="{{$order->grand_total-$total_cancel_amount}}">
        					{{ single_price($order->grand_total-$total_cancel_amount) }}
        				</td>
        			</tr>
        			</tbody>
    			</table>
          <div class="text-right no-print">
            <a href="{{ route('customer.invoice.download', $order->id) }}" type="button" class="btn btn-icon btn-light"><i class="las la-print"></i></a>
          </div>
    		</div>

    	</div>
    </div>

@else
    <div class="card">
        <div class="card-header">
          <h1 class="h2">{{ translate('Order Details') }}</h1>
        </div>
        <div class="card-header row gutters-5">
  			<div class="col text-center text-md-left">
  			</div>
              @php
                  $delivery_stat =\App\OrderDetail::where('order_id',$order->id )->get();
                  $no_of_products=count($delivery_stat);
                  $no_of_cancel=0;
                   $no_of_return=0;
                   $total_cancel_amount=0;
                   $total_tax_cancel=0;
                 foreach($delivery_stat as $delivery){
                  if($delivery->delivery_status =='pending'){
                  $delivery_status='pending';
                  }
                  if($delivery->delivery_status=='confirmed'){
                  
                    $delivery_status='confirmed';
                         
                  }
                  if($delivery->delivery_status=='on_delivery'){
                  
                    $delivery_status='on_delivery';
                       
                  }
                   if($delivery->delivery_status=='delivered'){
                     
                    $delivery_status='delivered';
                          }
                     if($delivery->delivery_status=='cancel'){
                        $total_cancel_amount=$total_cancel_amount+ $delivery->price;
                        $total_tax_cancel=$total_tax_cancel+$delivery->tax;
                        $no_of_cancel=$no_of_cancel+1;
                       $delivery_status='cancel';
                          }
                          if($delivery->delivery_status=='return'){
                     
                        $no_of_return=$no_of_return+1;
                     $delivery_status='return';
                          }
                  }
                  if($no_of_products==$no_of_cancel){
                   $delivery_status='cancel';
                  }
                  
                     if($no_of_products==$no_of_return){
                   $delivery_status='return';
                  }
                  
                  
                  if($no_of_return>0){
                   $delivery_status='return';
                  }
                 
                  $payment_status = $order->orderDetails->first()->payment_status;
              @endphp
              <div class="col-md-3 ml-auto">
                  <label for=update_payment_status"">{{translate('Payment Status')}}</label>
                  <select class="form-control aiz-selectpicker"  data-minimum-results-for-search="Infinity" id="update_payment_status">
                      <option value="paid" @if ($payment_status == 'paid') selected @endif>{{translate('Paid')}}</option>
                      <option value="unpaid" @if ($payment_status == 'unpaid') selected @endif>{{translate('Unpaid')}}</option>
                  </select>
              </div>
  			<div class="col-md-3 ml-auto">
                  <label for=update_delivery_status"">{{translate('Delivery Status')}}</label>
                  <select class="form-control aiz-selectpicker"  data-minimum-results-for-search="Infinity" id="update_delivery_status">
                      <option value="pending" @if ($delivery_status == 'pending') selected @endif>{{translate('Pending')}}</option>
                      <option value="confirmed" @if ($delivery_status == 'confirmed') selected @endif>{{translate('Confirmed')}}</option>
                      <option value="on_delivery" @if ($delivery_status == 'on_delivery') selected @endif>{{translate('On delivery')}}</option>
                      <option value="delivered" @if ($delivery_status == 'delivered') selected @endif>{{translate('Delivered')}}</option>
                      <option value="cancel" @if ($delivery_status == 'cancel') selected @endif>{{translate('Cancel')}}</option>
                       <option value="return" @if ($delivery_status == 'return') selected @endif>{{translate('Return')}}</option>
                  </select>
  			</div>
  		</div>
    	<div class="card-body">
        <div class="card-header row gutters-6">
  			<div class="col text-center text-md-left">
            <address>
                <strong class="text-main">{{ json_decode($order->shipping_address)->name }}</strong><br>
                {{ json_decode($order->shipping_address)->email }}<br>
                {{ json_decode($order->shipping_address)->phone }}<br>
                {{ json_decode($order->shipping_address)->address }}, {{ json_decode($order->shipping_address)->city }}, {{ json_decode($order->shipping_address)->postal_code }}<br>
                 {{ json_decode($order->shipping_address)->state }},
                {{ json_decode($order->shipping_address)->country }}
             </address>
            @if ($order->manual_payment && is_array(json_decode($order->manual_payment_data, true)))
                <br>
                <strong class="text-main">{{ translate('Payment Information') }}</strong><br>
                {{ translate('Name') }}: {{ json_decode($order->manual_payment_data)->name }}, {{ translate('Amount') }}: {{ single_price(json_decode($order->manual_payment_data)->amount) }}, {{ translate('TRX ID') }}: {{ json_decode($order->manual_payment_data)->trx_id }}
                <br>
                <a href="{{ uploaded_asset(json_decode($order->manual_payment_data)->photo) }}" target="_blank"><img src="{{ uploaded_asset(json_decode($order->manual_payment_data)->photo) }}" alt="" height="100"></a>
            @endif
  				</div>
  				<div class="col-md-4 ml-auto">
            <table>
        				<tbody>
            				<tr>
            					<td class="text-main text-bold">{{translate('Order #')}}</td>
            					<td class="text-right text-info text-bold">	{{ $order->code }}</td>
            				</tr>
            				<tr>
                                <td class="text-main text-bold">{{translate('Order Status')}}</td>
                                    @php
                                      $status = $delivery_status;
                                    @endphp
            					<td class="text-right">
                                    @if($status == 'delivered')
                                        <span class="badge badge-inline badge-success">{{ translate(ucfirst(str_replace('_', ' ', $status))) }}</span>
                                    @else
                                        <span class="badge badge-inline badge-info">{{ translate(ucfirst(str_replace('_', ' ', $status))) }}</span>
                                    @endif
      					        </td>
            				</tr>
            				<tr>
            					<td class="text-main text-bold">{{translate('Order Date')}}	</td>
            					<td class="text-right">{{ date('d-m-Y h:i A', $order->date) }}</td>
            				</tr>
                    <tr>
            					<td class="text-main text-bold">{{translate('Total amount')}}	</td>
            					<td class="text-right">
            						{{ single_price($order->grand_total) }}
            					</td>
            				</tr>
                    <tr>
            					<td class="text-main text-bold">{{translate('Payment method')}}</td>
            					<td class="text-right">{{ ucfirst(str_replace('_', ' ', $order->payment_type)) }}</td>
            				</tr>
        				</tbody>
    				</table>
  				</div>
  			</div>
    		<hr class="new-section-sm bord-no">
    		<div class="row">
    			<div class="col-lg-12 table-responsive">
    				<table class="table table-bordered invoice-summary">
        				<thead>
            				<tr class="bg-trans-dark">
                        <th class="min-col">#</th>
                        <th width="10%">{{translate('Photo')}}</th>
        					      <th class="text-uppercase">{{translate('Description')}}</th>
                       
              					<th class="min-col text-center text-uppercase">{{translate('Qty')}}</th>
              					<th class="min-col text-center text-uppercase">{{translate('Price')}}</th>
        					       <th class="min-col text-right text-uppercase">{{translate('Total')}}</th>
        					       <th class="min-col text-right text-uppercase">{{translate('Delivery Status')}}</th>
            				</tr>
        				</thead>
        				<tbody>
                    @foreach ($order->orderDetails as $key => $orderDetail)
                      <tr>
                        <td>{{ $key+1 }}</td>
                        <td>
                          @if ($orderDetail->product != null)
                            <a href="{{ route('product', $orderDetail->product->slug) }}" target="_blank"><img height="50" src={{ uploaded_asset($orderDetail->product->thumbnail_img) }}/></a>
                          @else
                            <strong>{{ translate('N/A') }}</strong>
                          @endif
                          </td>
                        <td>
                          @if ($orderDetail->product != null)
                            <strong><a href="{{ route('product', $orderDetail->product->slug) }}" target="_blank" class="text-muted">{{ $orderDetail->product->getTranslation('name') }}</a></strong>
                            <small>{{ $orderDetail->variation }}</small>
                          @else
                            <strong>{{ translate('Product Unavailable') }}</strong>
                          @endif
                        </td>
                       
                        <td class="text-center">{{ $orderDetail->quantity }}</td>
                        <td class="text-center">{{ single_price($orderDetail->price/$orderDetail->quantity) }}</td>
                        <td class="text-center">{{ single_price($orderDetail->price) }}</td>
                        <td class="text-center">
                            @if($delivery_status !='on_delivery' && $delivery_status !='delivered' && $delivery_status !='cancel')
                        <select class="form-control aiz-selectpicker update_delivery_status_single"  data-minimum-results-for-search="Infinity" id="{{ $orderDetail->id }}" >
                      
                    
                      <option value="confirmed" @if ($orderDetail['product_status'] == 'confirmed') selected @endif>{{translate('Confirmed')}}</option>
                      <!--<option value="return" @if ($orderDetail['product_status'] == 'return') selected @endif>{{translate('Return')}}</option>-->
                      <option value="cancel" @if ($orderDetail['product_status'] == 'cancel') selected @endif>{{translate('Cancel')}}</option>
                        
                    
                  </select>
                   @elseif($delivery_status =='cancel')
                   <p>{{ $orderDetail['product_status'] }}</p>
                  @else
                  <p>{{ $orderDetail['product_status'] }}</p>
                  @endif
  			</td>
                      </tr>
                    @endforeach
        				</tbody>
    				</table>
    			</div>
    		</div>
    		<div class="clearfix float-right" >
    			<table class="table">
        			<tbody>
        			<tr>
        				<td>
        					<strong class="text-muted">{{translate('Sub Total')}} :</strong>
        				</td>
        				<td>
        					{{ single_price($order->orderDetails->sum('price')-$total_cancel_amount) }}
        				</td>
        			</tr>
              @if(json_decode($order->shipping_address)->state!='Uttar Pradesh')   
              <tr>
                <td>
                  <strong class="text-muted">{{translate('IGST')}} :</strong>
                </td>
                <td>
                  {{ single_price($order->orderDetails->sum('tax')) }}
                </td>
              </tr>
              
              @endif
              @if(json_decode($order->shipping_address)->state=='Uttar Pradesh')   
        			<tr>
        				<td>
        					<strong class="text-muted">{{translate('CGST')}} :</strong>
        				</td>
        				<td>
        					{{ single_price($order->orderDetails->sum('tax')/2-($total_tax_cancel/2)) }}
        				</td>
        			</tr>
              <tr>
                <td>
                  <strong class="text-muted">{{translate('SGST')}} :</strong>
                </td>
                <td>
                  {{ single_price($order->orderDetails->sum('tax')/2-($total_tax_cancel/2)) }}
                </td>
              </tr>
              @endif
                    <tr>
        				<td>
        					<strong class="text-muted">{{translate('Shipping')}} :</strong>
        				</td>
        				<td>
        					{{ single_price($order->orderDetails->sum('shipping_cost')) }}
        				</td>
        			</tr>
        				<tr>
        				<td>
        					<strong class="text-muted">{{translate('Coupon')}} :</strong>
        				</td>
        				<td >
        					{{ single_price($order->coupon_discount) }}
        				</td>
        			</tr>
        				<tr>
        				<td>
        					<strong class="text-muted">{{translate('Wallet')}} :</strong>
        				</td>
        				<td >
        					{{ single_price($order->wallet_discount) }}
        				</td>
        			</tr>
        				<tr>
        				<td>
        					<strong class="text-muted">{{translate('Cancel Amount')}} :</strong>
        				</td>
        				<td >
        				  {{ single_price($total_cancel_amount) }}
        				</td>
        			</tr>
        			<tr>
        				<td>
        					<strong class="text-muted">{{translate('TOTAL')}} :</strong>
        				</td>
        				<td class="text-muted h5">
        					{{ single_price($order->grand_total-$total_cancel_amount-$order->wallet_discount) }}
        				</td>
        			</tr>
        			</tbody>
    			</table>
          <div class="text-right no-print">
            <a href="{{ route('customer.invoice.download', $order->id) }}" type="button" class="btn btn-icon btn-light"><i class="las la-print"></i></a>
          </div>
    		</div>

    	</div>
    </div>
@endif    
    
    
    
    
    
    
     <div class="container">

  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
      <div class="modal-header">
                <h4 class="modal-title">Product Cancel</h4>
            </div>
            <div class="modal-body">
                <form class="form">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                         
                    <div class="form-group">   
                        <label label="cancel_reason"  >Cancel  Reason</label>
                        <input type="text" placeholder="Cancel Reason" class="form-control" id="cancel_reason" name="cancel_reason" required>
                    </div>
                     </div>
           
                       <div class="col-md-6">
                      <input type="submit" id="cancel_button" class="btn btn-success" name="submit" style="margin-top: 15px;" id="submit">
                       </div>

                       <div class="col-md-6">
                 <div class="modal-footer">
                <button type="button"  class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
                       </div>
                      
                    </div>
                  
                </form>
            </div>  
       
      </div>
      
    </div>
  </div>
  
  <div class="modal fade" id="myModal1" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
      <div class="modal-header">
                <h4 class="modal-title">Product Return</h4>
            </div>
            <div class="modal-body">
                <form class="form">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                         
                    <div class="form-group">   
                        <label label="cancel_reason" >Return  Reason</label>
                        <input type="text" placeholder="Return Reason" class="form-control" id="return_reason" name="return_reason" value="" required>
                    </div>
                     </div>
           
                       <div class="col-md-6">
                      <input type="submit" id="return_button" class="btn btn-success" name="submit" style="margin-top: 15px;" id="submit">
                       </div>

                       <div class="col-md-6">
                 <div class="modal-footer">
                <button type="button"  class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
                       </div>
                      
                    </div>
                  
                </form>
            </div>  
       
      </div>
      
    </div>
  </div>
  <div class="modal fade" id="myModal2" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content--> 
      <div class="modal-content">
      <div class="modal-header">
                <h4 class="modal-title">Product Expacted Delivery</h4>
            </div>
            <div class="modal-body">
                <form class="form">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                         
                    <div class="form-group">   
                        <label label="cancel_reason" >Expacted Delivery</label>
                        <input type="date" placeholder="Expacted Delivery" class="form-control" id="expacted_delivery" name="expacted_delivery" value="" required>
                    </div>
                     </div>
            <div class="col-md-6">
                         
                    <div class="form-group">   
                        <label label="cancel_reason" >Length</label>
                        <input type="text" placeholder="Length" class="form-control" id="length" name="length"  required>cm
                    </div>
                     </div>
                     <div class="col-md-6">
                         
                    <div class="form-group">   
                        <label label="cancel_reason" >Breath</label>
                        <input type="text" placeholder="Breath" class="form-control" id="breath" name="breath"  required>cm
                    </div>
                     </div>
                     <div class="col-md-6">
                         
                    <div class="form-group">   
                        <label label="cancel_reason" >Height</label>
                        <input type="text" placeholder="Height" class="form-control" id="height" name="height"  required>cm
                    </div>
                     </div>
                     <div class="col-md-6">
                         
                    <div class="form-group">   
                        <label label="cancel_reason" >Weight</label>
                        <input type="text" placeholder="Weight" class="form-control" id="weight" name="weight"  required>kg
                    </div>
                     </div>
                       <div class="col-md-6">
                      <input type="submit" id="expacted_delivery_button" class="btn btn-success" name="submit" style="margin-top: 15px;" id="submit">
                       </div>
                          
                       <div class="col-md-6">
                 <div class="modal-footer">
                <button type="button"  class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
                       </div>
                      
                    </div>
                  
                </form>
            </div>  
       
      </div>
      
    </div>
  </div>
  
</div>
@endsection
@section('script')
    <script type="text/javascript">
        $('#update_delivery_status').on('change', function(){
            var order_id = {{ $order->id }};
            var status = $('#update_delivery_status').val();
           
            
             if(status=='on_delivery'){
             $('#myModal2').modal('show');  
             
             $("#expacted_delivery_button").on("click", function(){
                 var expacted_delivery_date=$('#expacted_delivery').val();
                 var length = $('#length').val();
                 var breadth = $('#breath').val();
                 var height = $('#height').val();
                 var weight = $('#weight').val();
                 $.post('{{ route('orders.update_delivery_status') }}', {_token:'{{ @csrf_token() }}',order_id:order_id,status:status,expacted_delivery:expacted_delivery_date,length:length,breadth:breadth,height:height,weight:weight}, function(data){
                   
                    console.log(data);
                    AIZ.plugins.notify('success', '{{ translate('Delivery status has been updated') }}');
                });
             });
            }
            else{
            $.post('{{ route('orders.update_delivery_status') }}', {_token:'{{ @csrf_token() }}',order_id:order_id,status:status}, function(data){
                AIZ.plugins.notify('success', '{{ translate('Delivery status has been updated') }}');
            });
            }
        });
        
         $('.update_delivery_status_single').on('change', function(){
            var order_id = {{ $order->id }};
            var order_detail_id=$(this).attr('id');
            var status = $('#'+order_detail_id).val();
           alert(status);
             if(status=='cancel'){
             $('#myModal').modal('show');
             $("#cancel_button").on("click", function(){
                 var reason=$('#cancel_reason').val();
                 
                 $.post('{{ route('orders.update_delivery_status_single') }}', {_token:'{{ @csrf_token() }}',id:order_detail_id,order_id:order_id,status:status,cancel_reason:reason}, function(data){
                    AIZ.plugins.notify('success', '{{ translate('Delivery status has been updated') }}');
                });
             });
            }
            if(status=='return'){
             $('#myModal1').modal('show');
             $("#return_button").on("click", function(){
                 var reason=$('#return_reason').val();
                 $.post('{{ route('orders.update_delivery_status_single') }}', {_token:'{{ @csrf_token() }}',id:order_detail_id,order_id:order_id,status:status,return_reason:reason}, function(data){
                    AIZ.plugins.notify('success', '{{ translate('Delivery status has been updated') }}');
                });
             });
            }
            
            
            
             if(status=='confirmed'){
            $.post('{{ route('orders.update_delivery_status_single') }}', {_token:'{{ @csrf_token() }}',id:order_detail_id,order_id:order_id,status:status}, function(data){
                AIZ.plugins.notify('success', '{{ translate('Delivery status has been updated') }}');
            });
            }
        });

        $('#update_payment_status').on('change', function(){
            var order_id = {{ $order->id }};
            var status = $('#update_payment_status').val();
            $.post('{{ route('orders.update_payment_status') }}', {_token:'{{ @csrf_token() }}',order_id:order_id,status:status}, function(data){
                AIZ.plugins.notify('success', '{{ translate('Payment status has been updated') }}');
            });
        });
        
           $('.order_quantity').on('keyup', function(){
               $('#order_calculation').hide();
            var id=$(this).attr('id');
            var numb = id.match(/\d/g);
              numb = numb.join("");
            
            var price=$('#order_price_'+numb).val();
            var quantity = $(this).val();
            var total_price=(price*quantity);
            $('#order_detail_total_price_'+numb).html('<p id="order_detail_total_price_'+id+'">'+total_price+'</p>');
            
        });
        
         $('.order_price').on('keyup', function(){
              $('#order_calculation').hide();
            var id=$(this).attr('id');
            
            var numb = id.match(/\d/g);
              numb = numb.join("");
             
            var price=$(this).val();
            var quantity =$('#order_quantity_'+numb).val();;
            var total_price=(price*quantity);
            $('#order_detail_total_price_'+numb).html('<p id="order_detail_total_price_'+id+'">'+total_price+'</p>');
            
        });
         $('#shipping_cost').on('keyup', function(){
              $('#order_calculation').hide();
         });
    </script>
@endsection

