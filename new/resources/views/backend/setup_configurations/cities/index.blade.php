@extends('backend.layouts.app')

@section('content')

<div class="aiz-titlebar text-left mt-2 mb-3">
	<div class="row align-items-center">
		<div class="col-md-6">
			<h1 class="h3">{{translate('All Cities')}}</h1>
		</div>
		<div class="col-md-6 text-md-right">
			<a href="{{ route('city.create') }}" class="btn btn-circle btn-info">
				<span>{{translate('Add New City')}}</span>
			</a>
		</div>
	</div>
</div>

<div class="card-body">

 <table class="table aiz-table mb-0">
            <thead>
            <tr>
                <th>#</th>
                <th>City Name</th>
                <th>State Name</th>
                <th>Country Name</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @php $i=1; @endphp 
       @foreach($cities as $city)
       <tr>
         <td>
           {{$i}}
         </td>
          <td>
           {{$city->city_name}}
         </td>
         <td>
           {{$city->state_name}}
         </td>
          <td>
           {{$city->countries_name}}
         </td>
         <td>
          <a class="btn btn-soft-primary btn-icon btn-circle btn-sm" href="{{route('city.edit',$city->id)}}" title="{{ translate('Edit') }}">
                   <i class="las la-edit"></i>
                 </a>

    <form action="{{ route('city.destroy', $city->id) }}" method="POST">
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
          {{ $cities->appends(request()->input())->links() }}
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

