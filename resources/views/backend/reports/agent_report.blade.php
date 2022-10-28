@extends('backend.layouts.app')
@section('content')
<div class="aiz-titlebar text-left mt-2 mb-3">
   <div class="row align-items-center">
      <div class="col-md-6">
         <h1 class="h3">{{translate('Agent Reports')}}</h1>
      </div>
   </div>
</div>
<br>

<div class="container mt-5">
   <div class="row">
      <div class="col-md-10 ml-auto col-xl-12 mr-auto">
         <!-- Nav tabs -->
         <div class="card">
            <div class="card-header">
               <ul class="nav nav-tabs justify-content-center" role="tablist">
                  <li class="nav-item">
                     <a class="nav-link active" data-toggle="tab" href="#home" role="tab">
                     <i class="now-ui-icons objects_umbrella-13"></i> Order
                     </a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" data-toggle="tab" href="#profile" role="tab">
                     <i class="now-ui-icons shopping_cart-simple"></i> Quotation
                     </a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" data-toggle="tab" href="#messages" role="tab">
                     <i class="now-ui-icons shopping_shop"></i> Follow-Up
                     </a>
                  </li>
               </ul>
            </div>
            <div class="card-body">
                
                <form class="" id="sort_products" action="" method="GET">
     
   <div class="card-header row gutters-5">
      <div class="col text-center text-md-left">
        
      </div>
      <div class="col-md-2 ml-auto">
         <input type="text" class="form-control aiz-date-range" name="date_range" value="@if(!empty($date_range)){{$date_range}}@endif" placeholder="Select Date"></input>
      </div>
      <div class="col-md-2 ml-auto">
         <select class="form-control  aiz-selectpicker mb-2 mb-md-0" id="user_id" name="user_id" onchange="sort_products()">
            <option value="">{{ translate('All Agent') }}</option>
            @foreach (App\User::where('user_type', '=', 'staff')->get() as $key => $seller)
            @if($seller->staff->role->name=='Agent')
            <option value="{{ $seller->id }}" @if($user_id==$seller->id){{'selected'}}@endif>{{ $seller->name }}</option>
            @endif
            @endforeach
         </select>
      </div>
   </div>
   </from>
                
                
                
               <!-- Tab panes -->
               <div class="tab-content text-center">
                  <div class="tab-pane active" id="home" role="tabpanel">
                      <div class="card">
   
    <div class="card-body">
        <hr>
        <div class = "row">
            <div class="col-md-6">
                <h4>Total Order: {{count($orders)}}</h4>
            </div>
            <div class="col-md-6">
                <h4>Total Order Amount: {{$orders->sum('grand_total')}}</h4>
            </div>
        </div>
        <hr>
        <table class="table aiz-table mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{ translate('Order Code') }}</th>
                    <th>{{ translate('Num. of Products') }}</th>
                    <th>{{ translate('Customer') }}</th>
                    <th>{{ translate('Amount') }}</th>
                    <th>{{ translate('Delivery Status') }}</th>
                    <th>{{ translate('Payment Status') }}</th>
                  
                    <th class="text-right" width="15%">{{translate('options')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $key => $order)
                    <tr>
                        <td>
                            {{ ($key+1) + ($orders->currentPage() - 1)*$orders->perPage() }}
                        </td>
                        <td>
                            {{ $order->code }}
                        </td>
                        <td>
                            {{ count($order->orderDetails) }}
                        </td>
                        <td>
                            @if ($order->user != null)
                                {{ $order->user->name }}
                            @else
                                Guest ({{ $order->guest_id }})
                            @endif
                        </td>
                        <td>
                            {{ single_price($order->grand_total) }}
                        </td>
                        <td>
                            @php
                                $status = 'Delivered';
                                foreach ($order->orderDetails as $key => $orderDetail) {
                                    if($orderDetail->delivery_status != 'delivered'){
                                        $status = 'Pending';
                                    }
                                }
                            @endphp
                            {{ translate($status) }}
                        </td>
                        <td>
                            @if ($order->payment_status == 'paid')
                                <span class="badge badge-inline badge-success">{{translate('Paid')}}</span>
                            @else
                                <span class="badge badge-inline badge-danger">{{translate('Unpaid')}}</span>
                            @endif
                        </td>
                       
                        <td class="text-right">
                            <a class="btn btn-soft-primary btn-icon btn-circle btn-sm" href="{{route('all_orders.show', encrypt($order->id))}}" title="{{ translate('View') }}">
                                <i class="las la-eye"></i>
                            </a>
                            <a class="btn btn-soft-primary btn-icon btn-circle btn-sm" href="{{ route('customer.invoice.download', $order->id) }}" title="{{ translate('Download Invoice') }}">
                                <i class="las la-download"></i>
                            </a>
                            <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" data-href="{{route('orders.destroy', $order->id)}}" title="{{ translate('Delete') }}">
                                <i class="las la-trash"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="aiz-pagination">
            {{ $orders->appends(request()->input())->links() }}
        </div>
    </div>
</div>
                  </div>
                  <div class="tab-pane" id="profile" role="tabpanel">
                   <div class="card">
   
    
    <div class="card-body">
        <hr>
        <div class = "row">
            <div class="col-md-6">
                <h4>Total Quotation: {{count($quotations)}}</h4>
            </div>
            <div class="col-md-6">
                <h4>Quotation Amount: {{$quotations->sum('total')}}</h4>
            </div>
        </div>
        <hr>
        <table class="table aiz-table mb-0" id="myTable">
            <thead>
                <tr>
                    <th width="10%">#</th>
                    <th>{{translate('Quotaion Number')}}</th>
                    <th>{{translate('Quotation Title')}}</th>
                    <th>{{translate('Reseller')}}</th>
                    <th>{{translate('Quotation Date')}}</th>
                    {{-- <th>{{translate('User Type')}}</th> --}}
                    <th>{{translate('Total Amount')}}</th>
                    <th width="10%">{{translate('Options')}}</th>
                </tr>
            </thead>
            <tbody>
                            
                @foreach($quotations as $key => $quotation)
                    @if($quotation->user != null)
                        <tr>
                            <td>{{ ($key+1) + ($quotations->currentPage() - 1)*$quotations->perPage() }}</td>
                            <td>{{$quotation->quotation_number}}
                            <td>{{$quotation->quotation_name}}</td>
                            <td><a href="{{route('crm.quotationbyseller', encrypt($quotation->reseller->id)) }}" data-toggle="tooltip" data-placement="top" title="All {{$quotation->reseller->name}} Quotaion">{{$quotation->reseller->name}}</a></td>
                            <td>{{$quotation->date}}</td>
                            {{-- <td>{{$quotation->reseller->user_type}}</td> --}}
                            <td>{{$quotation->total}}</td>
                            <td class="text-right">
                                @if($quotation->order_status==0)
                                    <a class="btn btn-soft-success btn-icon btn-circle btn-sm" href="{{route('crm.quotationdownload', $quotation->quotation_number)}}" title="{{ translate('Download Quotation') }}">
                                        <i class="las la-download"></i>
                                    </a>
                                    <a class="btn btn-soft-success btn-icon btn-circle btn-sm" href="{{route('crm.quotationduplicate', ['id'=>$quotation->quotation_number]  )}}" title="{{ translate('Duplicate') }}">
                                        <i class="las la-copy"></i>
                                    </a>
                                    @if($quotation->duplicate_status == 1)
                                        <a class="btn btn-soft-success btn-icon btn-circle btn-sm" href="{{route('crm.viewduplicatequotation', encrypt($quotation->quotation_number))}}" title="{{ translate('View Quotation') }}">
                                            <i class="las la-eye"></i>
                                        </a> 
                                    @else
                                        <a class="btn btn-soft-success btn-icon btn-circle btn-sm" href="{{route('crm.viewquotation', encrypt($quotation->quotation_number))}}" title="{{ translate('View Quotation') }}">
                                            <i class="las la-eye"></i>
                                        </a>
                                    @endif
                                    
                                @else
                                    <a class="btn btn-soft-success btn-icon btn-circle btn-sm" href="{{route('crm.quotationdownload', $quotation->quotation_number)}}" title="{{ translate('Download Quotation') }}">
                                        <i class="las la-download"></i>
                                    </a>
                                    <a class="btn btn-soft-success btn-icon btn-circle btn-sm" href="{{route('crm.quotationduplicate', ['id'=>$quotation->quotation_number]  )}}" title="{{ translate('Duplicate') }}">
                                        <i class="las la-copy"></i>
                                    </a>
                                    <span class="badge badge-inline badge-success">{{translate('Ordered')}}</span>
                                    {{-- <i class="btn btn-soft-success btn-icon btn-circle btn-sm las la-check-circle" title="{{ translate('Ordered') }}"></i> --}}
                                   
                                @endif  
		                    </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
        <div class="aiz-pagination">
             {{ $quotations->appends(request()->input())->links() }}
        </div>
    </div>
</div>
                  </div>
                  
                   <div class="tab-pane" id="messages" role="tabpanel">
                    <div class="card-body">
        <hr>
        <div class = "row">
            <div class="col-md-12">
                <h4>Total Follow-Ups: {{count($follow_ups)}}</h4>
            </div>
        </div>
        <hr>
        <table class="table aiz-table mb-0" id="myTable">
            <thead>
                <tr>
                    <th width="10%">#</th>
                    <th>User Type</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Date Of Last Contact</th>
                    <th>Date Of Next Contact</th>
                    <th width="10%">{{translate('Options')}}</th>
                </tr>
            </thead>
            <tbody>
                            
                @foreach($follow_ups as $key => $follow)
                  
                        <tr>
                            <td>{{ ($key+1) + ($follow_ups->currentPage() - 1)*$follow_ups->perPage() }}</td>
                            <td>{{$follow->reseller->user_type}}</td>
                                    <td>{{$follow->reseller->name}}</td>
                                    <td>{{$follow->reseller->email}}</td>
                                    <td>{{$follow->reseller->phone}}</td>
                                    <td>{{$follow->last_date}}</td>
                                    <td>{{$follow->next_date}} {{$follow->next_time}}</td>
                                    <td>
                                        <a href="{{route('contact.edit',$follow->id)}}"
                                            class="btn btn-soft-success btn-icon btn-circle btn-sm"><i
                                                class="fa fa-pencil" aria-hidden="true"></i></a>
                                        <a href="#"
                                            class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete"
                                            data-href="{{route('crm.destroy', $follow->id)}}"
                                            title="{{ translate('Delete') }}">
                                            <i class="las la-trash"></i>
                                        </a>
                                    </td>
		                    </td>
                        </tr>
                  
                @endforeach
            </tbody>
        </table>
        <div class="aiz-pagination">
             {{ $follow_ups->appends(request()->input())->links() }}
        </div>
    </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection
@section('modal')
@include('modals.delete_modal')
@endsection
@section('script')
<script type="text/javascript">
   $(document).ready(function(){
       //$('#container').removeClass('mainnav-lg').addClass('mainnav-sm');
   });
   
   
   
   function sort_products(el){
       $('#sort_products').submit();
   }
   
</script>
@endsection