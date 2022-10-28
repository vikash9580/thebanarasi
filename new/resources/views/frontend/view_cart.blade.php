@extends('frontend.layouts.app')
@section('content')
    <style>
        input[type=checkbox],
        input[type=radio] {
            box-sizing: border-box;
            padding: 0;
            cursor: pointer;
        }

        .ajax-loader {
            visibility: hidden;
            background-color: rgba(255, 255, 255, 0.7);
            position: fixed;
            z-index: +100 !important;
            width: 100%;
            height: 100%;
        }

        .code {
                float: right;
                margin-right: 5px;
                background: #ebc400;
                font-size: 14px;
                box-shadow: 1px 1px 8px 1px #4031101c;
                height: 30px;
                color: #fff;
                border-radius: 30px;
                margin-top: -5px;
                width: 30px;
                border: none;
                padding: 2px 8px;
        }
        
        .code:hover
        {
             background: #000;
              color: #fff;
        }

        .ajax-loader img {
            position: relative;
            top: 50%;
            left: 50%;
        }

        .img-responsive {
            width: auto;
            height: auto;
        }

        .paddingLuar {
            padding: 1rem 0 2rem;
        }

        .accordion {
            letter-spacing: 1px;
            font-size: 15px;
            padding: 12px 15px;
            background: #f7f8f8;
            color: #000000;
            text-decoration: none;
            font-weight: 600;
        }
    </style>

    <section class="page-title o-hidden breadcrumb">
        <div class="container">
            <div class="row align-items-center">

                <div class="col-lg-8 col-md-12 text-lg-right md-mt-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb" style="margin-bottom: 0;">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="la la-home"></i></a>
                            </li>
                            <li class="breadcrumb-item opacity-50">
                                <a class="text-reset" href="#">{{ translate('My Checkout') }}</a>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <div class="ajax-loader">
        <img src="{{ static_asset('assets/img/ajax-loader.gif') }}" class="img-responsive" />
    </div>

    <div class="paddingLuar">
        <div class="container-fluid">
            <div class="row reverse">
                <div class="col-md-9">
                    <h4 class="accordion hide">Cart Info</h4>
                    <form action="{{ route('payment.checkout') }}" class="form-default" role="form" method="POST"
                        enctype="multipart/form-data" id="checkout-form">
                        <div class="hide" id="cart-summary">
                            @include('frontend.partials.cart_details')
                        </div>
                        <div class="address mt-3">
                            @if (Auth::check())
                                <div class="bg-white">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h4 class="accordion">Delivery Address</h4>
                                        </div>
                                        @foreach (Auth::user()->addresses as $key => $address)
                                            <div class="col-md-6 mb-3">
                                                <label class="aiz-megabox d-block bg-white mb-0">
                                                    @php $address_id=session()->get('shipping_info');    @endphp
                                                    <input type="radio" class="address_id" name="address_id"
                                                        id="address_id_{{ $address->id }}" value="{{ $address->id }}"
                                                        @if ($key == 0) {{ 'checked' }} @endif
                                                        required>
                                                    <span class="d-flex p-3 aiz-megabox-elem">
                                                        <span class="aiz-rounded-check flex-shrink-0 mt-1"></span>
                                                        <span class="flex-grow-1 pl-3 text-left">
                                                            <div>
                                                                <span>{{ translate('Name') }}:</span>
                                                                <span class="fw-600 ml-2">{{ $address->name }} </span>
                                                                <input type="hidden" name="name" value="{{$address->name}}"/>
                                                            </div>
                                                            <div>
                                                                <span>{{ translate('Address') }}:</span>
                                                                <span class="fw-600 ml-2">{{ $address->address }}</span>
                                                                  <input type="hidden" name="address" value="{{$address->address}}"/>
                                                            </div>
                                                            <div>
                                                                <span>{{ translate('Postal Code') }}:</span>
                                                                <span
                                                                    class="fw-600 ml-2">{{ $address->postal_code }}</span>
                                                                      <input type="hidden" name="pincode" value="{{$address->postal_code}}"/>
                                                            </div>
                                                            <div>
                                                                <span>{{ translate('City') }}:</span>
                                                                <span class="fw-600 ml-2">{{ $address->city }}</span>
                                                                  <input type="hidden" name="city" value="{{$address->city}}"/>
                                                            </div>
                                                            <div>
                                                                <span>{{ translate('State') }}:</span>
                                                                <span class="fw-600 ml-2">{{ $address->state }}</span>
                                                                  <input type="hidden" name="state" value="{{$address->state}}"/>
                                                            </div>
                                                            <div>
                                                                <span class="opacity-60">{{ translate('Country') }}:</span>
                                                                <span class="fw-600 ml-2">{{ $address->country }}</span>
                                                                  <input type="hidden" name="country" value="{{$address->country}}"/>
                                                            </div>
                                                            <div>
                                                                <span>{{ translate('Land Mark') }}:</span>
                                                                <span class="fw-600 ml-2">{{ $address->land_mark }}</span>
                                                                  <input type="hidden" name="land_mark" value="{{$address->land_mark}}"/>
                                                            </div>
                                                            <div>
                                                                <span>{{ translate('Phone') }}:</span>
                                                                <span class="fw-600 ml-2">{{ $address->phone }}</span>
                                                                  <input type="hidden" name="phone" value="{{$address->phone}}"/>
                                                            </div>
                                                            <div>
                                                                <span>{{ translate('Email') }}:</span>
                                                                <span class="fw-600 ml-2">{{ $address->email }}</span>
                                                                  <input type="hidden" name="email" value="{{$address->email}}"/>
                                                            </div>
                                                            <div class="dropdown position-absolute right-0 top-0">
                                                                <button class="btn bg-black text-white px-2" type="button"
                                                                    data-toggle="dropdown">
                                                                    <i class="la la-ellipsis-v"></i>
                                                                </button>
                                                                <div class="dropdown-menu dropdown-menu-right"
                                                                    aria-labelledby="dropdownMenuButton">
                                                                    <a class="dropdown-item"
                                                                        onclick="update_address({{ json_encode($address) }})">{{ translate('Edit') }}</a>
                                                                </div>
                                                            </div>
                                                        </span>
                                                    </span>
                                                </label>

                                            </div>
                                        @endforeach
                                        <input type="hidden" name="checkout_type" value="logged">
                                        <div class="col-md-6 mx-auto mb-3">
                                            <div class="border p-3 rounded mb-3 c-pointer text-center bg-white h-100 d-flex flex-column justify-content-center"
                                                onclick="add_new_address()">
                                                <i class="las la-plus la-2x mb-3"></i>
                                                <div class="alpha-7">{{ translate('Add New Address') }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="shadow-sm bg-white rounded mb-4">
                                    <div class="form-group">
                                        <label class="control-label">{{ translate('Name') }}</label>
                                        <input type="text" class="form-control" name="name"
                                            placeholder="{{ translate('Name') }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">{{ translate('Email') }}</label>
                                        <input type="text" class="form-control" name="email"
                                            placeholder="{{ translate('Email') }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">{{ translate('Address') }}</label>
                                        <input type="text" class="form-control" name="address"
                                            placeholder="{{ translate('Address') }}" required>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">{{ translate('Select your country') }}</label>
                                                <select class="form-control aiz-selectpicker" data-live-search="true"
                                                    name="country">
                                                    @foreach (\App\Country::where('status', 1)->get() as $key => $country)
                                                        <option value="{{ $country->name }}">{{ $country->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group has-feedback">
                                                <label class="control-label">{{ translate('State') }}</label>
                                                <input type="text" class="form-control"
                                                    placeholder="{{ translate('State') }}" name="state" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group has-feedback">
                                                <label class="control-label">{{ translate('City') }}</label>
                                                <input type="text" class="form-control"
                                                    placeholder="{{ translate('City') }}" name="city" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group has-feedback">
                                                <label class="control-label">{{ translate('Postal code') }}</label>
                                                <input type="text" class="form-control"
                                                    placeholder="{{ translate('Postal code') }}" name="postal_code"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group has-feedback">
                                                <label class="control-label">{{ translate('Phone') }}</label>
                                                <input type="number" min="0" class="form-control"
                                                    placeholder="{{ translate('Phone') }}" name="phone" required>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="checkout_type" value="guest">
                                </div>
                            @endif
                        </div>

                        <h4 class="desk-hide hide mb-3"><span class="total_prices fs-20 fw-600 text-primary">Price :
                                {{ single_price($total) }}</span></h4>

                        <div class="payment">
                            <div class="bg-white mt-3 rounded">
                                <div class="row">
                                   

                                    @csrf
                                                         <div class="col-md-12">
                                                        <h4 class="accordion">Payment Select Option</h4>
                                                    </div>
                                                        @if (\App\BusinessSetting::where('type', 'paypal_payment')->first()->value == 1)
                                                            <div class="col-6 col-md-4">
                                                                <label class="aiz-megabox d-block mb-3">
                                                                    <input value="paypal" class="online_payment"
                                                                        type="radio" name="payment_option" checked>
                                                                    <span class="d-block p-2 aiz-megabox-elem">
                                                                        <img src="{{ static_asset('assets/img/cards/paypal.png') }}"
                                                                            class="img-fluid mb-2">
                                                                        <span class="d-block text-center">
                                                                            <span
                                                                                class="d-block fw-600 fs-15">{{ translate('Paypal') }}</span>
                                                                        </span>
                                                                    </span>
                                                                </label>
                                                            </div>
                                                        @endif
                                                        @if (\App\BusinessSetting::where('type', 'stripe_payment')->first()->value == 1)
                                                            <div class="col-6 col-md-4">
                                                                <label class="aiz-megabox d-block mb-3">
                                                                    <input value="stripe" class="online_payment"
                                                                        type="radio" name="payment_option" checked>
                                                                    <span class="d-block p-2 aiz-megabox-elem">
                                                                        <img src="{{ static_asset('assets/img/cards/stripe.png') }}"
                                                                            class="img-fluid mb-2">
                                                                        <span class="d-block text-center">
                                                                            <span
                                                                                class="d-block fw-600 fs-15">{{ translate('Stripe') }}</span>
                                                                        </span>
                                                                    </span>
                                                                </label>
                                                            </div>
                                                        @endif
                                                        @if (\App\BusinessSetting::where('type', 'sslcommerz_payment')->first()->value == 1)
                                                            <div class="col-6 col-md-4">
                                                                <label class="aiz-megabox d-block mb-3">
                                                                    <input value="sslcommerz" class="online_payment"
                                                                        type="radio" name="payment_option" checked>
                                                                    <span class="d-block p-2 aiz-megabox-elem">
                                                                        <img src="{{ static_asset('assets/img/cards/sslcommerz.png') }}"
                                                                            class="img-fluid mb-2">
                                                                        <span class="d-block text-center">
                                                                            <span
                                                                                class="d-block fw-600 fs-15">{{ translate('sslcommerz') }}</span>
                                                                        </span>
                                                                    </span>
                                                                </label>
                                                            </div>
                                                        @endif
                                                        @if (\App\BusinessSetting::where('type', 'instamojo_payment')->first()->value == 1)
                                                            <div class="col-6 col-md-4">
                                                                <label class="aiz-megabox d-block mb-3">
                                                                    <input value="instamojo" class="online_payment"
                                                                        type="radio" name="payment_option" checked>
                                                                    <span class="d-block p-2 aiz-megabox-elem">
                                                                        <img src="{{ static_asset('assets/img/cards/instamojo.png') }}"
                                                                            class="img-fluid mb-2">
                                                                        <span class="d-block text-center">
                                                                            <span
                                                                                class="d-block fw-600 fs-15">{{ translate('Instamojo') }}</span>
                                                                        </span>
                                                                    </span>
                                                                </label>
                                                            </div>
                                                        @endif
                                                        @if (\App\BusinessSetting::where('type', 'razorpay')->first()->value == 1)
                                                            <div class="col-6 col-md-4">
                                                                <label class="aiz-megabox d-block mb-3">
                                                                    <input value="razorpay" onchange="check_shipping()"
                                                                        class="online_payment" type="radio"
                                                                        name="payment_option" id="razorpay_payment"
                                                                        checked>
                                                                    <span class="d-block p-2 aiz-megabox-elem">
                                                                        <img src="{{ static_asset('assets/img/cards/rozarpay.png') }}"
                                                                            class="img-fluid mb-2">
                                                                        <span class="d-block text-center">
                                                                            <span
                                                                                class="d-block fw-600 fs-14">{{ translate('Pay Online') }}</span>
                                                                        </span>
                                                                    </span>
                                                                </label>
                                                            </div>
                                                        @endif
                                                        @if (\App\BusinessSetting::where('type', 'paystack')->first()->value == 1)
                                                            <div class="col-6 col-md-4">
                                                                <label class="aiz-megabox d-block mb-3">
                                                                    <input value="paystack" class="online_payment"
                                                                        type="radio" name="payment_option" checked>
                                                                    <span class="d-block p-2 aiz-megabox-elem">
                                                                        <img src="{{ static_asset('assets/img/cards/paystack.png') }}"
                                                                            class="img-fluid mb-2">
                                                                        <span class="d-block text-center">
                                                                            <span
                                                                                class="d-block fw-600 fs-15">{{ translate('Paystack') }}</span>
                                                                        </span>
                                                                    </span>
                                                                </label>
                                                            </div>
                                                        @endif
                                                        @if (\App\BusinessSetting::where('type', 'ccavenue')->first()->value == 1)
                                                            <div class="col-6 col-md-4">
                                                                <label class="aiz-megabox d-block mb-3">
                                                                    <input value="ccavenue" class="online_payment"
                                                                        type="radio" name="payment_option" checked>
                                                                    <span class="d-block p-2 aiz-megabox-elem">
                                                                        <img src="{{ static_asset('assets/img/cards/ccavenue.png') }}"
                                                                            class="img-fluid mb-2">
                                                                        <span class="d-block text-center">
                                                                            <span
                                                                                class="d-block fw-600 fs-15">{{ translate('CCAvenue') }}</span>
                                                                        </span>
                                                                    </span>
                                                                </label>
                                                            </div>
                                                        @endif
                                                        @if (\App\BusinessSetting::where('type', 'voguepay')->first()->value == 1)
                                                            <div class="col-6 col-md-4">
                                                                <label class="aiz-megabox d-block mb-3">
                                                                    <input value="voguepay" class="online_payment"
                                                                        type="radio" name="payment_option" checked>
                                                                    <span class="d-block p-2 aiz-megabox-elem">
                                                                        <img src="{{ static_asset('assets/img/cards/vogue.png') }}"
                                                                            class="img-fluid mb-2">
                                                                        <span class="d-block text-center">
                                                                            <span
                                                                                class="d-block fw-600 fs-15">{{ translate('VoguePay') }}</span>
                                                                        </span>
                                                                    </span>
                                                                </label>
                                                            </div>
                                                        @endif
                                                        @if (\App\BusinessSetting::where('type', 'payhere')->first()->value == 1)
                                                            <div class="col-6 col-md-4">
                                                                <label class="aiz-megabox d-block mb-3">
                                                                    <input value="payhere" class="online_payment"
                                                                        type="radio" name="payment_option" checked>
                                                                    <span class="d-block p-2 aiz-megabox-elem">
                                                                        <img src="{{ static_asset('assets/img/cards/payhere.png') }}"
                                                                            class="img-fluid mb-2">
                                                                        <span class="d-block text-center">
                                                                            <span
                                                                                class="d-block fw-600 fs-15">{{ translate('payhere') }}</span>
                                                                        </span>
                                                                    </span>
                                                                </label>
                                                            </div>
                                                        @endif
                                                        @if (\App\BusinessSetting::where('type', 'ngenius')->first()->value == 1)
                                                            <div class="col-6 col-md-4">
                                                                <label class="aiz-megabox d-block mb-3">
                                                                    <input value="ngenius" class="online_payment"
                                                                        type="radio" name="payment_option" checked>
                                                                    <span class="d-block p-2 aiz-megabox-elem">
                                                                        <img src="{{ static_asset('assets/img/cards/ngenius.png') }}"
                                                                            class="img-fluid mb-2">
                                                                        <span class="d-block text-center">
                                                                            <span
                                                                                class="d-block fw-600 fs-15">{{ translate('ngenius') }}</span>
                                                                        </span>
                                                                    </span>
                                                                </label>
                                                            </div>
                                                        @endif
                                                        @if (\App\Addon::where('unique_identifier', 'african_pg')->first() != null &&
                                                            \App\Addon::where('unique_identifier', 'african_pg')->first()->activated)
                                                            @if (\App\BusinessSetting::where('type', 'mpesa')->first()->value == 1)
                                                                <div class="col-6 col-md-4">
                                                                    <label class="aiz-megabox d-block mb-3">
                                                                        <input value="mpesa" class="online_payment"
                                                                            type="radio" name="payment_option" checked>
                                                                        <span class="d-block p-2 aiz-megabox-elem">
                                                                            <img src="{{ static_asset('assets/img/cards/mpesa.png') }}"
                                                                                class="img-fluid mb-2">
                                                                            <span class="d-block text-center">
                                                                                <span
                                                                                    class="d-block fw-600 fs-15">{{ translate('mpesa') }}</span>
                                                                            </span>
                                                                        </span>
                                                                    </label>
                                                                </div>
                                                            @endif
                                                            @if (\App\BusinessSetting::where('type', 'flutterwave')->first()->value == 1)
                                                                <div class="col-6 col-md-4">
                                                                    <label class="aiz-megabox d-block mb-3">
                                                                        <input value="flutterwave" class="online_payment"
                                                                            type="radio" name="payment_option" checked>
                                                                        <span class="d-block p-2 aiz-megabox-elem">
                                                                            <img src="{{ static_asset('assets/img/cards/flutterwave.png') }}"
                                                                                class="img-fluid mb-2">
                                                                            <span class="d-block text-center">
                                                                                <span
                                                                                    class="d-block fw-600 fs-15">{{ translate('flutterwave') }}</span>
                                                                            </span>
                                                                        </span>
                                                                    </label>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        @if (\App\Addon::where('unique_identifier', 'paytm')->first() != null &&
                                                            \App\Addon::where('unique_identifier', 'paytm')->first()->activated)
                                                            <div class="col-6 col-md-4">
                                                                <label class="aiz-megabox d-block mb-3">
                                                                    <input value="paytm" class="online_payment"
                                                                        type="radio" name="payment_option" checked>
                                                                    <span class="d-block p-2 aiz-megabox-elem">
                                                                        <img src="{{ static_asset('assets/img/cards/paytm.jpg') }}"
                                                                            class="img-fluid mb-2">
                                                                        <span class="d-block text-center">
                                                                            <span
                                                                                class="d-block fw-600 fs-15">{{ translate('Paytm') }}</span>
                                                                        </span>
                                                                    </span>
                                                                </label>
                                                            </div>
                                                        @endif
                                                        @if (\App\BusinessSetting::where('type', 'cash_payment')->first()->value == 1)
                                                            @php
                                                                $digital = 0;
                                                                foreach (App\Models\Cart::where('user_id', Auth::user()->id)->get() as $cartItem) {
                                                                    if ($cartItem['digital'] == 1) {
                                                                        $digital = 1;
                                                                    }
                                                                }
                                                            @endphp
                                                            @if ($digital != 1 && Auth::user()->banned != 1)
                                                                <div class="col-6 col-md-4">
                                                                    <label class="aiz-megabox d-block mb-3">
                                                                        <input value="cash_on_delivery"
                                                                            onchange="check_shipping()"
                                                                            class="online_payment" type="radio"
                                                                            name="payment_option" checked>
                                                                        <span class="d-block p-2 aiz-megabox-elem">
                                                                            <img src="{{ static_asset('assets/img/cards/cod.png') }}"
                                                                                class="img-fluid mb-2">
                                                                            <span class="d-block text-center">
                                                                                <span
                                                                                    class="d-block fw-600 fs-14">{{ translate('Cash on Delivery') }}</span>
                                                                            </span>
                                                                        </span>
                                                                    </label>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        @if (Auth::check())
                                                            @if (\App\Addon::where('unique_identifier', 'offline_payment')->first() != null &&
                                                                \App\Addon::where('unique_identifier', 'offline_payment')->first()->activated)
                                                                @foreach (\App\ManualPaymentMethod::all() as $method)
                                                                    <div class="col-6 col-md-4">
                                                                        <label class="aiz-megabox d-block mb-3">
                                                                            <input value="{{ $method->heading }}"
                                                                                type="radio" name="payment_option"
                                                                                onchange="toggleManualPaymentData({{ $method->id }})"
                                                                                data-id="{{ $method->id }}" checked>
                                                                            <span class="d-block p-2 aiz-megabox-elem">
                                                                                <img src="{{ uploaded_asset($method->photo) }}"
                                                                                    class="img-fluid mb-2">
                                                                                <span class="d-block text-center">
                                                                                    <span
                                                                                        class="d-block fw-600 fs-15">{{ $method->heading }}</span>
                                                                                </span>
                                                                            </span>
                                                                        </label>
                                                                    </div>
                                                                @endforeach
                                                                @foreach (\App\ManualPaymentMethod::all() as $method)
                                                                    <div id="manual_payment_info_{{ $method->id }}"
                                                                        class="d-none">
                                                                        @php echo $method->description @endphp
                                                                        @if ($method->bank_info != null)
                                                                            <ul>
                                                                                @foreach (json_decode($method->bank_info) as $key => $info)
                                                                                    <li>{{ translate('Bank Name') }} -
                                                                                        {{ $info->bank_name }},
                                                                                        {{ translate('Account Name') }} -
                                                                                        {{ $info->account_name }},
                                                                                        {{ translate('Account Number') }} -
                                                                                        {{ $info->account_number }},
                                                                                        {{ translate('Routing Number') }} -
                                                                                        {{ $info->routing_number }}</li>
                                                                                @endforeach
                                                                            </ul>
                                                                        @endif
                                                                    </div>
                                                                @endforeach
                                                            @endif
                                                        @endif
                                            <!--<div class="bg-white mb-3 p-3  text-left d-none">-->
                                            <!--   <div id="manual_payment_description">-->
                                            <!--   </div>-->
                                            <!--</div>-->
                                            @if (Auth::check() && \App\BusinessSetting::where('type', 'wallet_system')->first()->value == 1)
                                                <!--<div class="separator mb-3">-->
                                                <!--   <span class="bg-white px-3">-->
                                                <!--   <span class="opacity-60">{{ translate('Or') }}</span>-->
                                                <!--   </span>-->
                                                <!--</div>-->
                                                <!--  <div class="text-center py-4">
                                                    <div class="h6 mb-3">
                                                       <span class="opacity-80">{{ translate('Your wallet balance :') }}</span>
                                                       <span class="fw-600">{{ single_price(Auth::user()->balance) }}</span>
                                                    </div>
                                                    @if (Auth::user()->balance <= 0)
                                                    <button type="button" class="btn call" disabled>{{ translate('Insufficient balance') }}</button>
                                                    @else
                                                    <button  type="button" onclick="use_wallet()" class="btn call">{{ translate('Pay with wallet') }}</button>
                                                    @endif
                                                 </div> -->
                                            @endif
                                        </div>
                            </div>
                        </div>

                        <div class="row align-items-center">
                            <div class="col-md-9 col-xs-12 mb-2">
                                <div class="pt-3 fs-15">
                                    <label class="aiz-checkbox">
                                        <input type="checkbox" required id="agree_checkbox">
                                        <span class="aiz-square-check fs-16"></span>
                                        <span class="fs-16">{{ translate('I agree to the') }}</span>
                                    </label>
                                    <a href="{{ route('terms') }}">{{ translate('terms and conditions') }}</a>,
                                    <a href="{{ route('returnpolicy') }}">{{ translate('return policy') }}</a> &
                                    <a href="{{ route('privacypolicy') }}">{{ translate('privacy policy') }}</a>
                                </div>
                            </div>
                            <!--<div class="col-md-3 col-xs-12">-->
                            <!--    <a href="{{ route('home') }}" class="text-dark link link--style-3">-->
                            <!--        <i class="las la-arrow-left"></i>-->
                            <!--        {{ translate('Return to shop') }}-->
                            <!--    </a>-->
                            <!--</div>-->
                            <div class="col-xxl-8 col-xl-11 mb-2 mt-2">
                                <button type="button" class="complete-order" onclick="submitOrder(this)"
                                    class="btn call fw-600">{{ translate('Complete Order') }}</button>
                            </div>
                        </div>

                </div>

                <div class="col-md-3 side">
                    <div class="rounded mb-3" id="cart-summary-details">
                        @include('frontend.partials.cart_summary')
                    </div>
                    </form>

                    <div class="mt-3">
                        <div class="input-group">
                            <div class="input-group-append">
                                {{ translate('Apply Wallet') }} &nbsp; &nbsp; <input type="checkbox" name="wallet"
                                    onchange="wallet_apply(this)"
                                    @if (Session::has('wallet_discount')) {{ 'checked' }} @endif></input>
                            </div>
                        </div>

                    </div>

                    @if (Auth::check() && \App\BusinessSetting::where('type', 'coupon_system')->first()->value == 1)
                        @if (Session::has('coupon_discount'))
                            <div class="mt-3">
                                <form class="" id="remove_coupon_code_form"
                                    action="{{ route('checkout.remove_coupon_code') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="input-group">
                                        <div class="form-control">
                                            {{ \App\Coupon::find(Session::get('coupon_id'))->code }}</div>
                                        <div class="input-group-append">
                                            <button type="submit"
                                                class="btn btn-primary">{{ translate('Change Coupon') }}</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        @else
                            <div class="mt-3">
                                <form class="" action="{{ route('checkout.apply_coupon_code') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="code"
                                            id="coupon_coupon_code" placeholder="{{ translate('Have coupon code') }}"
                                            style="border:1px solid #e7e7e7;" required>
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-primary"
                                                style="border-radius:0;">{{ translate('Apply') }}</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        @endif
                    @endif
                    <br>
                    <section class="card-header">
                        <h3 class="fs-16 fw-600 mb-0">Suggested Coupon</h3>
                    </section>
                    <ul class="coupon">
                        <div class="form-group">
                            @foreach (\App\Coupon::get() as $coupon)
                                <li id="coupon_{{ $coupon->id }}">{{ $coupon->code }} <button type=button
                                        id="ref-cpurl-btn" class="code" data-attrcpy="{{ translate('Copied') }}"
                                        onclick="CopyToClipboard('coupon_{{ $coupon->id }}')"><i
                                            class="las la-copy"></i> </button></li>
                                <br>
                            @endforeach

                        </div>
                    </ul>

                </div>
            </div>
        </div>
    </div>

    @endsection
    @section('modal')
        <div class="modal fade" id="new-address-modal" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-zoom" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title" id="exampleModalLabel">{{ translate('New Address') }}</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form class="form-default" role="form" action="{{ route('addresses.store') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <label>{{ translate('Pincode') }}</label>
                                    <input type="number" class="form-control textarea-autogrow mb-3" rows="1"
                                        name="pincode" id='pincode' required>
                                </div>
                                <div class="col-md-4">
                                    <label>{{ translate('Country') }}</label>
                                    <input type="text" class="form-control textarea-autogrow mb-3"
                                        placeholder="{{ translate('Country') }}" rows="1" name="country"
                                        id='countries_name' readonly required>
                                </div>

                                <div class="col-md-4">
                                    <label>{{ translate('State') }}</label>
                                    <input type="text" class="form-control textarea-autogrow mb-3"
                                        placeholder="{{ translate('State') }}" rows="1" name="state"
                                        id="state_name" readonly required>
                                </div>


                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <label>{{ translate('City') }}</label>
                                    <input type="text" class="form-control textarea-autogrow mb-3"
                                        placeholder="{{ translate('City') }}" rows="1" name="city"
                                        id="city_name" readonly required>
                                </div>

                                <div class="col-md-4">
                                    <label>{{ translate('Name') }}</label>
                                    <input type="text" class="form-control textarea-autogrow mb-3"
                                        placeholder="{{ translate('Name') }}" rows="1"
                                        value="{{ Auth::user()->name }}" name="name" required>
                                </div>

                                <div class="col-md-4">
                                    <label>{{ translate('Email') }}</label>
                                    <input type="email" class="form-control textarea-autogrow mb-3"
                                        placeholder="{{ translate('Email') }}" rows="1" name="email"
                                        value="{{ Auth::user()->email }}" required>
                                </div>

                                <div class="col-md-4">
                                    <label>{{ translate('Phone') }}</label>
                                    <input type="text" class="form-control mb-3"
                                        placeholder="{{ translate('+91') }}" name="phone" required>
                                </div>
                                 <div class="col-md-4">
                                    <label>{{ translate('Address Type') }}</label>
                                     <select class="form-control aiz-selectpicker" data-live-search="true" name="address_type" required>
                                                    <option value="Home">Home</option>
                                                     <option value="Office">Office</option>
                                            </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <label>{{ translate('Address') }}</label>
                                    <textarea class="form-control textarea-autogrow mb-3" placeholder="{{ translate('Your Address') }}" rows="1"
                                        name="address" required></textarea>
                                </div>

                                <div class="col-md-12">
                                    <label>{{ translate('Land Mark') }}</label>
                                    <input type="text" class="form-control textarea-autogrow mb-3"
                                        placeholder="{{ translate('Land Mark') }}" rows="1" name="land_mark"
                                        required>
                                </div>

                                <div class="col-md-12 text-right">
                                    <button type="submit" class="btn call">{{ translate('Save') }}</button>
                                </div>
                            </div>

                        </div>

                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="update-address-modal" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-zoom" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title" id="exampleModalLabel">{{ translate('Update Address') }}</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
<form class="form-default" role="form" action="{{ route('addresses.update') }}" method="POST">
            @csrf
            <input type="hidden" id="address_id" name="address_id">
            <div class="modal-body">
                  <div class="row">
                     <div class="col-md-4">
                           <label>{{ translate('Pincode')}}</label>
                         <input type="number" class="form-control textarea-autogrow mb-3"  rows="1" name="postal_code_name_update" id='postal_code_name_update'  required>
                          
                        </select>
                     </div>
                     <div class="col-md-4">
                           <label>{{ translate('Country')}}</label>
                        <input type="text" class="form-control textarea-autogrow mb-3" placeholder="{{ translate('Country')}}" rows="1" name="country" id='countries_name_update' readonly required>
                     </div>
                     
                      <div class="col-md-4">
                         <label>{{ translate('State')}}</label>
                        <input type="text" class="form-control textarea-autogrow mb-3" placeholder="{{ translate('State')}}" rows="1" name="state" id="state_name_update" readonly required>
                     </div>
                     
                     
                  </div>
                  
                  <div class="row">
                     <div class="col-md-4">
                         <label>{{ translate('City')}}</label>
                        <input type="text" class="form-control textarea-autogrow mb-3" placeholder="{{ translate('City')}}" rows="1" name="city"  id="city_name_update" readonly required>
                     </div>
                     
                     <div class="col-md-4">
                          <label>{{ translate('Name')}}</label>
                        <input type="text" class="form-control textarea-autogrow mb-3" placeholder="{{ translate('Name')}}" rows="1"  value="{{Auth::user()->name}}" name="name" id="name_update" required>
                     </div>

                     <div class="col-md-4">
                          <label>{{ translate('Email')}}</label>
                        <input type="email" class="form-control textarea-autogrow mb-3" placeholder="{{ translate('Email')}}" rows="1" name="email" value="{{Auth::user()->email}}" id="email_update" required>
                     </div>
                  
                     <div class="col-md-4">
                          <label>{{ translate('Phone')}}</label>
                        <input type="text" class="form-control mb-3" id="phone_update" placeholder="{{ translate('+91')}}" name="phone" required>
                     </div>
                     <div class="col-md-4">
                                    <label>{{ translate('Address Type') }}</label>
                                     <select class="form-control aiz-selectpicker" data-live-search="true" name="address_type" id="address_type" required>
                                                    <option value="Home">Home</option>
                                                     <option value="Office">Office</option>
                                            </select>
                                </div>
                  </div>
                  
                  <div class="row">
                     <div class="col-md-12">
                          <label>{{ translate('Address')}}</label>
                        <textarea class="form-control textarea-autogrow mb-3" placeholder="{{ translate('Your Address')}}" rows="1" name="address" id="address_update" required></textarea>
                     </div>
                    
                     <div class="col-md-12">
                            <label>{{ translate('Land Mark')}}</label>
                        <input type="text" class="form-control textarea-autogrow mb-3" placeholder="{{ translate('Land Mark')}}" rows="1" name="land_mark" id="land_mark_update" required>
                     </div>
                     
                      <div class="col-md-12 text-right">
                    <button type="submit" class="btn call">{{  translate('Save') }}</button>
                   </div>
                  </div>
                  
            </div>
           
         </form>
                </div>
            </div>
        </div>
    @endsection
    @section('script')
        <script type="text/javascript">
            $(document).ready(function() {

                var total = $('#total_price').val();
                if (total < 500 && total == 0) {

                    $('#razorpay_payment').attr('disabled', 'disabled');

                }

                $(".online_payment").click(function() {
                    $('#manual_payment_description').parent().addClass('d-none');
                });
                toggleManualPaymentData($('input[name=payment_option]:checked').data('id'));
            });


            function check_shipping() {
                

            }


            function use_wallet() {
                $('input[name=payment_option]').val('wallet');
                if ($('#agree_checkbox').is(":checked")) {

                    var shipping_amount = $('#total_shipping_cost').val();
                    var total = $('#total_price').val();
                    if (shipping_amount == 0) {
                        $('#total_shipping_cost').val(75);
                        $('#total_shipping_costs').html('Rs' + 75);
                        $('#total_price').val(parseInt(total) + parseInt(75));
                        $('.total_prices').html('Rs' + (parseInt(total) + parseInt(75)));
                    }



                    $('#checkout-form').submit();

                } else {
                    AIZ.plugins.notify('danger', '{{ translate('You need to agree with our policies') }}');
                }
            }

            function submitOrder(el) {
                $(el).prop('disabled', true);
                var check = 0;
                $('.address_id').each(function() {

                    var id = $(this).attr('id');
                    if ($('#' + id).prop('checked')) {
                        check = 1;
                    }
                });

                if (check == 1) {
                    
                    var radioValue = $("input[name='payment_option']:checked").val();
                    if (radioValue == 'cash_on_delivery') {
                        if ($('#agree_checkbox').is(":checked")) {
                               $('#checkout-form').submit();
                           
                            } else {
                            AIZ.plugins.notify('danger', '{{ translate('You need to agree with our policies') }}');
                            $(el).prop('disabled', false);
                           }

                        } 

                   
                    if (radioValue == 'razorpay') {

                        if ($('#agree_checkbox').is(":checked")) {

                           $('#checkout-form').submit();

                        } else {
                            AIZ.plugins.notify('danger', '{{ translate('You need to agree with our policies') }}');
                            $(el).prop('disabled', false);
                        }
                     }
                    }else {
                    AIZ.plugins.notify('danger', '{{ translate('Please Select Address') }}');
                    $(el).prop('disabled', false);
                }

                } 


          

            function toggleManualPaymentData(id) {
                $('#manual_payment_description').parent().removeClass('d-none');
                $('#manual_payment_description').html($('#manual_payment_info_' + id).html());
            }
        </script>

        <script type="text/javascript">
            function add_new_address() {
                $('#new-address-modal').modal('show');
            }

            function update_address(address) {
                $('#update-address-modal').modal('show');
                $('#address_id').val(address.id);
                $('#postal_code_name_update').val(address.postal_code);
                $.post('{{ route('addresses.pincode_list_new') }}', {
                    _token: '{{ csrf_token() }}',
                    id: address.postal_code
                }, function(data) {
                    $('#countries_name_update').empty();
                    $('#countries_name_update').val(data.countries_name);
                    $('#state_name_update').empty();
                    $('#state_name_update').val(data.state_name);
                    $('#city_name_update').empty();
                    $('#city_name_update').val(data.city_name);
                });


                $('#email_update').val(address.email);
                $('#name_update').val(address.name);
                $('#phone_update').val(address.phone);
                $('#address_type').val(address.address_type);
                $('#address_update').val(address.address);
                $('#land_mark_update').val(address.land_mark);




            }

            $(document).ready(function() {

                $('#pincode').keyup(function() {
                    var pincode = $(this).val();
                    $.post('{{ route('addresses.pincode_list_new') }}', {
                        _token: '{{ csrf_token() }}',
                        id: pincode
                    }, function(data) {
                        $('#countries_name').empty();
                        $('#countries_name').val(data.countries_name);
                        $('#state_name').empty();
                        $('#state_name').val(data.state_name);
                        $('#city_name').empty();
                        $('#city_name').val(data.city_name);

                    });
                });
                $('#postal_code_name_update').keyup(function() {
                    var pincode = $(this).val();
                    $.post('{{ route('addresses.pincode_list_new') }}', {
                        _token: '{{ csrf_token() }}',
                        id: pincode
                    }, function(data) {
                        $('#countries_name_update').empty();
                        $('#countries_name_update').val(data.countries_name);
                        $('#state_name_update').empty();
                        $('#state_name_update').val(data.state_name);
                        $('#city_name_update').empty();
                        $('#city_name_update').val(data.city_name);
                    });
                });
                $('#countries_name').change(function() {

                    var country_name = $('#countries_name').val();

                    $.post('{{ route('addresses.state_list') }}', {
                        _token: '{{ csrf_token() }}',
                        id: country_name
                    }, function(data) {

                        $('#state_name').empty();
                        $('#state_name').append('<option value="">Select State</option>');
                        $.each(data.list, function(item, i) {
                            $('#state_name').append('<option value="' + i.state_name + '">' + i
                                .state_name + '</option>');
                        });

                    });


                });
                $('#state_name').change(function() {

                    var state_name = $('#state_name').val();

                    $.post('{{ route('addresses.city_list') }}', {
                        _token: '{{ csrf_token() }}',
                        id: state_name
                    }, function(data) {

                        $('#city_name').empty();
                        $('#city_name').append('<option value="">Select City</option>');
                        $.each(data.list, function(item, i) {
                            $('#city_name').append('<option value="' + i.city_name + '">' + i
                                .city_name + '</option>');
                        });

                    });


                })


                $('#city_name').change(function() {

                    var city_name = $('#city_name').val();
                    $.post('{{ route('addresses.pincode_list') }}', {
                        _token: '{{ csrf_token() }}',
                        id: city_name
                    }, function(data) {

                        $('#postal_code_name').empty();
                        $('#postal_code_name').append('<option value="">Select Pincode</option>');
                        $.each(data.list, function(item, i) {
                            $('#postal_code_name').append('<option value="' + i.pincode + '">' +
                                i.pincode + '</option>');
                        });

                    });
                })
            });
        </script>
        <script type="text/javascript">
            function add_new_address() {
                $('#new-address-modal').modal('show');
            }

            function removeFromCartView(e, key) {
                e.preventDefault();
                removeFromCart(key);
            }

            function updateQuantity(key, element) {
                $('.ajax-loader').css("visibility", "visible");
                $.post('{{ route('cart.updateQuantity') }}', {
                    _token: '{{ csrf_token() }}',
                    key: key,
                    quantity: element.value
                }, function(data) {
                    updateNavCart();
                    $('#cart-summary').html(data);
                    $.post('{{ route('cart.updateCartSummary') }}', {
                        _token: '{{ csrf_token() }}',
                        key: key,
                        quantity: element.value
                    }, function(data) {
                        $('#cart-summary-details').html(data);
                        $('.ajax-loader').css("visibility", "hidden");
                    });
                });
            }

            function showCheckoutModal() {
                $('#GuestCheckout').modal();
            }

            $(document).ready(function() {
                $('#countries_name').change(function() {

                    var country_name = $('#countries_name').val();

                    $.post('{{ route('addresses.state_list') }}', {
                        _token: '{{ csrf_token() }}',
                        id: country_name
                    }, function(data) {

                        $('#state_name').empty();
                        $('#state_name').append('<option value="">Select State</option>');
                        $.each(data.list, function(item, i) {
                            $('#state_name').append('<option value="' + i.state_name + '">' + i
                                .state_name + '</option>');
                        });

                    });


                });
                $('#state_name').change(function() {

                    var state_name = $('#state_name').val();

                    $.post('{{ route('addresses.city_list') }}', {
                        _token: '{{ csrf_token() }}',
                        id: state_name
                    }, function(data) {

                        $('#city_name').empty();
                        $('#city_name').append('<option value="">Select City</option>');
                        $.each(data.list, function(item, i) {
                            $('#city_name').append('<option value="' + i.city_name + '">' + i
                                .city_name + '</option>');
                        });

                    });


                })


                $('#city_name').change(function() {

                    var city_name = $('#city_name').val();
                    $.post('{{ route('addresses.pincode_list') }}', {
                        _token: '{{ csrf_token() }}',
                        id: city_name
                    }, function(data) {

                        $('#postal_code_name').empty();
                        $('#postal_code_name').append('<option value="">Select Pincode</option>');
                        $.each(data.list, function(item, i) {
                            $('#postal_code_name').append('<option value="' + i.pincode + '">' +
                                i.pincode + '</option>');
                        });

                    });
                })
            });

            $('input[name="customize[]"]').on('change', function() {

                var id = $(this).attr('id');
                var total_custom = $('#total_customizable').val();
                var total_gift = $('#total_gift').val();
                if (!$(this).is(':checked')) {

                    $('#refundable_days_' + id).hide();
                    $.post('{{ route('cart.updateCartSummary') }}', {
                        _token: '{{ csrf_token() }}',
                        product_id: id,
                        type: 'custom_unchecked',
                        total_custom: total_custom,
                        total_gift: total_gift
                    }, function(data) {
                        $('#cart-summary-details').html(data);
                    });
                } else {
                    $('#refundable_days_' + id).show();
                    $.post('{{ route('cart.updateCartSummary') }}', {
                        _token: '{{ csrf_token() }}',
                        product_id: id,
                        type: 'custom_checked',
                        total_custom: total_custom,
                        total_gift: total_gift
                    }, function(data) {
                        $('#cart-summary-details').html(data);
                    });
                }
            });

            $('input[name="gift[]"]').on('change', function() {
                var id = $(this).attr('id');
                var total_gift = $('#total_gift').val();
                var total_custom = $('#total_customizable').val();
                if (!$(this).is(':checked')) {


                    $.post('{{ route('cart.updateCartSummary') }}', {
                        _token: '{{ csrf_token() }}',
                        product_id: id,
                        type: 'gift_unchecked',
                        total_gift: total_gift,
                        total_custom: total_custom
                    }, function(data) {
                        $('#cart-summary-details').html(data);
                    });
                } else {

                    $.post('{{ route('cart.updateCartSummary') }}', {
                        _token: '{{ csrf_token() }}',
                        product_id: id,
                        type: 'gift_checked',
                        total_gift: total_gift,
                        total_custom: total_custom
                    }, function(data) {
                        $('#cart-summary-details').html(data);
                    });
                }
            });


            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        $('#blah')
                            .attr('src', e.target.result);
                    };

                    reader.readAsDataURL(input.files[0]);
                }
            }

            $('#fast_delivery').on('change', function() {
                var fast_delivery = $('#fast_delivery').val();
                var total_price = $('#total_price').val();
                if (!$(this).is(':checked')) {

                    $('#fast_deliverys').val('Rs' + 0);
                    $('#fast_deliveryss').html('Rs' + 0);
                    $('#total_price').val(parseInt(total_price) - parseInt(fast_delivery));
                    $('.total_prices').html('Rs' + (parseInt(total_price) - parseInt(fast_delivery)));
                } else {


                    $('#fast_deliverys').val('Rs' + fast_delivery);
                    $('#fast_deliveryss').html('Rs' + fast_delivery);
                    $('#total_price').val(parseInt(total_price) + parseInt(fast_delivery));
                    $('.total_prices').html('Rs' + (parseInt(total_price) + parseInt(fast_delivery)));
                }
            });

            function CopyToClipboard(containerid) {

                var coupon = $('#' + containerid).text();
                $('#coupon_coupon_code').empty();
                $('#coupon_coupon_code').val(coupon);
                AIZ.plugins.notify('success', 'Copied');
            }

            function wallet_apply(el) {
                if ($(el).prop('checked')) {
                    $.post('{{ route('checkout.apply_wallet') }}', {
                        _token: '{{ csrf_token() }}'
                    }, function(data) {
                        updateNavCart();
                        if (data == 1) {
                            AIZ.plugins.notify('success', 'Wallet Discount Applied ');
                            $.post('{{ route('cart.updateCartSummary') }}', {
                                _token: '{{ csrf_token() }}'
                            }, function(data) {
                                $('#cart-summary-details').html(data);
                            });
                        }
                    });
                }
                if (!$(el).prop('checked')) {

                    $.post('{{ route('checkout.remove_wallet_discount') }}', {
                        _token: '{{ csrf_token() }}'
                    }, function(data) {
                        updateNavCart();
                        if (data == 1) {
                            AIZ.plugins.notify('success', 'Wallet Discount Remove');
                            $.post('{{ route('cart.updateCartSummary') }}', {
                                _token: '{{ csrf_token() }}'
                            }, function(data) {
                                $('#cart-summary-details').html(data);
                            });
                        }
                    });


                }


            }
        </script>


        <script type="text/javascript">
            $('input[name="customize"]').on('change', function() {
                $('.ajax-loader').css("visibility", "visible");
                var id = $(this).attr('id');
                var total_custom = $('#total_customizable').val();
                var total_gift = $('#total_gift').val();
                if (!$(this).is(':checked')) {

                    $('#refundable_days_' + id).hide();
                    $.post('{{ route('cart.updateCartSummary') }}', {
                        _token: '{{ csrf_token() }}',
                        product_id: id,
                        type: 'custom_unchecked',
                        total_custom: total_custom,
                        total_gift: total_gift
                    }, function(data) {
                        $('#cart-summary-details').html(data);
                        $('.ajax-loader').css("visibility", "hidden");
                    });
                } else {
                    $('#refundable_days_' + id).show();
                    $.post('{{ route('cart.updateCartSummary') }}', {
                        _token: '{{ csrf_token() }}',
                        product_id: id,
                        type: 'custom_checked',
                        total_custom: total_custom,
                        total_gift: total_gift
                    }, function(data) {
                        $('#cart-summary-details').html(data);
                        $('.ajax-loader').css("visibility", "hidden");
                    });
                }
            });

            $('input[name="gift"]').on('change', function() {
                $('.ajax-loader').css("visibility", "visible");
                var id = $(this).attr('id');
                var total_gift = $('#total_gift').val();
                var total_custom = $('#total_customizable').val();
                if (!$(this).is(':checked')) {


                    $.post('{{ route('cart.updateCartSummary') }}', {
                        _token: '{{ csrf_token() }}',
                        product_id: id,
                        type: 'gift_unchecked',
                        total_gift: total_gift,
                        total_custom: total_custom
                    }, function(data) {
                        $('#cart-summary-details').html(data);
                        $('.ajax-loader').css("visibility", "hidden");
                    });
                } else {

                    $.post('{{ route('cart.updateCartSummary') }}', {
                        _token: '{{ csrf_token() }}',
                        product_id: id,
                        type: 'gift_checked',
                        total_gift: total_gift,
                        total_custom: total_custom
                    }, function(data) {
                        $('#cart-summary-details').html(data);
                        $('.ajax-loader').css("visibility", "hidden");
                    });
                }
            });


            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        $('#blah')
                            .attr('src', e.target.result);
                    };

                    reader.readAsDataURL(input.files[0]);
                }
            }
        </script>
    @endsection
