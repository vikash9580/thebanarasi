
<div class="top-navbar d-none">
	<div class="container-fluid">
	    <div class="pl-md-4 px-md-4">
		<div class="row">
			<div class="col-lg-6 col">
				<ul class="list-inline mb-0">
					<li class="list-inline-item">
						<a href="tel:{{ get_setting('contact_phone') }}"><i class="la la-phone"></i> {{ get_setting('contact_phone') }}</a>
					</li>
					<li class="hide list-inline-item">
						<a href="mailto:{{ get_setting('contact_email')  }}" class="text-reset"><i class="la la-envelope-open-text"></i> {{ get_setting('contact_email')  }}</a>
					</li>
				</ul>
				<ul class="list-inline d-flex justify-content-between justify-content-lg-start mb-0">
					@if(get_setting('show_language_switcher') == 'on')
					<li class="list-inline-item dropdown" id="lang-change">
						@php
						if(Session::has('locale')){
						$locale = Session::get('locale', Config::get('app.locale'));
						}
						else{
						$locale = 'en';
						}
						@endphp
						<a href="javascript:void(0)" class="dropdown-toggle text-reset py-2" data-toggle="dropdown" data-display="static">
							<img src="{{ static_asset('assets/img/placeholder.jpg') }}" data-src="{{ static_asset('assets/img/flags/'.$locale.'.png') }}" class="mr-2 lazyload" alt="{{ \App\Language::where('code', $locale)->first()->name }}" height="11">
							<span class="opacity-60">{{ \App\Language::where('code', $locale)->first()->name }}</span>
						</a>
						<ul class="dropdown-menu dropdown-menu-left">
							@foreach (\App\Language::all() as $key => $language)
							<li>
								<a href="javascript:void(0)" data-flag="{{ $language->code }}" class="dropdown-item @if($locale == $language) active @endif">
									<img src="{{ static_asset('assets/img/placeholder.jpg') }}" data-src="{{ static_asset('assets/img/flags/'.$language->code.'.png') }}" class="mr-1 lazyload" alt="{{ $language->name }}" height="11">
									<span class="language">{{ $language->name }}</span>
								</a>
							</li>
							@endforeach
						</ul>
					</li>
					@endif
					@if(get_setting('show_currency_switcher') == 'on')
					<li class="list-inline-item dropdown" id="currency-change">
						@php
						if(Session::has('currency_code')){
						$currency_code = Session::get('currency_code');
						}
						else{
						$currency_code = \App\Currency::findOrFail(\App\BusinessSetting::where('type', 'system_default_currency')->first()->value)->code;
						}
						@endphp
						<a href="javascript:void(0)" class="dropdown-toggle text-reset py-2 opacity-60" data-toggle="dropdown" data-display="static">
							{{ \App\Currency::where('code', $currency_code)->first()->name }} {{ (\App\Currency::where('code', $currency_code)->first()->symbol) }}
						</a>
						<ul class="dropdown-menu dropdown-menu-right dropdown-menu-lg-left">
							@foreach (\App\Currency::where('status', 1)->get() as $key => $currency)
							<li>
								<a class="dropdown-item @if($currency_code == $currency->code) active @endif" href="javascript:void(0)" data-currency="{{ $currency->code }}">{{ $currency->name }} ({{ $currency->symbol }})</a>
							</li>
							@endforeach
						</ul>
					</li>
					@endif
				</ul>
			</div>
			<div class="topp col-6 text-right d-none d-lg-block">
				<ul class="list-inline mb-0">
					@auth
					@if(isAdmin())
					<li class="list-inline-item">
						<a href="{{ route('admin.dashboard') }}" class="text-reset py-2 d-inline-block opacity-60"> <i class="la la-truck" aria-hidden="true"></i>{{ translate('My Panel')}}</a>
					</li>
					@else
					<li class="list-inline-item">
						<a href="{{ route('dashboard') }}" class="text-reset py-2 d-inline-block opacity-60"> <i class="la la-user" aria-hidden="true"></i>{{Auth::user()->name}}</a>
					</li>
					@endif
					{{--<li  class="list-inline-item">
						<a href="{{route('ccavenue.payment_status')}}" class="top-bar-item"> <i class="la la-inr" aria-hidden="true"></i>Track Payment</a>
					</li>--}}
					<li  class="list-inline-item">
						<a href="{{route('orders.track')}}" class="top-bar-item"> <i class="fas fa-analytics"></i>Track Order</a>
					</li>
					<li class="list-inline-item">
						<a href="{{ route('logout') }}" class="text-reset py-2 d-inline-block opacity-60"> <i class="fas fa-sign-in-alt"></i>{{ translate('Logout')}}</a>
					</li>
					@else
					{{--<li  class="list-inline-item">
						<a href="{{route('ccavenue.payment_status')}}" class="top-bar-item"> <i class="fas fa-rupee-sign"></i>Track Payment</a>
					</li>--}}
					<li  class="list-inline-item">
						<a href="{{route('orders.track')}}" class="top-bar-item"><i class="la la-truck"></i>Track Order</a>
					</li>

					@endauth
				</ul>
			</div>
		</div>
	</div>
</div>
</div>
<!-- END Top Bar -->
<div class="mid-header">
    <div class="container-fluid">
       <div class="row">
          <div class="col-md-3 logo">
             <a class="d-none d-lg-block py-5px mr-3 ml-0" href="{{ route('home') }}">
             @php
             $header_logo = get_setting('header_logo');
             @endphp
             @if($header_logo != null)
              <img src="{{ uploaded_asset($header_logo) }}" alt="{{ env('APP_NAME') }}">
             @else
              <img src="{{ static_asset('assets/img/logo.png') }}" alt="{{ env('APP_NAME') }}">
             @endif
             </a>
          </div>

          <div class="col-md-5">
             <form action="{{ route('search') }}" method="GET" class="stop-propagation">
                <div class="d-flex position-relative align-items-center">
                   <div class="input-group search">
                      <input type="text" class="form-control" id="search" name="q" placeholder="{{translate('I am shopping for...')}}" autocomplete="off">
                      <div class="input-group-append d-lg-block">
                         <button class="serbt" type="submit">
                         <i class="la la-search la-flip-horizontal fs-20"></i>
                         </button>
                      </div>
                   </div>
                </div>
             </form>
          </div>

          <div class="col-md-4 pt-user hide">
             <ul>
             @auth
             @if(isAdmin())
              <li>
                <a href="{{ route('admin.dashboard') }}" class="nav-box-text"> <i class="crt la la-user la-2x"></i> <span class="crtt">{{ translate('My Panel')}}</span></a>
             </li>
             @else
             <li>
                <a href="{{ route('dashboard') }}" class="nav-box-text"> <i class="crt la la-user la-2x"></i> <span class="crtt">{{ translate('My Panel')}}</span></a>
             </li>
             @endif
             <!--   <a href="{{ route('logout') }}" class="py-2 d-inline-block"> <i class="fas fa-sign-in-alt"></i>{{ translate('Logout')}}</a>-->
             @else
             <li>
                <a href="{{ route('user.registration') }}" class="nav-box-text"> <i class="crt la la-user la-2x"></i><span class="crtt">{{ translate('Login/Register')}}</span></a>
             </li>
             @endauth

             <li class="align-self-stretch" data-hover="dropdown">
                 <div id="wishlist">
                     @include('frontend.partials.wishlist')
                 </div>
             </li>

             <li class="align-self-stretch" data-hover="dropdown">
                <div class="nav-cart-box dropdown" id="cart_items">
                   @include('frontend.partials.cart')
                </div>
             </li>

             @if(get_setting('show_currency_switcher') == 'on')
             <li class="list-inline-item dropdown mt-1 ml-3" id="currency-change">
                @php
                if(Session::has('currency_code')){
                $currency_code = Session::get('currency_code');
                }
                else{
                $currency_code = \App\Currency::findOrFail(\App\BusinessSetting::where('type', 'system_default_currency')->first()->value)->code;
                }
                @endphp
                <a href="javascript:void(0)" class="dropdown-toggle py-2 opacity-60 fs-15" data-toggle="dropdown" data-display="static">
                {{ \App\Currency::where('code', $currency_code)->first()->name }} {{ (\App\Currency::where('code', $currency_code)->first()->symbol) }}
                </a>

             </li>
             @endif
             </ul>
          </div>
       </div>
    </div>
 </div>

<div class="wsmobileheader clearfix">
    <a href="#" id="wsnavtoggle" class="wsanimated-arrow"><span></span></a>
    <span class="smllogo">
    @php
    $header_logo = get_setting('header_logo');
    @endphp
    @if($header_logo != null)
    <a href="{{ route('home') }}">
    <img src="{{ uploaded_asset($header_logo) }}" alt="{{ env('APP_NAME') }}">
    @else
    <img src="{{ static_asset('assets/img/logo.png') }}" alt="{{ env('APP_NAME') }}">
    @endif
    </a>
    </span>
    <a href="tel:{{ get_setting('contact_phone') }}" class="callusbtn" title="Header Icons"><i class="la la-phone-volume"></i></a>
 </div>
 <!-- Mobile Header -->
    <section class="hero navigation">
       <div class="header-content bigmegamenu clearfix">
          <nav class="wsmenu clearfix">
             <ul class="wsmenu-list">
                 <li aria-haspopup="true"><a class="active  pd-left-12" href="/" aria-label="Home" class="active"><span>Home</span></a></li>
                 @foreach (\App\Category::all()->take(9) as $key => $category)
                 <li aria-haspopup="true">
                    <a href="{{ route('products.category', $category->slug) }}"> {{ $category->getTranslation('name') }}
                    <span class="wsarrow"></span></a>
                    <div class="wsmegamenu clearfix">
                       <div class="container">
                          @if(count($category->subcategories)>0)
                          <div class="row">
                             <div class="col-md-9">
                                <div class="row">
                                   @foreach ($category->subcategories as $subcategory)
                                   <div class="col-md-4 col-lg-4 col-sm-4">
                                      <h2 class="sub-menu-head title"><a href="{{ route('products.subcategory', $subcategory->slug) }}">{{ $subcategory->getTranslation('name') }}</a> </h2>
                                      <ul class="sub-menu-lists">
                                         @php $i=0; @endphp
                                         @foreach ($subcategory->subsubcategories as $subsubcategory)
                                         @php if($i < 5){ @endphp
                                         <li> <i class="la la-arrow-circle-right"></i> <a href="{{ route('products.subsubcategory', $subsubcategory->slug) }}">{{ $subsubcategory->getTranslation('name') }}</a></li>
                                         @php  } $i++;  @endphp
                                         @endforeach
                                         @php if(count($subcategory->subsubcategories) > 6){   @endphp
                                         <div id="menu_div_{{$subcategory->id}}" style="display:none;">
                                            @php $j=0; @endphp
                                            @foreach ($subcategory->subsubcategories as $subsubcategory)
                                            @php if($j > 5){ @endphp
                                            <li> <i class="la la-arrow-circle-right"></i> <a href="{{ route('products.subsubcategory', $subsubcategory->slug) }}">{{ $subsubcategory->getTranslation('name') }}</a></li>
                                            @php  } $j++;  @endphp
                                            @endforeach
                                         </div>
                                         <a href="#" id="{{$subcategory->id}}" onclick="show_menu('{{$subcategory->id}}')" class="fs-12" style="font-weight: 600;color: #000;">More <i class="far fa-angle-double-right"></i></a>
                                         @php } @endphp
                                      </ul>
                                   </div>
                                   @endforeach
                                </div>
                             </div>
                             <div class="col-md-3 col-lg-3 col-sm-3 hide">
                                <img src="{{uploaded_asset($category->banner)}}" width="100%;">
                             </div>
                          </div>
                          @endif
                       </div>
                    </div>
                 </li>
                 @endforeach

                <li class="top-level-link" style="float: right;">
                    <a href="{{ route('user.wholesale_customer_registration') }}" class="btn wholesale">{{ translate('Apply For Wholesale') }} <i class="la la-arrow-right"></i></a>
                </li>
             </ul>
          </nav>
       </div>
    </section>

