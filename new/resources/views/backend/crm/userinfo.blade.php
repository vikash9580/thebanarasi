@extends('backend.layouts.app')

@section('content')
<style>
    .card-body h6 {
        margin: 0px 0 20px;
        text-transform: uppercase;
        font-size: 18px;
        padding: 10px 0;
        color: #ffc418;
        border-bottom: 1px dotted #ffc418;
    }
    .col-from-label {
        font-size: 15px;
    }
</style>
<div class="col-lg-12 mx-auto">
    <div class="card">
        
        <div class="card-body">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <h6>{{ translate('Seller Information')}}</h6>
                        </div>
        
                        <div class="col-sm-3">
                            <label class="col-from-label" for="name">{{translate('Name')}} - {{ $SellerDetails->user->name }}</label>
                        </div>
                        
                        <div class="col-sm-3">
                            <label class="col-from-label" for="name">{{translate('Seller Type')}} - {{$SellerDetails->user->user_type}}</label>
                        </div>
                    
                        <div class="col-sm-6">
                            <label class="col-from-label" for="email">{{translate('Email')}} - {{$SellerDetails->user->email}}</label>
                        </div>
                    
                        <div class="col-sm-3">
                            <label class="col-from-label" for="mobile1">{{translate('Phone 1')}} - {{$SellerDetails->phone1}}</label>
                        </div>
                        
                        <div class="col-sm-3">
                            <label class="col-from-label" for="mobile2">{{translate('Phone 2')}} - {{$SellerDetails->phone2}}</label>
                        </div>
                        
                        <div class="col-sm-3">
                            <label class="col-from-label" for="whatsapp_number">{{translate('Whatsapp Number')}} - {{$SellerDetails->whatsapp_number}}</label>
                        </div>
                        
                        <div class="col-sm-3">
                            <label class="col-from-label" for="city">{{translate('Gender')}} - {{$SellerDetails->gender}}</label>
                        </div>
                    
                        <div class="col-sm-3">
                            <label class="col-from-label" for="dob">{{translate('DOB')}} - {{$SellerDetails->dob}}</label>
                        </div>
                        
                        <div class="col-sm-3">
                            <label class="col-from-label" for="profession">{{translate('Profession')}} - {{$SellerDetails->profession}}</label>
                        </div>
                    
                        <div class="col-sm-3">
                            <label class="col-from-label" for="contact_position">{{translate('Contact Position')}} - {{$SellerDetails->contact_position}}</label>
                        </div>
                    
                        <div class="col-sm-3">
                            <label class="col-from-label" for="website">{{translate('Website')}} - {{$SellerDetails->website}}</label>
                        </div>
                        <div class="col-sm-12">
                            <h6>{{translate('Address')}}</h6>
                        </div>
                        <div class="col-sm-3">
                            <label class="col-from-label" for="street">{{translate('Street Address')}} - {{$SellerDetails->street_address}}</label>
                        </div>
                    
                        <div class="col-sm-3">
                            <label class="col-from-label" for="city">{{translate('City')}} - {{$SellerDetails->city}}</label>
                        </div>
                        <div class="col-sm-3">
                            <label class="col-from-label" for="state">{{translate('State')}} - {{$SellerDetails->state}}</label>
                        </div>
                        <div class="col-sm-3">
                            <label class="col-from-label" for="country">{{translate('Country')}} - {{$SellerDetails->country}}</label>
                        </div>
                        <div class="col-sm-3">
                            <label class="col-from-label" for="pincode">{{translate('Zip Code / Pincode')}} - {{$SellerDetails->pincode}}</label>
                        </div>
                        <div class="col-sm-3">
                            <label class="col-from-label" for="delivery_address">{{translate('Delivery Address')}} - {{$SellerDetails->delivery_address}}</label>
                        </div>
                        <div class="col-sm-12">
                            <h6>{{translate('Social Media Links')}}</h6>
                        </div>
                        <div class="col-sm-3">
                            <label class="col-from-label" for="facebook">{{translate('Facebook')}} - {{$SellerDetails->facebook}}</label>
                        </div>
                        <div class="col-sm-3">
                            <label class="col-from-label" for="instagram">{{translate('Instagram')}} - {{$SellerDetails->instagram}}</label>
                        </div>
                        <div class="col-sm-3">
                            <label class="col-from-label" for="twitter">{{translate('Twitter')}} - {{$SellerDetails->twitter}}</label>
                        </div>
                        <div class="col-sm-12">
                            <h6>{{translate('Other Information')}}</h6>
                        </div>
                        <div class="col-sm-3">
                            <label class="col-from-label" for="anniversary">{{translate('Anniversary')}} - {{$SellerDetails->anniversary}}</label>
                        </div>
                        <div class="col-sm-3">
                            <label class="col-from-label" for="business_name">{{translate('Business Name')}} - {{$SellerDetails->business_name}}</label>
                        </div>
                        <div class="col-sm-3">
                            <label class="col-from-label" for="name">{{translate('Tax ID Type')}} - {{$SellerDetails->tax_id_type}}</label>
                        </div>
                        <div class="col-sm-3">
                            <label class="col-from-label" for="tax_id">{{translate('Tax ID')}} - {{$SellerDetails->tax_id}}</label>
                        </div>
                    
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>

@endsection

