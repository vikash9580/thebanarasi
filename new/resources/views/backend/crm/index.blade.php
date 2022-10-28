@extends('backend.layouts.app')

@section('content')

<div class="aiz-titlebar text-left mt-2 mb-3">
	<div class="row align-items-center">
		<div class="col-md-6">
			<h1 class="h3">{{translate('All Sellers')}}</h1>
		</div>
		<div class="col-md-6 text-md-right">
			<a href="{{ route('crm.create') }}" class="btn btn-circle btn-info">
				<span>{{translate('Add New Seller')}}</span>
			</a>
		</div>
	</div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0 h6">{{translate('Sellers')}}</h5>
        <div class="col-md-4">
					<form class="" id="sort_brands" action="" method="GET">
						<div class="input-group input-group-sm">
					  		<input type="text" class="form-control" id="search" name="search"@isset($sort_search) value="{{ $sort_search }}" @endisset placeholder="{{ translate('Type name & Enter') }}">
						</div>
					</form>
				</div>
    </div>
    
    
    
    <div class="card-body">
        <table class="table aiz-table mb-0" id="myTable">
            <thead>
                <tr>
                    <th width="10%">#</th>
                    <th>{{translate('Name')}}</th>
                    <th>{{translate('Email')}}</th>
                    <th>{{translate('Phone')}}</th>
                    <th>{{translate('Gender')}}</th>
                    <th>{{translate('User Type')}}</th>
                    <th width="10%">{{translate('Options')}}</th>
                </tr>
            </thead>
            <tbody>              
                @foreach($SellerDetails as $key => $seller)
                    @if($seller->user != null)
                        <tr>
                            <td>{{ ($key+1) + ($SellerDetails->currentPage() - 1)*$SellerDetails->perPage() }}</td>
                            <td><a href="{{route('crm.user_info', $seller->id)}}" data-toggle="tooltip" data-placement="top" title="{{$seller->user->name}} Information">{{$seller->user->name}}</a></td>
                            <td>{{$seller->user->email}}</td>
                            <td>{{$seller->user->phone}}</td>
                            <td>{{$seller->gender}}</td>
                            <td>{{$seller->user->user_type}}</td>
                            <td class="text-right">
                                
                                <a class="btn btn-soft-success btn-icon btn-circle btn-sm" href="{{route('crm.quotation', encrypt($seller->user->id))}}" title="{{ translate('Generate Quotation') }}">
                                    <i class="las la-plus"></i>
                                </a>
                                @if($seller->whatsapp_number!="")
                                    <a class="btn btn-soft-success btn-icon btn-circle btn-sm" href="https://api.whatsapp.com/send?phone=+91{{$seller->whatsapp_number}}" title="{{ translate('Whatsapp Now') }}" target="_blank">
                                        <i class="lab la-whatsapp"></i>
                                    </a>
                                @endif
                                <a class="btn btn-soft-primary btn-icon btn-circle btn-sm" href="{{route('crm.edit', encrypt($seller->id))}}" title="{{ translate('Edit') }}">
                                    <i class="las la-edit"></i>
                                </a>
                                <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" data-href="{{route('crm.destroy', $seller->id)}}" title="{{ translate('Delete') }}">
                                    <i class="las la-trash"></i>
                                </a>
		                    </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
        <div class="aiz-pagination">
            {{ $SellerDetails->appends(request()->input())->links() }}
        </div>
    </div>
</div>

@endsection

@section('modal')
    @include('modals.delete_modal')
@endsection

@section('script')


{{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>  
<script type="text/javascript">
    function sort_brands(el){
        $('#sort_brands').submit();
    }
</script>
    <script>
        $(document).ready( function () {
            $('#myTable').DataTable();
        } );
    </script>   --}}
@endsection