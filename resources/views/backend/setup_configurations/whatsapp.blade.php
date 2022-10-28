@extends('backend.layouts.app')

@section('content')

<div class="aiz-titlebar text-left mt-2 mb-3">
	<div class="align-items-center">
			<h1 class="h3">{{translate('All Whatsapp Number')}}</h1>
	</div>
</div>

<div class="row">
	<div class="col-md-7">
		<div class="card">
		    <div class="card-header row gutters-5">
				<div class="col text-center text-md-left">
					<h5 class="mb-md-0 h6">{{ translate('Whatsapp') }}</h5>
				</div>
				<div class="col-md-4">
					<form class="" id="sort_brands" action="" method="GET">
						<div class="input-group input-group-sm">
					  		<input type="text" class="form-control" id="search" name="search"@isset($sort_search) value="{{ $sort_search }}" @endisset placeholder="{{ translate('Type name & Enter') }}">
						</div>
					</form>
				</div>
		    </div>
		    <div class="card-body">
		        <table class="table aiz-table mb-0">
		            <thead>
		                <tr>
		                    <th>#</th>
		                    <th>{{translate('Name')}}</th>
		                    <th>{{translate('Number')}}</th>
		                    <th>Status</th>
		                    <th class="text-right">{{translate('Options')}}</th>
		                </tr>
		            </thead>
		            <tbody>
		                @foreach($whatsapps as $key => $whatsapp)
		                    <tr>
		                        <td>{{ ($key+1) + ($whatsapps->currentPage() - 1)*$whatsapps->perPage() }}</td>
		                        <td>{{ $whatsapp->name }}</td>
														<td>
		                           {{ $whatsapp->number }}
		                        </td>
		                        <td>	<label class="aiz-switch aiz-switch-success mb-0">
                              <input onchange="update_whatsapp(this)" value="{{ $whatsapp->id }}" type="checkbox" <?php if($whatsapp->status == 1) echo "checked";?> >
                              <span class="slider round"></span>
							</label></td>
		                        <td class="text-right">
		                            <a class="btn btn-soft-primary btn-icon btn-circle btn-sm" href="{{route('whatsapp.number_edit', $whatsapp->id )}}" title="{{ translate('Edit') }}">
		                                <i class="las la-edit"></i>
		                            </a>
		                            <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" data-href="{{route('whatsapp.number_destroy', $whatsapp->id)}}" title="{{ translate('Delete') }}">
		                                <i class="las la-trash"></i>
		                            </a>
		                        </td>
		                    </tr>
		                @endforeach
		            </tbody>
		        </table>
		        <div class="aiz-pagination">
                	{{ $whatsapps->appends(request()->input())->links() }}
            	</div>
		    </div>
		</div>
	</div>
	<div class="col-md-5">
		<div class="card">
			<div class="card-header">
				<h5 class="mb-0 h6">{{ translate('Add New Whatsapp') }}</h5>
			</div>
			<div class="card-body">
			    @if(!empty($edit_data))
				<form action="{{ route('whatsapp.number_update') }}" method="POST">
				    <input type="hidden" placeholder="{{translate('Id')}}" name="id" class="form-control" value="@if(isset($edit_data)){{$edit_data['id']}} @endif" required>
				  @endif
				  @if(empty($edit_data))
				  <form action="{{ route('whatsapp.number_store') }}" method="POST">
				      @endif
					@csrf
					<div class="form-group mb-3">
						<label for="name">{{translate('Name')}}</label>
						<input type="text" placeholder="{{translate('Name')}}" name="name" class="form-control" value="@if(isset($edit_data)){{$edit_data['name']}} @endif" required>
					</div>
					
					<div class="form-group mb-3">
						<label for="name">{{translate('Number')}}</label>
						<input type="text" class="form-control" name="number" placeholder="{{translate('number')}}" value="@if(isset($edit_data)){{$edit_data['number']}} @endif" required>
					</div>
					
					<div class="form-group mb-3 text-right">
						<button type="submit" class="btn btn-primary">{{translate('Save')}}</button>
					</div>
				</form>
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
    function sort_brands(el){
        $('#sort_brands').submit();
    }
    
    
     function update_whatsapp(el){
            if(el.checked){
                var status = 1;
            }
            else{
                var status = 0;
            }
            $.post('{{ route('whatsapp.update') }}', {_token:'{{ csrf_token() }}', id:el.value, status:status}, function(data){
                if(data == 1){
                    AIZ.plugins.notify('success', '{{ translate('Whatsapp updated successfully') }}');
                }
                else{
                    AIZ.plugins.notify('danger', '{{ translate('Something went wrong') }}');
                }
            });
        }
</script>
@endsection
