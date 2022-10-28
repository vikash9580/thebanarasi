<!-- Top Bar -->
 <style>
      .blink {
        animation: blinker 0.6s linear infinite;
        color: #1c87c9;
        font-size: 30px;
        font-weight: bold;
        font-family: sans-serif;
      }
      @keyframes blinker {
        50% {
          opacity: 0;
        }
      }
      .blink-one {
        animation: blinker-one 1s linear infinite;
      }
      @keyframes blinker-one {
        0% {
          opacity: 0;
        }
      }
      .blink-two {
        animation: blinker-two 1.4s linear infinite;
      }
      @keyframes blinker-two {
        100% {
          opacity: 0;
        }
      }
    </style>
<div class="top-navbar">
	<div class="container-fluid">
	    <div class="pl-md-4 px-md-4">
		<div class="row">
			<div class="col-lg-6 col">
				<ul class="list-inline mb-0">
					<li class="list-inline-item">
						<a href="tel:{{ get_setting('contact_phone') }}"><i class="far fa-phone-volume"></i> {{ get_setting('contact_phone') }}</a>
					</li>
					<li class="hide list-inline-item">
						<a href="mailto:{{ get_setting('contact_email')  }}" class="text-reset"><i class="fad fa-envelope-open-text"></i> {{ get_setting('contact_email')  }}</a>
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
						<a href="{{route('orders.track')}}" class="top-bar-item"><i class="fad fa-truck-moving"></i>Track Order</a>
					</li>
			
					<li class="list-inline-item">
						<a href="{{ route('user.registration') }}" class="text-reset py-2 d-inline-block opacity-60"> <i class="fas fa-sign-in-alt"></i>{{ translate('Login')}}</a>
					</li>
					<li class="list-inline-item">
						<a href="{{ route('user.registration') }}" id="compare" class="text-reset py-2 d-inline-block opacity-60"> <i class="fas fa-sync"></i> @include('frontend.partials.compare') </a>
					</li>
					<li class="list-inline-item">
						<a href="{{ route('user.registration') }}" id="wishlist" class="text-reset py-2 d-inline-block opacity-60"> <i class="fad fa-heart"></i> @include('frontend.partials.wishlist') </a>
					</li>
					
					@endauth
				</ul>
			</div>
		</div>
	</div>
</div>
</div>
<!-- END Top Bar -->
<header class="@if(get_setting('header_stikcy') == 'on' && Route::currentRouteName() == 'home' ) main-header-two @else main-header-two  @endif">
	<div class="logo-bar-area">
		<div class="container-fluid">
			<div class="pl-md-4 px-md-4 d-flex align-items-center">
				<div class="col-auto col-xl-2 pl-0 pr-3 d-flex align-items-center">
					<a class="d-block py-5px mr-3 ml-0" href="{{ route('home') }}">
						@php
						$header_logo = get_setting('header_logo');
						@endphp
						@if($header_logo != null)
						<img src="{{ uploaded_asset($header_logo) }}" alt="{{ env('APP_NAME') }}" class="mw-100" height="75">
						@else
						<img src="{{ static_asset('assets/img/logo.png') }}" alt="{{ env('APP_NAME') }}" class="mw-100" height="75">
						@endif
					</a>
					@if(Route::currentRouteName() != 'home')
					<div class="d-none d-xl-block align-self-stretch category-menu-icon-box ml-auto mr-0">
						<div class="h-100 d-flex align-items-center" id="category-menu-icon">
							<div class="dropdown-toggle tog navbar-light h-40px w-50px pl-2  c-pointer">
								<span class="navbar-toggler-icon"></span>
							</div>
						</div>
					</div>
					@endif
				</div>
				<div class="d-lg-none ml-auto mr-0">
					<a class="p-2 d-block text-reset" href="javascript:void(0);" data-toggle="class-toggle" data-target=".front-header-search">
						<i class="las la-search la-flip-horizontal la-2x"></i>
					</a>
				</div>
				<div class="flex-grow-1 front-header-search d-flex align-items-center">
					<div class="position-relative flex-grow-1">
						<form action="{{ route('search') }}" method="GET" class="stop-propagation">
							<div class="d-flex position-relative align-items-center">
								<div class="d-lg-none" data-toggle="class-toggle" data-target=".front-header-search">
									<button class="btn px-2" type="button"><i class="la la-2x la-long-arrow-left"></i></button>
								</div>
								<div class="input-group">
									<input type="text" class="serinput form-control" id="search" name="q" placeholder="{{translate('I am shopping for...')}}" autocomplete="off">
									
									<div class="input-group-append d-none d-lg-block">
										
										<button class="btn serbt" type="submit">
										<i class="la la-search la-flip-horizontal fs-20"></i>
										</button>
									</div>
								</div>
							</div>
						</form>
						<div class="typed-search-box stop-propagation document-click-d-none d-none bg-white rounded shadow-lg position-absolute left-0 top-100 w-100" style="min-height: 200px">
							<div class="search-preloader absolute-top-center">
								<div class="dot-loader"><div></div><div></div><div></div></div>
							</div>
							<div class="search-nothing d-none p-3 text-center fs-16">
							</div>
							<div id="search-content" class="text-left">
							</div>
						</div>
					</div>
				</div>
				<div class="d-none d-lg-none ml-3 mr-0">
					<div class="nav-search-box">
						<a href="#" class="nav-box-link">
							<i class="la la-search la-flip-horizontal d-inline-block nav-box-icon"></i>
						</a>
					</div>
				</div>
				<!--<div class="d-none d-lg-block ml-3 mr-0">-->
				<!--    <div class="" id="compare">-->
				<!--        @include('frontend.partials.compare')-->
				<!--    </div>-->
				<!--</div>-->
				<!--<div class="d-none d-lg-block ml-3 mr-0">-->
				<!--    <div class="" id="wishlist">-->
				<!--        @include('frontend.partials.wishlist')-->
				<!--    </div>-->
				<!--</div>-->
				<div class="d-none d-lg-block  align-self-stretch ml-3 mr-0" data-hover="dropdown">
					<div class="nav-cart-box dropdown h-100" id="cart_items">
						@include('frontend.partials.cart')
					</div>
				</div>
			</div>
		</div>
		@if(Route::currentRouteName() != 'home')
		<div class="hover-category-menu position-absolute w-100 top-100 left-0 right-0 d-none z-3" id="hover-category-menu">
			<div class="container">
				<div class="row gutters-10 position-relative">
					<div class="col-lg-3 position-static">
						@include('frontend.partials.category_menu')
					</div>
				</div>
			</div>
		</div>
		@endif
	</div>
</header>


<header class="dark">
  <div class="container-fluid">
     <div class="pl-md-4 px-md-4">
  <nav role="navigation">
    <a href="javascript:void(0);" class="ic menu" tabindex="1">
      <span class="line"></span>
      <span class="line"></span>
      <span class="line"></span>
    </a>
    <a href="javascript:void(0);" class="ic close"></a>
    <ul class="main-nav">
      <li class="top-level-link">
        <a href="{{ route('home') }}"><span>Home</span></a>      
      </li> 
      
    @foreach (\App\Category::all()->take(9) as $key => $category)
      <li class="top-level-link">
        <a href="{{ route('products.category', $category->slug) }}" class="mega-menu"><span> {{ $category->getTranslation('name') }}</span></a>
        
          @if(count($category->subcategories)>0)
        <div class="sub-menu-block">
          <div class="row">
              <div class="col-md-9">
                  
                <div class="row">
                @foreach ($category->subcategories as $subcategory)
            <div class="col-md-3 col-lg-3 col-sm-3">
              <h2 class="sub-menu-head"><a href="{{ route('products.subcategory', $subcategory->slug) }}">{{ $subcategory->getTranslation('name') }}</a> </h2>
              <ul class="sub-menu-lists">
                   @foreach ($subcategory->subsubcategories as $subsubcategory)
                <li><a href="{{ route('products.subsubcategory', $subsubcategory->slug) }}">{{ $subsubcategory->getTranslation('name') }}</a></li>
                 @endforeach
                
              </ul>           
            </div>
              @endforeach
              
            </div>
              </div>
            
            <div class="col-md-3 col-lg-3 col-sm-3 hide">
              <img src="{{ uploaded_asset($category->icon) }}" width="100%;">
            </div>
          </div>
          
          <!--<div class="row banners-area">-->
          <!--  <div class="col-md-6 col-lg-6 col-sm-6">-->
          <!--    <img src="https://thebanarasisaree.com/public/uploads/all/ffIa4MRgKu0xW2A3CqEKQy3loTXRVZsf7Pw1OcmG.jpeg" width="100%;">-->
          <!--  </div>-->
          <!--  <div class="col-md-6 col-lg-6 col-sm-6">-->
          <!--    <img src="https://thebanarasisaree.com/public/uploads/all/H6wRblMANtdSaccBDx5qkWtAmsgMlQAbJfbfLJBF.jpegcategory-menu-icon" width="100%;">-->
          <!--  </div>-->
          <!--</div>-->
          
        </div>
           @endif
      </li>
       @endforeach
    
    
      <li class="top-level-link" style="float: right;">
          
            <a href="{{ route('user.wholesale_customer_registration') }}" class="btn wholesale">
                            {{ translate('Apply For Wholesale') }}
                        </a>
      </li>
    </ul> 
  </nav>
  </div>
</div>
</header>  

