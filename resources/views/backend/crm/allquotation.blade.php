@extends('backend.layouts.app')

@section('content')

<div class="aiz-titlebar text-left mt-2 mb-3">
	<div class="row align-items-center">
		<div class="col-md-6">
			<h1 class="h3">{{translate('All Quotations')}}</h1>
		</div>
		{{-- <div class="col-md-6 text-md-right">
			<a href="{{ route('crm.create') }}" class="btn btn-circle btn-info">
				<span>{{translate('Add New Seller')}}</span>
			</a>
		</div> --}}
        <div class="col-md-6 text-md-right">
            <a href="{{ route('crm.quotationwithuserview') }}" class="btn btn-circle btn-info">
				<span>{{translate('New Quotations')}}</span>
			</a>
            {{-- <button type="button" class="btn btn-circle btn-info" data-toggle="modal" data-target="#new_quotation">
                New Quotations
            </button> --}}
        </div>

	</div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0 h6">{{translate('Quotations')}}</h5>
       
       
        <div class="col-md-7">
            <form class="" action="" method="GET">
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group input-group-sm">
                            <input type="text" class="form-control" id="search" name="search" @isset($sort_search) value="{{ $sort_search }}" @endisset placeholder="{{ translate('Quotaion Number / Name & hit Enter') }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group input-group-sm">
                            <input type="date" class="form-control" id="search" name="date" @isset($date) value="{{ $date }}" @endisset>
                             <button type="submit" class="btn btn-primary">{{translate('Filter')}}</button>
                        </div>
                    </div>
                    
                </div>
            </form>
        </div>
    </div>
    
    <div class="card-body">
        <table class="table aiz-table mb-0" id="myTable">
            <thead>
                <tr>
                    <th width="10%">#</th>
                    <th>{{translate('Quotaion Number')}}</th>
                    <th>{{translate('Quotation Title')}}</th>
                    <th>{{translate('Reseller')}}</th>
                    <th>{{translate('Reseller Phone')}}</th>
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
                            <td><a href="{{route('crm.quotationbyseller', encrypt($quotation->reseller->id)) }}" data-toggle="tooltip" data-placement="top" title="{{$quotation->reseller->name}} All Quotation">{{$quotation->reseller->name}}</a></td>
                            <td>{{$quotation->reseller->phone}}</td>
                            <td>{{$quotation->date}}</td>
                            {{-- <td>{{$quotation->reseller->user_type}}</td> --}}
                            <td>{{$quotation->total}}</td>
                            <td class="text-right">
                                @if($quotation->order_status==0)
                                   
                                    <button class="btn btn-soft-success btn-icon btn-circle btn-sm" id="share_link" value="{{route('crm.quotationdownload', $quotation->quotation_number)}}" href="#" onclick="copyToClipboard()" title="{{ translate('Share Link') }}"> 
                                        <i class="las la-share-alt"></i> 
                                    </button>
                                    
                                    <a class="btn btn-soft-success btn-icon btn-circle btn-sm" href="{{route('crm.quotationdownload', $quotation->quotation_number)}}" target ="_blank" title="{{ translate('Download Quotation') }}">
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
                                    <button class="btn btn-soft-success btn-icon btn-circle btn-sm" id="share_link" value="{{route('crm.quotationdownload', $quotation->quotation_number)}}" href="#" onclick="copyToClipboard()" title="{{ translate('Share Link') }}"> 
                                        <i class="las la-share-alt"></i> 
                                    </button>
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

@endsection
@section ('script')
<script>
    function copyToClipboard(text) {
        var inputc = document.body.appendChild(document.createElement("input"));
        inputc.value = document.getElementById("share_link").value;
        inputc.focus();
        inputc.select();
        document.execCommand('copy');
        inputc.parentNode.removeChild(inputc);
        alert("URL Copied.");
    }
</script>
@endsection
@section('modal')
    @include('backend.crm.newquotaion_modal')
    @include('modals.delete_modal')
@endsection



