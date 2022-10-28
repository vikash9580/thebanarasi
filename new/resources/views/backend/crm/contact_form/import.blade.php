@extends('backend.layouts.app')
@section('content')
    <div class="col-lg-6 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">{{translate('Upload Excel')}}</h5>
            </div>

            <form class="form-horizontal" action="{{ route('contact.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="card-body">
                    
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="name">{{translate('Select Excel')}}</label>
                        <div class="col-sm-9">
                            <input type="file" name="file" class="form-control" required>
                        </div>
                    </div>
                    
                    <div class="form-group mb-0 text-right">
                        <button type="submit" class="btn btn-sm btn-primary">{{translate('Save')}}</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
@endsection