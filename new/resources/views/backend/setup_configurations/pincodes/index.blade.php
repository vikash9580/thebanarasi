@extends('backend.layouts.app')

@section('content')

<div class="aiz-titlebar text-left mt-2 mb-3">
	<div class="row align-items-center">
		<div class="col-md-6">
			<h1 class="h3">{{translate('All Pincodes')}}</h1>
		</div>
		<div class="col-md-6 text-md-right">
			<a href="{{ route('pincode.create') }}" class="btn btn-circle btn-info">
				<span>{{translate('Add New Pincode')}}</span>
			</a>
		</div>
	</div>
</div>

<div class="card-body">

 <table class="table aiz-table mb-0">
            <thead>
            <tr>
                <th>#</th>
                <th>Pincode</th>
                <th>City Name</th>
                <th>State Name</th>
                <th>Country Name</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @php $i=1; @endphp 
       @foreach($pincodes as $pincode)
       <tr>
         <td>
           {{$i}}
         </td>
         <td>
           {{$pincode->pincode}}
         </td>
         <td>
           {{$pincode->city_name}}
         </td>
         <td>
           {{$pincode->state_name}}
         </td>
          <td>
           {{$pincode->countries_name}}
         </td>
         <td>
          <a class="btn btn-soft-primary btn-icon btn-circle btn-sm" href="{{route('pincode.edit',$pincode->id)}}" title="{{ translate('Edit') }}">
                   <i class="las la-edit"></i>
                 </a>

    <form action="{{ route('pincode.destroy', $pincode->id) }}" method="POST">
    @method('DELETE')
    @csrf
    <button class="btn btn-soft-danger btn-icon btn-circle btn-sm " onclick="return areyousure();"> <i class="las la-trash" aria-hidden="true"></i></button>
</form>
         </td>
       </tr>
      @php $i++; @endphp
@endforeach

            </tbody>
        </table>


<div class="aiz-pagination">
          {{ $pincodes->appends(request()->input())->links() }}
        </div>

      </div>


@endsection
<script>
  function areyousure(){
      if(confirm("Are you sure, you want to delete?")){
        return true;
      }else{
        return false;
      }
    }
</script>

