@extends('backend.layouts.app')

@section('content')

<div class="aiz-titlebar text-left mt-2 mb-3">
    <h5 class="mb-0 h6">{{translate('Add New State')}}</h5>
</div>

<div class="col-lg-6 mx-auto">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6">{{translate('State Information')}}</h5>
        </div>
        <div class="card-body">
            @if(isset($edit_data->state_name))
            <form action="{{ route('state.update',$edit_data->id) }}" method="POST"  enctype="multipart/form-data">
                 @method('PUT')
                @endif
            @if(empty($edit_data->state_name))
            <form action="{{ route('state.store') }}" method="POST"  enctype="multipart/form-data">
                @endif
            	@csrf
                <div class="form-group row">
                    <label class="col-sm-3 col-from-label" for="country_id">Country Name</label>
                    <div class="col-sm-9">
                        <select class="form-control aiz-selectpicker" name="countries_name" id="countries_name"  data-live-search="true" required>

                        @foreach($country as $countries)s
                        <option value='{{$countries->name}}' @if(isset($edit_data->countries_name) && ($edit_data->countries_name==$countries->name)){{'selected'}}@endif>{{$countries->name}}</option>
                        @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 col-from-label" for="state_name">State Name</label>
                    <div class="col-sm-9">
                        <input type="text" placeholder="{{translate('Name')}}" id="state_name" name="state_name" class="form-control" value="@if(isset($edit_data->state_name)){{$edit_data->state_name}}@endif"required>
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
