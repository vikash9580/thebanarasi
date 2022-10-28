@extends('backend.layouts.app')

@section('content')

<div class="aiz-titlebar text-left mt-2 mb-3">
    <h5 class="mb-0 h6">{{translate('Add New City')}}</h5>
</div>

<div class="col-lg-6 mx-auto">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6">{{translate('City Information')}}</h5>
        </div>
        <div class="card-body">
            @if(isset($edit_data->city_name))
            <form action="{{ route('city.update',$edit_data->id) }}" method="POST"  enctype="multipart/form-data">
                 @method('PUT')
                @endif
            @if(empty($edit_data->city_name))
            <form action="{{ route('city.store') }}" method="POST"  enctype="multipart/form-data">
                @endif
            	@csrf
                <div class="form-group row">
                    <label class="col-sm-3 col-from-label" for="countries_name">Country Name</label>
                    <div class="col-sm-9">
                        <select class="form-control aiz-selectpicker" name="countries_name" id="countries_name"  data-live-search="true" required>

                        @foreach($country as $countries)
                        <option value='{{$countries->name}}' @if(isset($edit_data->countries_name) && ($edit_data->countries_name==$countries->name)){{'selected'}}@endif>{{$countries->name}}</option>
                        @endforeach
                        </select>
                    </div>
                </div>

                 <div class="form-group row">
                    <label class="col-sm-3 col-from-label" for="state_id">State Name</label>
                    <div class="col-sm-9">
                        <select class="form-control aiz-selectpicker" name="state_id" id="state_id"  data-live-search="true" required>

                        @foreach($state as $states)
                        <option value='{{$states->id}}' @if(isset($edit_data->countries_name) && ($edit_data->state_id==$states->id)){{'selected'}}@endif>{{$states->state_name}}</option>
                        @endforeach
                        </select>
                    </div>
                </div>

                 <div class="form-group row">
                    <label class="col-sm-3 col-from-label" for="country_id">City Name</label>
                    <div class="col-sm-9">
                        <input type="text" placeholder="{{translate('Name')}}" id="city_name" name="city_name" class="form-control" value="@if(isset($edit_data->city_name)){{$edit_data->city_name }}@endif"required>
                    </div>
                </div>

               

                 
                <div class="form-group mb-0 text-right">
                    <button type="submit" class="btn btn-primary">{{translate('Save')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('script')
<script type="text/javascript">

$(document).ready(function(){
  $('#countries_name').change(function() {
      
     var country_name= $('#countries_name').val(); 

      $.post('{{ route('state.state_list') }}', {_token:'{{ csrf_token() }}', id:country_name}, function(data){
           
           $('#state_id').empty();
            $('#state_id').append('<option value="">Select State</option>');
             $.each(data.list,function(item,i){
                $('#state_id').append('<option value="'+i.id+'">'+i.state_name+'</option>');
             });
                
            });
      
      
  })
});
</script>
@endsection