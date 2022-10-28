@extends('frontend.layouts.app')



@section('content')

<style>
     [dir=rtl] .floating-label > input + label,
    [dir=rtl] .floating-label > textarea + label {
      right: 0;
      left: auto !important;
    }
    [dir=rtl] .floating-label > input:not([placeholder]):not([value]) + label,
    [dir=rtl] .floating-label > textarea:not([placeholder]):empty + label, [dir=rtl] .floating-label > input[placeholder]:not(:placeholder-shown) + label,
    [dir=rtl] .floating-label > textarea[placeholder]:not(:placeholder-shown) + label, [dir=rtl] .floating-label > input:-webkit-autofill + label,
    [dir=rtl] .floating-label > textarea:-webkit-autofill + label, [dir=rtl] .floating-label > input:focus + label,
    [dir=rtl] .floating-label > textarea:focus + label, [dir=rtl] .floating-label > select + label {
      right: 0.5rem;
      left: auto !important;
    }

    .floating-label {
      position: relative;
    }
    .floating-label > select + label,
    .floating-label > select + label.label-sm {
      position: absolute;
      z-index: 3;
      max-width: 100%;
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
      left: 0.5rem;
      padding: 0 0.3rem;
      color: inherit;
      background-color: #fff;
      border-radius: 0.25rem;
      top: -0.7875rem;
      font-size: 0.875rem;
    }
    .floating-label > select + label.label-md {
      position: absolute;
      z-index: 3;
      max-width: 100%;
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
      left: 0.5rem;
      padding: 0 0.3rem;
      color: inherit;
      background-color: #fff;
      border-radius: 0.25rem;
      top: -0.9rem;
      font-size: 1rem;
    }
    .floating-label > select + label.label-lg {
      position: absolute;
      z-index: 3;
      max-width: 100%;
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
      left: 0.5rem;
      padding: 0 0.3rem;
      color: inherit;
      background-color: #fff;
      border-radius: 0.25rem;
      top: -1.125rem;
      font-size: 1.25rem;
    }
    .floating-label > select:disabled + label, .floating-label > select[readonly] + label {
      background-color: #e9ecef;
    }
    .floating-label > input + label,
    .floating-label > textarea + label {
      transition: all 150ms cubic-bezier(0.4, 0, 0.2, 1);
      position: absolute;
      z-index: 3;
      max-width: 100%;
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
      top: 0;
      left: 0;
      color: #6c757d;
      pointer-events: none;
      font-size: 1rem;
      padding: calc(0.6rem + 1px) calc(0.75rem + 1px);
    }
    .floating-label > input.form-control-sm + label,
    .floating-label > textarea.form-control-sm + label {
      position: absolute;
      z-index: 3;
      max-width: 100%;
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
      top: 0;
      left: 0;
      color: #6c757d;
      pointer-events: none;
      font-size: 0.875rem;
      padding: calc(0.25rem + 1px) calc(0.5rem + 1px);
    }
    .floating-label > input.form-control-lg + label,
    .floating-label > textarea.form-control-lg + label {
      position: absolute;
      z-index: 3;
      max-width: 100%;
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
      top: 0;
      left: 0;
      color: #6c757d;
      pointer-events: none;
      font-size: 1.25rem;
      padding: calc(0.5rem + 1px) calc(1rem + 1px);
    }
    .floating-label > input::placeholder,
    .floating-label > textarea::placeholder {
      color: transparent;
      transition: color 150ms cubic-bezier(0.4, 0, 0.2, 1);
    }
    .floating-label > label + input::placeholder,
    .floating-label > label + textarea::placeholder {
      color: #6c757d;
    }
    .floating-label > input:focus::placeholder,
    .floating-label > textarea:focus::placeholder {
      color: #6c757d;
    }
    .floating-label > input:focus + label,
    .floating-label > input:focus + label.label-sm,
    .floating-label > textarea:focus + label,
    .floating-label > textarea:focus + label.label-sm {
      position: absolute;
      z-index: 3;
      max-width: 100%;
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
      left: 0.5rem;
      padding: 0 0.3rem;
      color: inherit;
      background-color: #fff;
      border-radius: 0.25rem;
      top: -0.7875rem;
      font-size: 0.875rem;
    }
    .floating-label > input:focus + label.label-md,
    .floating-label > textarea:focus + label.label-md {
      position: absolute;
      z-index: 3;
      max-width: 100%;
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
      left: 0.5rem;
      padding: 0 0.3rem;
      color: inherit;
      background-color: #fff;
      border-radius: 0.25rem;
      top: -0.9rem;
      font-size: 1rem;
    }
    .floating-label > input:focus + label.label-lg,
    .floating-label > textarea:focus + label.label-lg {
      position: absolute;
      z-index: 3;
      max-width: 100%;
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
      left: 0.5rem;
      padding: 0 0.3rem;
      color: inherit;
      background-color: #fff;
      border-radius: 0.25rem;
      top: -1.125rem;
      font-size: 1.25rem;
    }
    .floating-label > input:focus[readonly] + label,
    .floating-label > textarea:focus[readonly] + label {
      background-color: #e9ecef;
    }

    .floating-label > input:-webkit-autofill + label,
    .floating-label > input:-webkit-autofill + label.label-sm,
    .floating-label > textarea:-webkit-autofill + label,
    .floating-label > textarea:-webkit-autofill + label.label-sm {
      position: absolute;
      z-index: 3;
      max-width: 100%;
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
      left: 0.5rem;
      padding: 0 0.3rem;
      color: inherit;
      background-color: #fff;
      border-radius: 0.25rem;
      top: -0.7875rem;
      font-size: 0.875rem;
    }
    .floating-label > input:-webkit-autofill + label.label-md,
    .floating-label > textarea:-webkit-autofill + label.label-md {
      position: absolute;
      z-index: 3;
      max-width: 100%;
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
      left: 0.5rem;
      padding: 0 0.3rem;
      color: inherit;
      background-color: #fff;
      border-radius: 0.25rem;
      top: -0.9rem;
      font-size: 1rem;
    }
    .floating-label > input:-webkit-autofill + label.label-lg,
    .floating-label > textarea:-webkit-autofill + label.label-lg {
      position: absolute;
      z-index: 3;
      max-width: 100%;
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
      left: 0.5rem;
      padding: 0 0.3rem;
      color: inherit;
      background-color: #fff;
      border-radius: 0.25rem;
      top: -1.125rem;
      font-size: 1.25rem;
    }

    .floating-label > input[placeholder]:not(:placeholder-shown) + label,
    .floating-label > input[placeholder]:not(:placeholder-shown) + label.label-sm,
    .floating-label > textarea[placeholder]:not(:placeholder-shown) + label,
    .floating-label > textarea[placeholder]:not(:placeholder-shown) + label.label-sm {
      position: absolute;
      z-index: 3;
      max-width: 100%;
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
      left: 0.5rem;
      padding: 0 0.3rem;
      color: inherit;
      background-color: #fff;
      border-radius: 0.25rem;
      top: -0.7875rem;
      font-size: 0.875rem;
    }
    .floating-label > input[placeholder]:not(:placeholder-shown) + label.label-md,
    .floating-label > textarea[placeholder]:not(:placeholder-shown) + label.label-md {
      position: absolute;
      z-index: 3;
      max-width: 100%;
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
      left: 0.5rem;
      padding: 0 0.3rem;
      color: inherit;
      background-color: #fff;
      border-radius: 0.25rem;
      top: -0.9rem;
      font-size: 1rem;
    }
    .floating-label > input[placeholder]:not(:placeholder-shown) + label.label-lg,
    .floating-label > textarea[placeholder]:not(:placeholder-shown) + label.label-lg {
      position: absolute;
      z-index: 3;
      max-width: 100%;
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
      left: 0.5rem;
      padding: 0 0.3rem;
      color: inherit;
      background-color: #fff;
      border-radius: 0.25rem;
      top: -1.125rem;
      font-size: 1.25rem;
    }
    .floating-label > input[placeholder]:not(:placeholder-shown):disabled + label, .floating-label > input[placeholder]:not(:placeholder-shown)[readonly] + label,
    .floating-label > textarea[placeholder]:not(:placeholder-shown):disabled + label,
    .floating-label > textarea[placeholder]:not(:placeholder-shown)[readonly] + label {
      background-color: #e9ecef;
    }
    .floating-label > input:not([placeholder]):not([value]) + label,
    .floating-label > input:not([placeholder]):not([value]) + label.label-sm,
    .floating-label > textarea:not([placeholder]):empty + label,
    .floating-label > textarea:not([placeholder]):empty + label.label-sm {
      position: absolute;
      z-index: 3;
      max-width: 100%;
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
      left: 0.5rem;
      padding: 0 0.3rem;
      color: inherit;
      background-color: #fff;
      border-radius: 0.25rem;
      top: -0.7875rem;
      font-size: 0.875rem;
    }
    .floating-label > input:not([placeholder]):not([value]) + label.label-md,
    .floating-label > textarea:not([placeholder]):empty + label.label-md {
      position: absolute;
      z-index: 3;
      max-width: 100%;
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
      left: 0.5rem;
      padding: 0 0.3rem;
      color: inherit;
      background-color: #fff;
      border-radius: 0.25rem;
      top: -0.9rem;
      font-size: 1rem;
    }
    .floating-label > input:not([placeholder]):not([value]) + label.label-lg,
    .floating-label > textarea:not([placeholder]):empty + label.label-lg {
      position: absolute;
      z-index: 3;
      max-width: 100%;
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
      left: 0.5rem;
      padding: 0 0.3rem;
      color: inherit;
      background-color: #fff;
      border-radius: 0.25rem;
      top: -1.125rem;
      font-size: 1.25rem;
    }
    .floating-label > input:not([placeholder]):not([value]):disabled + label, .floating-label > input:not([placeholder]):not([value])[readonly] + label,
    .floating-label > textarea:not([placeholder]):empty:disabled + label,
    .floating-label > textarea:not([placeholder]):empty[readonly] + label {
      background-color: #e9ecef;
    }
    .special-label {
        background: #fff;
        font-size: 14px;
        left: 25px;
        padding: 0 5px;
        position: absolute;
        top: -12px;
        z-index: 1;
    }

    .special-label-2 {
        background: #fff;
        font-size: 14px;
        left: 225px;
        padding: 0 5px;
        position: absolute;
        top: -12px;
        z-index: 9999;
    }
</style>


<section class="tract-order">

    <div class="container">

        <div class="row">

            <div class="col-lg-6 text-lg-left">

                <h1 class="fw-600 h4"> {{translate('Phone Verification')}}</h1>

            </div>

            <div class="col-lg-6">

                <ul class="breadcrumb bg-transparent p-0 justify-content-center justify-content-lg-end">

                    <li class="breadcrumb-item opacity-50">

                        <a class="text-reset" href="{{ route('home') }}">{{ translate('Home') }}</a>

                    </li>

                    <li class="text-dark fw-600 breadcrumb-item">

                        <a href="{{ route('verification.phone.resend') }}">{{translate('Resend Code')}}</a>

                    </li>

                </ul>

            </div>

        </div>

    </div>

</section>

    <section class="gry-bg py-4">

        <div class="profile">

            <div class="container">

                <div class="row">

                    <div class="col-lg-5 mx-auto">

                        <div class="card">

                            <div class="hide text-center px-35 pt-5">

                                <h3 class="heading heading-4 strong-500">

                                    {{translate('Phone Verification')}}

                                </h3>

                                <p class="text-center">Verification code has been sent. Please wait a few minutes.</p>

                                <a href="{{ route('verification.phone.resend') }}">{{translate('Resend Code')}}</a>

                            </div>

                            <div class="verification">

                                <div class="row align-items-center">

                                    <div class="col-12 col-lg">

                                        <form class="form-default" role="form" action="{{ route('verification.submit') }}" method="POST">

                                            @csrf
 
                                            <div class="form-group">

                                                <div class="input-group--style-1">
                                                    @if($is_name=='yes')
                                                    <div class="input-area mb-3 floating-label">
                                                        <input type="text" class="form-control" placeholder="Your Name" name="name" required="">
                                                        <label for="text-placeholder">Your Name:</label>
                                                    </div>
                                                    @endif
                                                    <div class="input-area mb-3 floating-label">
                                                        <input type="text" class="form-control" placeholder="Enter OTP" name="verification_code" required="">
                                                        <label for="text-placeholder">OTP:</label>
                                                    </div>
                                                </div>

                                            </div>



                                            <div class="row align-items-center">

                                                <div class="col-12 text-right">

                                                    <button type="submit" class="cell btn btn-primary btn-block">{{ translate('Verify') }}</button>

                                                </div>

                                            </div>

                                        </form>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>

@endsection

