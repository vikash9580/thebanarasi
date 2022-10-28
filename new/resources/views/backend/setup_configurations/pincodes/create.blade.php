@extends('backend.layouts.app')

@section('content')

<div class="aiz-titlebar text-left mt-2 mb-3">
    <h5 class="mb-0 h6">{{translate('Add New Pincode')}}</h5>
</div>

<div class="col-lg-6 mx-auto">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6">{{translate('Pincode Information')}}</h5>
        </div>
        <div class="card-body">
            @if(isset($edit_data->pincode))
            <form action="{{ route('pincode.update',$edit_data->id) }}" method="POST"  enctype="multipart/form-data">
                 @method('PUT')
                @endif
            @if(empty($edit_data->pincode))
            <form action="{{ route('pincode.store') }}" method="POST"  enctype="multipart/form-data">
                @endif
            	@csrf
                <div class="form-group row">
                    <label class="col-sm-3 col-from-label" for="country_id">Country Name</label>
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
                    <label class="col-sm-3 col-from-label" for="city_id">City Name</label>
                    <div class="col-sm-9">
                        <select class="form-control aiz-selectpicker" name="city_id" id="city_id"  data-live-search="true" required>

                        @foreach($city as $cities)
                        <option value='{{$cities->id}}' @if(isset($edit_data->countries_name) && ($edit_data->city_id==$cities->id)){{'selected'}}@endif>{{$cities->city_name}}</option>
                        @endforeach
                        </select>
                    </div>
                </div>


                 <div class="form-group row">
                    <label class="col-sm-3 col-from-label" for="country_id">Pincode</label>
                    <div class="col-sm-9">
                        <input type="number" placeholder="Enter Pincode" id="pincode" name="pincode" class="form-control" value="@if(isset($edit_data->pincode)){{$edit_data->pincode }}@endif"required>
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
  $('#state_id').change(function() {
      
     var state_id= $('#state_id').val(); 

      $.post('{{ route('city.city_list') }}', {_token:'{{ csrf_token() }}', id:state_id}, function(data){
           
           $('#city_id').empty();
            $('#city_id').append('<option value="">Select State</option>');
             $.each(data.list,function(item,i){
                $('#city_id').append('<option value="'+i.id+'">'+i.city_name+'</option>');
             });
                
            });
      
      
  })
});
</script>
@endsection