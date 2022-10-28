@extends('frontend.layouts.app')

@section('content')
@php
    $whatsapps =  \App\Whatsapp::where('status', 1)->get();
@endphp


<section class="pt-4 mb-4">
    <div class="container text-center">
        <div class="row">
            <div class="col-lg-6 text-center text-lg-left">
                <h1 class="fw-600 h4">Whatsapp</h1>
            </div>
            <div class="col-lg-6">
                <ul class="breadcrumb bg-transparent p-0 justify-content-center justify-content-lg-end">
                    <li class="breadcrumb-item opacity-50">
                        <a class="text-reset" href="{{ route('home') }}">{{ translate('Home')}}</a>
                    </li>
                    <li class="text-dark fw-600 breadcrumb-item">
                        <a class="text-reset" href="{{ route('sellerpolicy') }}">"{{ translate('Whatsapp') }}"</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>
<section class="mb-4">
    <div class="container">
        <div class="p-4 bg-white rounded shadow-sm overflow-hidden mw-100 text-left">
          <div class="row">
            @foreach($whatsapps as $whatsapp)
             
               <div class="col-md-3 styl">
            <a class="aa" href="https://api.whatsapp.com/send?phone=+91 {{$whatsapp->number}}" target="_blank">
     <img src="https://cdn2.iconfinder.com/data/icons/social-messaging-ui-color-shapes-2-free/128/social-whatsapp-circle-512.png" class="wt">
   +91 {{$whatsapp->number}} <br>
   <p class="num"> {{$whatsapp->name}} </p></a> 
   </div>
            @endforeach
           </div>
        </div>
    </div>
</section>
@endsection

<style>
    .styl{
        box-shadow: 0 0 1px 0px #0000007a;
        padding-bottom: 5px;
        padding-top: 5px;
        margin-right: 10px;
    }
    .aa{
        font-weight: 600;
    letter-spacing: .75px;
    font-size: 15px;
    }
</style>