@extends('backend.layouts.app')

@section('content')

<div class="aiz-titlebar text-left mt-2 mb-3">
	<div class="row align-items-center">
		<div class="col-md-6">
			<h1 class="h3">{{translate('All Quotations')}}</h1>
		</div>
		
	</div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0 h6">{{translate('Quotations')}}</h5>
    </div>
    <div class="card-body">
        <table class="table aiz-table mb-0">
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
                            
                @foreach($quotationbyuser as $key => $quotation)
                    @if($quotation->user != null)
                        <tr>
                            <td>{{ ($key+1) + ($quotationbyuser->currentPage() - 1)*$quotationbyuser->perPage() }}</td>
                            <td>{{$quotation->quotation_number}}
                            <td>{{$quotation->quotation_name}}</td>
                            <td>{{$quotation->reseller->name}}</td>
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
            {{ $quotationbyuser->appends(request()->input())->links() }}
        </div>
    </div>
</div>

@endsection