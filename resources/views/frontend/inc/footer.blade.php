<section class="footer">
     <div class="footer-middle">
        <div class="container-fluid">
          <div class="px-2 py-4 px-md-4 py-md-3">
            <div class="row">
                <div class="col-lg-3 text-md-left">
                    <div class="mt-4">
                        <a href="{{ route('home') }}" class="d-block">
                            @if(get_setting('footer_logo') != null)
                            <img class="lazyload log" src="{{ static_asset('assets/img/placeholder-rect.jpg') }}" data-src="{{ uploaded_asset(get_setting('footer_logo')) }}" alt="{{ env('APP_NAME') }}" height="100">
                            @else
                            <img class="lazyload" src="{{ static_asset('assets/img/placeholder-rect.jpg') }}" data-src="{{ static_asset('assets/img/logo.png') }}" alt="{{ env('APP_NAME') }}" height="100">
                            @endif
                        </a>
                        <div class="my-3">
                            @php
                            echo get_setting('about_us_description');
                            @endphp
                        </div>
                        <div class="d-inline-block d-md-block">
                            <!--     <form class="form-inline" method="POST" action="{{ route('subscribers.store') }}">
                                @csrf
                                <div class="form-group mb-0">
                                    <input type="email" class="form-control" placeholder="{{ translate('Your Email Address') }}" name="email" required>
                                </div>
                                <button type="submit" class="btn btn-primary">
                                {{ translate('Subscribe') }}
                                </button>
                            </form> -->

                             <ul class="list-inline my-3 my-md-0 social colored">
                        @if ( get_setting('facebook_link') !=  null )
                        <li class="list-inline-item">
                            <a href="{{ get_setting('facebook_link') }}" target="_blank" class="facebook"><i class="lab la-facebook-f"></i></a>
                        </li>
                        @endif
                        @if ( get_setting('twitter_link') !=  null )
                        <li class="list-inline-item">
                            <a href="{{ get_setting('twitter_link') }}" target="_blank" class="twitter"><i class="lab la-twitter"></i></a>
                        </li>
                        @endif
                        @if ( get_setting('instagram_link') !=  null )
                        <li class="list-inline-item">
                            <a href="{{ get_setting('instagram_link') }}" target="_blank" class="instagram"><i class="lab la-instagram"></i></a>
                        </li>
                        @endif
                        @if ( get_setting('youtube_link') !=  null )
                        <li class="list-inline-item">
                            <a href="{{ get_setting('youtube_link') }}" target="_blank" class="youtube"><i class="lab la-youtube"></i></a>
                        </li>
                        @endif
                        @if ( get_setting('linkedin_link') !=  null )
                        <li class="list-inline-item">
                            <a href="{{ get_setting('linkedin_link') }}" target="_blank" class="linkedin"><i class="lab la-linkedin-in"></i></a>
                        </li>
                        @endif
                    </ul>

                            <button  onclick="contact_us()" class="btn call">
                            Contact Us
                            </button>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-4">
                    <div class="text-md-left mt-4">
                        <h4 class="tit">
                        {{ get_setting('widget_one') }}
                        </h4>
                        <ul class="list-unstyled">
                            @if ( get_setting('widget_one_labels') !=  null )
                            @foreach (json_decode( get_setting('widget_one_labels'), true) as $key => $value)
                            <li class="mb-2">
                                <a href="{{ json_decode( get_setting('widget_one_links'), true)[$key] }}">
                                    <i class="far fa-angle-double-right"></i>
                                    {{ $value }}
                                </a>
                            </li>
                            @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3  col-md-4">
                    <div class="text-md-left mt-4">
                        <h4 class="tit">
                        {{ translate('My Account') }}
                        </h4>
                        <ul class="list-unstyled">
                            @if (Auth::check())
                            <li class="mb-2">
                                <a class="hov-opacity-100 text-reset" href="{{ route('logout') }}">
                                   <i class="far fa-angle-double-right"></i>
                                    {{ translate('Logout') }}
                                </a>
                            </li>
                            @else
                            <li class="mb-2">
                                <a class="hov-opacity-100 text-reset" href="{{ route('user.login') }}">
                                    <i class="far fa-angle-double-right"></i> {{ translate('Login') }}
                                </a>
                            </li>
                            @endif
                            <li class="mb-2">
                                <a class="hov-opacity-100 text-reset" href="{{ route('purchase_history.index') }}">
                                    <i class="far fa-angle-double-right"></i>  {{ translate('Order History') }}
                                </a>
                            </li>
                            <li class="mb-2">
                                <a class="hov-opacity-100 text-reset" href="{{ route('wishlists.index') }}">
                                   <i class="far fa-angle-double-right"></i> {{ translate('My Wishlist') }}
                                </a>
                            </li>
                            <li class="mb-2">
                                <a class="hov-opacity-100 text-reset" href="{{ route('orders.track') }}">
                                   <i class="far fa-angle-double-right"></i> {{ translate('Track Order') }}
                                </a>
                            </li>
                            @if (\App\Addon::where('unique_identifier', 'affiliate_system')->first() != null && \App\Addon::where('unique_identifier', 'affiliate_system')->first()->activated)
                            <li class="mb-2">
                                <a class="hov-opacity-100 text-light" href="{{ route('affiliate.apply') }}"><i class="la la-angle-right" aria-hidden="true"></i>{{ translate('Be an affiliate partner')}}</a>
                            </li>
                            @endif
                        </ul>
                    </div>
                    @if (get_setting('vendor_system_activation') == 1)
                    <div class="text-md-left mt-4">
                        <h4 class="tit">
                        {{ translate('Be a Seller') }}
                        </h4>
                        <a href="{{ route('shops.create') }}" class="btn call">
                            {{ translate('Apply Now') }}
                        </a>
                    </div>
                    @endif
                    <!--<div class="text-md-left mt-4">-->
                    <!--    <h4 class="tit">-->
                    <!--        {{ translate('Be a Wholesale') }}-->
                    <!--    </h4>-->
                    <!--    <a href="{{ route('user.wholesale_customer_registration') }}" class="btn call">-->
                    <!--        {{ translate('Apply For Wholesale') }}-->
                    <!--    </a>-->
                    <!--</div>-->
                </div>

                 <div class="col-lg-3 ml-xl-auto col-md-4 mr-0">
                    <div class="text-md-left mt-4">
                        <h4 class="tit">
                        {{ translate('Contact Info') }}
                        </h4>
                        <ul class="list-unstyled" style="-webkit-column-count:1; column-count:1;">
                            <li class="mb-2">
                                <span class="d-flex"><i class="fal fa-map-marker-alt"></i> {{ get_setting('contact_address') }}</span>
                            </li>
                            <li class="mb-2">
                                <!-- <span class="d-block"> {{translate('Phone')}}:</span> -->
                                <span class="d-flex"><i class="fas fa-phone-office"></i> {{ get_setting('contact_phone') }}</span>
                            </li>
                            <li class="mb-2">
                                <!-- <span class="d-block"> {{translate('Email')}}:</span> -->
                                <span class="d-flex"><i class="la la-envelope-open"></i>
                                    <a href="mailto:{{ get_setting('contact_email') }}" class="text-reset">{{ get_setting('contact_email')  }}</a>
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
  <div class="shopping_info">
        <div class="container-fluid">
                 <div class="px-2 py-4 px-md-4 py-md-3">
                     <div class="row justify-content-center">
                            <div class="col-md-4">
                                <div class="icon_box icon_box_style2">
                                    <div class="icon">
                                        <i class="fa fa-truck" aria-hidden="true"></i>
                                    </div>
                                    <div class="icon_box_content">
                                    	<h5>Free Delivery</h5>
                                        <p>Get free delivery. No minimum order value.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="icon_box icon_box_style2">
                                    <div class="icon">
                                      <i class="fas fa-exchange"></i>
                                    </div>
                                    <div class="icon_box_content">
                                    	<h5>3 Day Returns Guarantee</h5>
                                        <p>Returns Window, Actions Possible and Conditions (if any).</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="icon_box icon_box_style2">
                                    <div class="icon">
                                       <i class="far fa-user-headset"></i>
                                    </div>
                                    <div class="icon_box_content">
                                    	<h5>24X7 Online Support</h5>
                                        <p>24X7 support is a kind of support that is available throughout the day.</p>
                                    </div>
                                </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- FOOTER -->
  <div class="modal fade" id="contact_us" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-zoom" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="exampleModalLabel">Contact us Form</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="form-default" role="form" action="{{ route('subscribers.contact_us') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="p-3">
                             <div class="row">
                                <div class="col-md-2">
                                    <label>Email</label>
                                </div>
                                <div class="col-md-10">
                                    <input type="email" class="form-control mb-3" placeholder="Your Email" name="email" value="" required>
                                </div>
                            </div>
                             <div class="row">
                                <div class="col-md-2">
                                    <label>Subject</label>
                                </div>
                                <div class="col-md-10">
                                    <input type="text" class="form-control mb-3" placeholder="Subject" name="subject" value="" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <label>Message</label>
                                </div>
                                <div class="col-md-10">
                                    <textarea class="form-control textarea-autogrow mb-3" placeholder="{{ translate('Your Message') }}" rows="3" name="message" required></textarea>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-2">
                                    <label>{{ translate('Phone')}}</label>
                                </div>
                                <div class="col-md-10">
                                    <input type="text" class="form-control mb-3" placeholder="{{ translate('Your phone number')}}" name="phone" value="" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">{{  translate('Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<footer class="copyright pt-3 pb-7 pb-xl-3">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-9">
                <div class="text-center text-md-left">
                    @php
                    echo get_setting('frontend_copyright_text');
                    @endphp
                </div>
            </div>
          <div class="col-md-3 text-right">
                <ul class="list-inline mb-0">
                    @if ( get_setting('payment_method_images') !=  null )
                    @foreach (explode(',', get_setting('payment_method_images')) as $key => $value)
                    <li class="list-inline-item">
                        <img src="{{ uploaded_asset($value) }}" height="30">
                    </li>
                    @endforeach
                    @endif
                </ul>
          </div>
        </div>
    </div>
</footer>

@if(Route::currentRouteName() =='home')

<div class="footer-last">
    <div class="container">
<h5>Most Searched Brands on thebanarasisaree.com</h5>
    <ul>
        <li><a href="#">Pure Organza Saree</a></li>
        <li><a href="#">Pure Muga Saree</a></li>
        <li><a href="#">Pure Katan</a></li>
        <li><a href="#">Linen Saree</a></li>
        <li><a href="#">Chiffon Saree</a></li>
        <li><a href="#">Georgette Sarees</a></li>
        <li><a href="#">Cotton Silk Saree</a></li>
        <li><a href="#">Satin Silk Saree</a></li>
        <li><a href="#">Semi-Kattan Silk Dupatta</a></li>
        <li><a href="#">Banarasi Silk Dupatta</a></li>
    </ul>

    <h5>Saree - Fabulous Indian Banarasi Silk Sarees Styles for Women</h5>
    <p>Banarasi Silk Sarees have been an integral part of every North Indian brides trousseau since time immemorial. Varanasi, being one of the oldest places in the world has had a pivotal role in producing the best Handloom Banarasi Sari and caters to the persistent demand for even international cutomers of Banarasi Saris Online US, Canada, Dubai,etc.
       Whenever there is a mention of ethnic bridal wear, this Handwoven Traditional Saree is the first attire that comes to our mind. Nowadays, with a plethora of options available in Handwoven Traditional Saris, with cutwork, or embroidered, or Tissue Sarees or even a Designer Banarasi Silk Saree Online, makes this Popular Banarasi Silk Saree an indispensable part of any bridal trousseau.
    </p>
 </div>
</div>

@endif

@if(Route::currentRouteName() =='search')

<div class="footer-last">
    <div class="container">
        @php $url=url()->full();
            $conta=preg_match("~\bcategory\b~",$url);
        @endphp
        @if(isset($product))
    <h5>@if($conta == 0) {{$product->name}} @else {{$product->category->name}}  @endif</h5>
   @if($conta == 0) {!!$product->description!!} @else {!!$product->description!!}  @endif
    @endif
 </div>
</div>

@endif

<script type="text/javascript">
    function contact_us(){
        $('#contact_us').modal('show');
    }
    </script>


<div class="aiz-mobile-bottom-nav d-xl-none fixed-bottom bg-white shadow-lg border-top">
    <div class="d-flex justify-content-around align-items-center">
        <a href="{{ route('home') }}" class="text-reset flex-grow-1 text-center border-right {{ areActiveRoutes(['home'],'bg-soft-primary')}}">
            <i class="las la-home la-2x"></i>
        </a>
        <a href="{{ route('categories.all') }}" class="text-reset flex-grow-1 text-center border-right {{ areActiveRoutes(['categories.all'],'bg-soft-primary')}}">
            <span class="d-inline-block position-relative px-2">
                <i class="las la-list-ul la-2x"></i>
            </span>
        </a>
        <a href="{{ route('cart') }}" class="text-reset flex-grow-1 text-center py-2 border-right {{ areActiveRoutes(['cart'],'bg-soft-primary')}}">
      <span class="d-inline-block position-relative px-2">
      <i class="las la-shopping-cart la-2x"></i>
       @if(isset(Auth::user()->id))
        <span class="badge badge-circle badge-primary cart-count" id="cart_items_sidenav">{{ App\Models\Cart::where('user_id',Auth::user()->id)->get()->count()}}</span>
      @else
         <span class="badge badge-circle badge-primary cart-count" id="cart_items_sidenav">0</span>
      @endif
      </span>
      </a>

      <a href="{{ route('wishlists.index') }}" class="text-reset flex-grow-1 text-center border-right {{ areActiveRoutes(['categories.all'],'bg-soft-primary')}}">
        <span class="d-inline-block position-relative px-2">
            <i class="la la la-heart-o la-2x"></i>
        </span>
    </a>

        @if (Auth::check())
            @if(isAdmin())
                <a href="{{ route('admin.dashboard') }}" class="text-reset flex-grow-1 text-center">
                    <span class="avatar avatar-sm d-block mx-auto">
                        @if(Auth::user()->photo != null)
                            <img src="{{ custom_asset(Auth::user()->avatar_original)}}">
                        @else
                            <img src="{{ static_asset('assets/img/avatar-place.png') }}">
                        @endif
                    </span>
                </a>
            @else
                <a href="javascript:void(0)" class="text-reset flex-grow-1 text-center mobile-side-nav-thumb" data-toggle="class-toggle" data-target=".aiz-mobile-side-nav">
                    <span class="avatar avatar-sm d-block mx-auto">
                        @if(Auth::user()->photo != null)
                            <img src="{{ custom_asset(Auth::user()->avatar_original)}}">
                        @else
                            <img src="{{ static_asset('assets/img/avatar-place.png') }}">
                        @endif
                    </span>
                </a>
            @endif
        @else
            <a href="{{ route('user.registration') }}" class="text-reset flex-grow-1 text-center py-2">
                <span class="avatar avatar-sm d-block mx-auto">
                    <img src="{{ static_asset('assets/img/avatar-place.png') }}">
                </span>
            </a>
        @endif
    </div>
</div>
@if (Auth::check() && !isAdmin())
    <div class="aiz-mobile-side-nav collapse-sidebar-wrap sidebar-xl d-xl-none z-1035">
        <div class="overlay dark c-pointer overlay-fixed" data-toggle="class-toggle" data-target=".aiz-mobile-side-nav" data-same=".mobile-side-nav-thumb"></div>
        <div class="collapse-sidebar bg-white">
            @include('frontend.inc.user_side_nav')
        </div>
    </div>
@endif
<link href="https://kit-pro.fontawesome.com/releases/v5.15.1/css/pro.min.css" rel="stylesheet">
<div class="get">
  <a href="{{route('user.request_sample')}}"> Fabric Sample <i class="la la-arrow-right"></i></a>
</div>
