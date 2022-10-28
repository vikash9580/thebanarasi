@extends('backend.layouts.app')

@section('content')
<div class="card mt-5">
    <div class="card-header">
        <h5 class="mb-0 h6">{{ translate('All Enquiry') }}</h5>
        <div class="pull-right clearfix">
            <form class="" id="sort_categories" action="" method="GET">
                <div class="box-inline pad-rgt pull-left">
                    <div class="" style="min-width: 200px;">
                        <input type="text" class="form-control" id="search" name="search"@isset($sort_search) value="{{ $sort_search }}" @endisset placeholder="{{ translate('Type name & Enter') }}">
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="card-body">
        <table class="table aiz-table mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{translate('Product Name')}}</th>
                    <th>{{translate('Name')}}</th>
                    <th>{{translate('Phone')}}</th>
                    <th>{{translate('Quantity')}}</th>
                    <th>{{translate('Remark')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pro_enq as $key=> $item)
                    <tr>
                        <td>{{ ($key+1) + ($pro_enq->currentPage() - 1)*$pro_enq->perPage() }}</td>
                        <td>
        				@php 
                        $pro_title=App\Models\Product::where('id',$item->product_id)->first();
						@endphp
						{{ $pro_title->name}}</td>
                        <td>{{ $item->name}}</td>
                        <td>{{ $item->phone }}</td>
                        <td>{{ $item->qntity }}</td>
                        <td>{{ $item->remark }}</td>
                       
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="aiz-pagination">
            {{ $pro_enq->appends(request()->input())->links() }}
        </div>
    </div>
</div>
@endsection

