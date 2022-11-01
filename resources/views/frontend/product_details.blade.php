@extends('frontend.layouts.app')
@section('meta_title'){{ $detailedProduct->meta_title }}@stop
@section('meta_description'){{ $detailedProduct->meta_description }}@stop
@section('meta_keywords'){{ $detailedProduct->tags }}@stop
@section('meta')
    <!-- Schema.org markup for Google+ -->
    <meta itemprop="name" content="{{ $detailedProduct->meta_title }}">
    <meta itemprop="description" content="{{ $detailedProduct->meta_description }}">
    <meta itemprop="image" content="{{ uploaded_asset($detailedProduct->meta_img) }}">
    <!-- Twitter Card data -->
    <meta name="twitter:card" content="product">
    <meta name="twitter:site" content="@publisher_handle">
    <meta name="twitter:title" content="{{ $detailedProduct->meta_title }}">
    <meta name="twitter:description" content="{{ $detailedProduct->meta_description }}">
    <meta name="twitter:creator" content="@author_handle">
<meta name="twitter:image" content="{{ uploaded_asset($detailedProduct->meta_img) }}">
<meta name="twitter:data1" content="{{ single_price($detailedProduct->unit_price) }}">
<meta name="twitter:label1" content="Price">
<!-- Open Graph data -->
<meta property="og:title" content="{{ $detailedProduct->meta_title }}" />
<meta property="og:type" content="og:product" />
<meta property="og:url" content="{{ route('product', $detailedProduct->slug) }}" />
<meta property="og:image" content="{{ uploaded_asset($detailedProduct->meta_img) }}" />
<meta property="og:description" content="{{ $detailedProduct->meta_description }}" />
<meta property="og:site_name" content="{{ get_setting('meta_title') }}" />
<meta property="og:price:amount" content="{{ single_price($detailedProduct->unit_price) }}" />
<meta property="product:price:currency" content="{{ \App\Currency::findOrFail(\App\BusinessSetting::where('type', 'system_default_currency')->first()->value)->code }}" />
<meta property="fb:app_id" content="{{ env('FACEBOOK_PIXEL_ID') }}">
@endsection

<style>
    .cards {
    -webkit-box-shadow: 0 0 13px 0 rgb(82 63 105 / 5%);
    box-shadow: 0 0 13px 0 rgb(82 63 105 / 5%);
    margin-bottom: 10px;
}

.pt-user {
    padding-top: 0px !important;
}

.cart-count {
    top: 35px !important;
}

.cards {
    position: relative;
    display: -ms-flexbox;
    display: flex;
    -ms-flex-direction: column;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: #fff;
    background-clip: border-box;
    border-radius: 0.25rem;
}
.cards .card-headers {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    color: #fff;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    -webkit-box-pack: justify;
    -ms-flex-pack: justify;
    justify-content: space-between;
    position: relative;
    padding: 10px 25px 2px;
    border-bottom: 1px solid #dddddd;
    min-height: 40px;
    border-top-left-radius: 4px;
    border-top-right-radius: 4px;
    background-color: transparent;
}
.card-headers:first-child {
    border-radius: calc(0.25rem - 1px) calc(0.25rem - 1px) 0 0;
}
.cards .card-bodys{
    padding: 12px 25px;
    border-radius: 4px;
}
.icn-arrow{
        color: #333;
    font-size: 20px;
    margin-top: -5px;
}
.cards .card-bodys p{
  margin-bottom: 5px !important;
}

</style>
@section('content')
<link rel="stylesheet" href="{{ static_asset('assets/css/main.css') }}">
<section class="mb-4 pt-3">
    <div class="container">
        <div class="bg-white shadow-sm rounded p-3">
            <div class="row">
                <div class="col-xl-5 col-lg-6">
                    <div class="sticky-top z-3 row gutters-10 flex-row-reverse">
                        @php
                        $photos = explode(',',$detailedProduct->photos);
                        @endphp

                        <div class="imgBox">
                            <div class="absolute-top-wish">
                                <a href="javascript:void(0)" onclick="addToWishList({{ $detailedProduct->id }})"  data-toggle="tooltip" data-title="{{ translate('Add to wishlist') }}" data-placement="left">
                                <i class="la la la-heart-o"></i>
                                </a>
                              </div>
                            <img src="{{ uploaded_asset($photos[0]) }}"  data-origin="{{ uploaded_asset($photos[0]) }}" id="show-img">
                        </div>

                       <div class="small-img">
                            <img src="../public/assets/img/online_icon_right@2x.png" class="icon-left" alt="" id="prev-img">
                            <div class="small-container">
                                <div id="small-img-roll">
                                    @foreach ($photos as $key => $photo)
                                    <img src="{{ uploaded_asset($photo) }}"   class="show-small-img" alt="">
                                    @endforeach
                                </div>
                            </div>

                            <img src="../public/assets/img/online_icon_right@2x.png" class="icon-right" alt="" id="next-img">
                        </div>
                    </div>
                </div>
                <div class="col-xl-7 col-lg-6">
                    <div class="text-left">
                        @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                        <strong>Success!</strong> {{ $message }}
                        </div>
                        @endif
                        <h1 class="mb-2 pt-3">
                        {{ $detailedProduct->getTranslation('name') }}
                        </h1>
                        <div class="row align-items-center">
                            <div class="col-4">
                                @php
                                $total = 0;
                                $total += $detailedProduct->reviews->count();
                                @endphp
                                <!--<span class="rating">-->
                                <!--    {{ renderStarRating($detailedProduct->rating) }}-->
                                <!--</span>-->
                                <!--<span class="ml-1 opacity-90">({{ $total }} {{ translate('reviews') }})</span>-->
                            </div>
                            <div class="col-12">
                                @php
                                $qty = 0;
                                if($detailedProduct->variant_product){
                                foreach ($detailedProduct->stocks as $key => $stock) {
                                $qty += $stock->qty;
                                }
                                }
                                else{
                                $qty = $detailedProduct->current_stock;
                                }
                                @endphp
                                @if ($qty > 0)
                                <span class="badge badge-md badge-inline badge-pill badge-success">{{ translate('In stock') }}</span>
                                @else
                                <span class="badge badge-md badge-inline badge-pill badge-danger">{{ translate('Out of stock') }}</span>
                                @endif
                            </div>
                        </div>
                        <hr>
                        @if (home_price($detailedProduct->id) != home_discounted_price($detailedProduct->id))
                        <div class="row no-gutters mt-3">
                            <!--<div class="col-2">-->
                            <!--    <div class="opacity-90 mt-2">{{ translate('Price') }}:</div>-->
                            <!--</div>-->

                            <div class="col-4 hide">
                                <div class="">

                                    @if (Auth::check())
                                    @if (Auth::user()->is_wholesale_customer == 1 && Auth::user()->validate_wholesale_customer == 1)

                                    <strong class="h3">
                                    {{ home_discounted_base_price_wholesale($detailedProduct->id) }}
                                    </strong>


                                    <span class="" style="color:green;">/
                                        @php
                                        $flash_deal_product_details = \App\FlashDeal::where('flash_deals.status', 1)->where('flash_deals.featured', 1)->where('flash_deal_products.product_id', $detailedProduct->id)->leftJoin('flash_deal_products', 'flash_deals.id', '=', 'flash_deal_products.flash_deal_id')->first();

                                        @endphp

                                        @if (!empty($flash_deal_product_details['discount']))
                                        @if ($flash_deal_product_details['wholesale_discount_type'] == 'percent') {{ $flash_deal_product_details['wholesale_discount'] }}% Flash Sale Off @endif
                                        @if ($flash_deal_product_details['wholesale_discount_type'] == 'amount') {{ $flash_deal_product_details['wholesale_discount'] }}Rs Flash Sale Off @endif
                                        @else
                                        @if ($detailedProduct->unit != null)
                                        @if ($detailedProduct->wholesale_discount_type == 'percent'){{ $detailedProduct->wholesale_discount }}%-Off @endif
                                        @if ($detailedProduct->wholesale_discount_type == 'amount'){{ $detailedProduct->wholesale_discount }}Rs-Off @endif
                                        @endif

                                        @endif
                                    </span>



                                    @else

                                    <strong class="h3">
                                    {{ home_discounted_price($detailedProduct->id) }}
                                    </strong>


                                    <span class="opacity-90" style="color:green;">/
                                        @php
                                        $flash_deal_product_details = \App\FlashDeal::where('flash_deals.status', 1)->where('flash_deals.featured', 1)->where('flash_deal_products.product_id', $detailedProduct->id)->leftJoin('flash_deal_products', 'flash_deals.id', '=', 'flash_deal_products.flash_deal_id')->first();

                                        @endphp

                                        @if (!empty($flash_deal_product_details['discount']))
                                        @if ($flash_deal_product_details['discount_type'] == 'percent') {{ $flash_deal_product_details['discount'] }}% Flash Sale Off @endif
                                        @if ($flash_deal_product_details['discount_type'] == 'amount') {{ $flash_deal_product_details['discount'] }}Rs Flash Sale Off @endif
                                        @else
                                        @if ($detailedProduct->unit != null)
                                        @if ($detailedProduct->discount_type == 'percent'){{ $detailedProduct->discount }}%-Off @endif
                                        @if ($detailedProduct->discount_type == 'amount'){{ $detailedProduct->discount }}Rs-Off @endif
                                        @endif

                                        @endif
                                    </span>

                                    @endif


                                    @else

                                    <strong class="h3 fw-600">
                                    {{ home_discounted_price($detailedProduct->id) }}
                                    </strong>


                                    <span class="opacity-90" style="color:green;">/
                                        @php
                                        $flash_deal_product_details = \App\FlashDeal::where('flash_deals.status', 1)->where('flash_deals.featured', 1)->where('flash_deal_products.product_id', $detailedProduct->id)->leftJoin('flash_deal_products', 'flash_deals.id', '=', 'flash_deal_products.flash_deal_id')->first();

                                        @endphp

                                        @if (!empty($flash_deal_product_details['discount']))
                                        @if ($flash_deal_product_details['discount_type'] == 'percent') {{ $flash_deal_product_details['discount'] }}% Flash Sale Off @endif
                                        @if ($flash_deal_product_details['discount_type'] == 'amount') {{ $flash_deal_product_details['discount'] }}Rs Flash Sale Off @endif
                                        @else
                                        @if ($detailedProduct->unit != null)
                                        @if ($detailedProduct->discount_type == 'percent'){{ $detailedProduct->discount }}%-Off @endif
                                        @if ($detailedProduct->discount_type == 'amount'){{ $detailedProduct->discount }}Rs-Off @endif
                                        @endif

                                        @endif
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-5">
                                <div class="del">
                                    @if (Auth::check())
                                    @if (Auth::user()->is_wholesale_customer == 1 && Auth::user()->validate_wholesale_customer == 1)
                                    <del>
                                    {{ home_base_price_wholesale($detailedProduct->id) }}
                                    </del>
                                    @if ($detailedProduct->unit != null)
                                    <span>/{{ $detailedProduct->getTranslation('unit') }}</span>
                                    @endif


                                    @else
                                    <del>
                                    {{ home_price($detailedProduct->id) }}
                                    </del>
                                    @if ($detailedProduct->unit != null)
                                    <span>/{{ $detailedProduct->getTranslation('unit') }}</span>
                                    @endif


                                    @endif
                                    @else

                                    <del>
                                    {{ home_price($detailedProduct->id) }}
                                    </del>
                                    @if ($detailedProduct->unit != null)
                                    <span>/{{ $detailedProduct->getTranslation('unit') }}</span>
                                    @endif
                                    @endif
                                </div>
                            </div>


                            <!--<div class="col-2">-->
                            <!--    <div class="opacity-90">{{ translate('Discount Price') }}:</div>-->
                            <!--</div>-->

                        </div>
                        @else
                        <div class="row no-gutters mt-3">
                            <div class="col-2">
                                <div class="opacity-90">{{ translate('Price') }}:</div>
                            </div>
                            <div class="col-10">
                                <div class="price">
                                    <strong class="h2 fw-600 text-primary">
                                    {{ home_discounted_price($detailedProduct->id) }}
                                    </strong>
                                    <span class="opacity-90">/{{ $detailedProduct->getTranslation('unit') }}</span>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if (\App\Addon::where('unique_identifier', 'club_point')->first() != null &&
                            \App\Addon::where('unique_identifier', 'club_point')->first()->activated &&
                            $detailedProduct->earn_point > 0)
                        <div class="row no-gutters mt-4">
                            <div class="col-2">
                                <div class="opacity-90">{{ translate('Club Point') }}:</div>
                            </div>
                            <div class="col-10">
                                <div class="d-inline-block rounded px-2 bg-soft-primary border-soft-primary border">
                                    <span class="strong-700">{{ $detailedProduct->earn_point }}</span>
                                </div>
                            </div>
                        </div>
                        @endif
                        <hr>
                        <form id="option-choice-form">
                            @csrf
                            <input type="hidden" name="id" value="{{ $detailedProduct->id }}">
                            @if ($detailedProduct->choice_options != null)
                            @foreach (json_decode($detailedProduct->choice_options) as $key => $choice)
                            <div class="row no-gutters">
                                <div class="col-2">
                                    <div class="opacity-90 mt-2 ">{{ \App\Attribute::find($choice->attribute_id)->getTranslation('name') }}:</div>
                                </div>
                                <div class="col-10">
                                    <div class="aiz-radio-inline">
                                        @foreach ($choice->values as $key => $value)
                                        <label class="aiz-megabox pl-0 mr-2">
                                            <input
                                            type="radio"
                                            name="attribute_id_{{ $choice->attribute_id }}"
                                            value="{{ $value }}"
                                            @if ($key == 0) checked @endif
                                            >
                                            <span class="aiz-megabox-elem  d-flex align-items-center justify-content-center py-2 px-3">
                                                {{ $value }}
                                            </span>
                                        </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @endif
                            @if (count(json_decode($detailedProduct->colors)) > 0)
                            <div class="row no-gutters">
                                <div class="col-2">
                                    <div class="opacity-90 mt-2">{{ translate('Color') }}:</div>
                                </div>
                                <div class="col-10">
                                    <div class="aiz-radio-inline">
                                        @foreach (json_decode($detailedProduct->colors) as $key => $color)
                                        <label class="aiz-megabox pl-0 mr-2" data-toggle="" data-title="{{ \App\Color::where('code', $color)->first()->name }}">
                                            <input type="radio" name="color" value="{{ $color }}"
                                            @if ($key == 0) checked @endif
                                            >
                                            <span class="aiz-megabox-elem rounded d-flex align-items-center justify-content-center p-1 mb-2">
                                                <span class="size-30px d-inline-block rounded" style="background: {{ $color }};" title="{{ \App\Color::where('code', $color)->first()->name }}"></span>
                                            </span>
                                        </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <hr>
                            @endif
                            <!-- Quantity + Add to cart -->
                            <div class="row no-gutters">
                                <div class="col-3">
                                    <div class="opacity-90 mt-2">{{ translate('Quantity') }}:</div>
                                </div>
                                <div class="col-9">
                                    <div class="product-quantity d-flex align-items-center">
                                        <div class="row no-gutters align-items-center aiz-plus-minus mr-3" style="width: 130px;">
                                            <button class="btn col-auto btn-icon btn-sm btn-circle btn-light" type="button" data-type="minus" data-field="quantity" disabled="">
                                            <i class="las la-minus"></i>
                                            </button>
                                            <input type="text" name="quantity" class="col border-0 text-center flex-grow-1 fs-16 input-number" placeholder="1" value="1" min="1" max="10" readonly>
                                            <button class="btn  col-auto btn-icon btn-sm btn-circle btn-light" type="button" data-type="plus" data-field="quantity">
                                            <i class="las la-plus"></i>
                                            </button>
                                        </div>
                                        <div class="avialable-amount opacity-60">(<span id="available-quantity">{{ $qty }}</span> {{ translate('available') }})</div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row no-gutters d-none" id="chosen_price_div">
                                <div class="col-2">
                                    <div class="opacity-90">{{ translate('Total Price') }}:</div>
                                </div>
                                <div class="col-10">
                                    <div class="product-price">
                                        <strong id="chosen_price" class="h4 fw-600">
                                        </strong>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="mt-3">
                            @if ($qty > 0)
                            @if (Auth::check())
                            <button type="button" class="btn btn-soft-primary add-to-cart" onclick="addToCart()">
                            <i class="far fa-shopping-cart"></i>
                            <span class="d-none d-md-inline-block"> {{ translate('Add to cart') }}</span>
                            </button>

                            <button type="button" class="btn btn-primary buy-now" onclick="buyNow()">
                             <i class="la la-inr"></i> {{ translate('Buy Now') }}
                            </button>
                            @else
                            <button type="button" class="btn add-to-cart" onclick="showCheckoutModal()">
                           <i class="far fa-shopping-cart"></i>
                            <span class="d-none d-md-inline-block"> {{ translate('Add to cart') }}</span>
                            </button>

                            <button type="button" class="btn buy-now" onclick="showCheckoutModal()">
                              <i class="la la-inr"></i> {{ translate('Buy Now') }}
                            </button>
                            @endif


                            <button type="button" class="btn call-now"><a href="tel:+91-8177062481">
                            <i class="far fa-phone-volume"></i> {{ translate('Call Now') }}</a>
                            </button>
                            @else
                            <button type="button" class="btn btn-secondary" disabled>
                            <i class="la la-cart-arrow-down"></i> {{ translate('Out of Stock') }}
                            </button>
                            @endif
                            <!-- Add to wishlist button -->
                            <!--<button type="button" class="btn" onclick="addToWishList({{ $detailedProduct->id }})">-->
                            <!--<i class="fad fa-heart"></i> {{ translate('Add to wishlist') }}-->
                            <!--</button>-->
                            <!-- Add to compare button -->
                            <!--<button type="button" class="btn" onclick="addToCompare({{ $detailedProduct->id }})">-->
                            <!--<i class="fas fa-sync"></i> {{ translate('Add to compare') }}-->
                            <!--</button>-->
                            @if (Auth::check() &&
                                \App\Addon::where('unique_identifier', 'affiliate_system')->first() != null &&
                                \App\Addon::where('unique_identifier', 'affiliate_system')->first()->activated &&
                                (\App\AffiliateOption::where('type', 'product_sharing')->first()->status ||
                                    \App\AffiliateOption::where('type', 'category_wise_affiliate')->first()->status) &&
                                Auth::user()->affiliate_user != null &&
                                Auth::user()->affiliate_user->status)
                            @php
                            if(Auth::check()){
                            if(Auth::user()->referral_code == null){
                            Auth::user()->referral_code = substr(Auth::user()->id.Str::random(10), 0, 10);
                            Auth::user()->save();
                            }
                            $referral_code = Auth::user()->referral_code;
                            $referral_code_url = URL::to('/product').'/'.$detailedProduct->slug."?product_referral_code=$referral_code";
                            }
                            @endphp
                            <div class="form-group">
                                <textarea id="referral_code_url" class="form-control" readonly type="text" style="display:none">{{ $referral_code_url }}</textarea>
                            </div>
                            <button type=button id="ref-cpurl-btn" class="btn btn-sm btn-secondary" data-attrcpy="{{ translate('Copied') }}" onclick="CopyToClipboard('referral_code_url')">{{ translate('Copy the Promote Link') }}</button>
                            @endif
                        </div>
                        <hr>
                        <div class="mt-3">
                            <button type="button" class="btn enqry-btn" data-toggle="modal" data-target="#enquirymdl">
                             {{ translate(' Get Wholesale Rate') }} &nbsp; <i class="la la-arrow-right"></i>
                            </button>
                        </div>

                        @php
                        $refund_request_addon = \App\Addon::where('unique_identifier', 'refund_request')->first();
                        $refund_sticker = \App\BusinessSetting::where('type', 'refund_sticker')->first();
                        @endphp
                        @if ($refund_request_addon != null && $refund_request_addon->activated == 1 && $detailedProduct->refundable)
                        <div class="row no-gutters mt-sm-3">
                            <div class="col-2">
                                <div class="opacity-90 mt-2">{{ translate('Refund') }}:</div>
                            </div>
                            <div class="col-10">
                                <a href="{{ route('returnpolicy') }}" target="_blank">
                                    @if ($refund_sticker != null && $refund_sticker->value != null)
                                    <img src="{{ uploaded_asset($refund_sticker->value) }}" height="36">
                                    @else
                                    <img src="{{ static_asset('assets/img/refund-sticker.jpg') }}" height="36">
                                    @endif
                                </a>
                                <a href="{{ route('returnpolicy') }}" class="ml-2" target="_blank">View Policy</a>
                            </div>
                        </div>
                        @endif
                        <div class="row no-gutters mt-sm-3">
                            <div class="col-2">
                                <div class="opacity-90 mt-2">{{ translate('Share') }}:</div>
                            </div>
                            <div class="col-10">
                                <div class="aiz-share"></div>
                            </div>
                        </div>

                        <div class="row no-gutters mt-sm-3">
                           <div class="col-12">
                              <div id="accordion">
                                <div class="cards">
                                    <a class="card-link" data-toggle="collapse"
                                       href="#app" aria-expanded="true" aria-controls="collapseOne" aria-expanded="true" aria-controls="collapseOne">

                                       <div class="card-headers">
                                          <h6 style="color: #333;">Download our App</h6>
                                          <i class="fa fa-angle-down icn-arrow"></i>
                                       </div>
                                    </a>
                                    <div id="app" class="collapse"
                                       data-parent="#accordion">
                                       <div class="card-bodys">
<table width="100%">
<tbody>
<tr>
<td>
<p><a href="https://play.google.com/store/apps/details?id=com.techup.banarasisaree" target="_blank" title="Download Android App" rel="noopener noreferrer"><img  src="{{ static_asset('assets/img/google-playstore.png') }}" alt="Download Android App" width="232" height="90" style="float: none;"></a></p>
</td>
</tr>
</tbody>
</table>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="cards">
                                    <a class="card-link" data-toggle="collapse"
                                       href="#description1" aria-expanded="true" aria-controls="collapseOne">

                                       <div class="card-headers">
                                          <h6 style="color: #333;">Shipping Method & Custom Duty</h6>
                                          <i class="fa fa-angle-down icn-arrow"></i>
                                       </div>
                                    </a>
                                    <div id="description1" class="collapse"
                                       data-parent="#accordion">
                                       <div class="card-bodys">
                                         <p><strong>DOMESTIC SHIPPING</strong></p><p>We ship through Bluedart, Professional couriers, DTDC & Speed post depending on the PIN Code coverage. Transit time will be between 3 to 5 days from the date of dispatch. </p><p><strong>INTERNATIONAL SHIPPING</strong></p><p>International orders are shipped through DHL. Transit time will be between 3 to 5 days from the date of dispatch.</p><p><strong>CUSTOM DUTY </strong></p><p>The shipping cost does not include custom charges & duties levied. Custom duty is dynamic & changes for every country. Any custom duty levied has to be borne by the customer. </p><p></p>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="cards">
                                    <a class="collapsed card-links"
                                       data-toggle="collapse"
                                       href="#description2" aria-expanded="true" aria-controls="collapseOne">
                                       <div class="card-headers">
                                          <h6 style="color: #333;">Cancellation & Return</h6>
                                          <i class="fa fa-angle-down icn-arrow"></i>
                                       </div>
                                    </a>
                                    <div id="description2" class="collapse"
                                       data-parent="#accordion">
                                       <div class="card-bodys">
                                      <div class="gmail_default"><b>Domestic Orders:</b></div>
<div class="gmail_default">
   <ol class="ml-4">
      <li>An order is eligible for<span> </span><span class="il">return</span><span> </span>within <strong>3 days</strong> from the date of delivery.</li>
      <li>Return / Cancellation is not accepted for orders with <strong>custom tailoring</strong> including fall &amp; edging services. </li>
      <li>
         Customers can initiate a<span> </span><span class="il">return</span><span> </span>request on the following circumstances
         <table cellspacing="0" cellpadding="0" border="1" class="mt-3 mb-3">
            <colgroup>
               <col width="215">
               <col width="169">
            </colgroup>
            <tbody>
               <tr>
                  <td><strong> <span class="il">Return</span> Reason</strong></td>
                  <td><strong>Resolution</strong></td>
               </tr>
               <tr>
                  <td>Item is damage / defective</td>
                  <td>Refund / Gift Card</td>
               </tr>
               <tr>
                  <td>Incorrect item delivered</td>
                  <td>Refund / Gift Card</td>
               </tr>
               <tr>
                  <td>Colour different from description</td>
                  <td>Gift card</td>
               </tr>
               <tr>
                  <td>I do not like this material</td>
                  <td>Gift card</td>
               </tr>
            </tbody>
         </table>
      </li>
      <li>Customer has to raise a<span> </span><span class="il">return</span><span> </span>request by sending an email to<span> </span><a href="mailto:info@thebanarasisaree.com." target="_blank" rel="noopener noreferrer">info@thebanarasisaree.com.</a><span> </span>with the order details &amp; the<span> </span><span class="il">return</span><span> </span>reason. Incase of damaged / incorrect item a photograph of the product, the price tag &amp; the packing cover which got delivered is mandatory.</li>
      <li>Our support team will analyse the<span> </span><span class="il">return</span><span> </span>request and <strong>approve</strong> the same. </li>
      <li>Once a<span> </span><span class="il">return</span><span> </span>is approved, the item has to be packed &amp; shipped to the below address.<span> </span><b><i>J 14/178, Kazisadaullapura, Jaitpura, Varanasi, Varanasi, Uttar Pradesh, 221001</i></b></li>
      <li>The products must be<span> </span><span class="il">returned</span><span> </span>in it's original condition, unaltered and unused. The price tag ( and the silk mark tag if applicable ) has to be present. The saree folding has to be intact.</li>
      <li>Reverse pick up is available for damaged / defective items / incorrect item for selected Pin codes.</li>
      <li>Onward & Return logistic cost of Rs. 99/- will be charged on free shipping orders.</li>
      <li>Refund / gift card will be issued after receiving the item and approved by our quality assurance team. Refund amount/ Gift card will include only the cost of product. Any other cost incurred for the order by the company/ customer will not be refunded.</li>
      <li>All the refunds will be credited to the same payment mode through which the order was paid. The refund might take 7 to 10 working days to credit from the date of initiation. </li>
   </ol>
   <div>
      <div class="gmail_default"><b>USA Orders:</b></div>
      <div class="gmail_default">
         <ol class="ml-4">
            <li>An order is eligible for<span> </span><span class="il">return</span><span> </span>within 3 days from the date of delivery</li>
            <li>Return / Cancellation is not accepted<span> </span>for orders with custom tailoring including fall &amp; edging services. </li>
            <li>
               Customers can initiate a<span> </span><span class="il">return</span><span> </span>request on the following circumstances
               <table cellspacing="0" cellpadding="0" border="1" class="mt-3 mb-3">
                  <colgroup>
                     <col width="215">
                     <col width="169">
                  </colgroup>
                  <tbody>
                     <tr>
                        <td><strong><span class="il">Return</span> Reason</strong></td>
                        <td><strong>Resolution</strong></td>
                     </tr>
                     <tr>
                        <td>Item is damage / defective</td>
                        <td>Refund / Gift Card</td>
                     </tr>
                     <tr>
                        <td>Incorrect item delivered</td>
                        <td>Refund / Gift Card</td>
                     </tr>
                  </tbody>
               </table>
            </li>
            <li>Customer has to raise a<span> </span><span class="il">return</span><span> </span>request by sending an email to<span> </span><a href="mailto:info@thebanarasisaree.com." target="_blank" rel="noopener noreferrer">info@thebanarasisaree.com.</a><span> </span>with the order details &amp; the<span> </span><span class="il">return</span><span> </span>reason. Incase of damaged / incorrect item a photograph of the product, the price tag &amp; the packing cover which got delivered is mandatory.</li>
            <li>Our support team will analyse the<span> </span><span class="il">return</span><span> </span>request and approve the same. </li>
            <li>Once a<span> </span><span class="il">return</span><span> </span>is approved, the item has to be packed & shipped to the address which will be given on approval.</li>
            <li>The products must be<span> </span><span class="il">returned</span><span> </span>in its original condition, unaltered and unused. The price tag ( and the silk mark tag if applicable ) has to be present. The saree folding has to be intact.</li>
            <li>Refund / gift card will be issued after receiving the item and approved by our quality assurance team. Refund amount/ Gift card will include only the cost of product. Any other cost incurred for the order by the company/ customer will not be refunded.</li>
            <li>All the refunds will be credited to the same payment mode through which the order was paid. The refund might take 7 to 10 working days to credit from the date of initiation.</li>
         </ol>
         <p><b>Rest of USA & INDIA - Orders:</b></p>
         <p><b>We do not accept returns for orders from countries outside India & USA. </b></p>
      </div>
   </div>
</div>

                                       </div>
                                    </div>
                                 </div>
                                 <div class="cards">
                                    <a class="collapsed card-links"
                                       data-toggle="collapse"
                                       href="#description3" aria-expanded="true" aria-controls="collapseOne">
                                       <div class="card-headers">
                                          <h6 style="color: #333;"> Wash & Care</h6>
                                          <i class="fa fa-angle-down icn-arrow"></i>
                                       </div>
                                    </a>
                                    <div id="description3" class="collapse"
                                       data-parent="#accordion">
                                       <div class="card-bodys">
                                          <div style="text-align: center;">Sarees are always as precious as diamonds in a women's wardrobe. At the same time it requires immense care for it runs the risk of getting ruined through improper storage or wash. Here are some key points you should be aware of when cleaning your sarees.</div>
<br>
<div style="text-align: center;"><span style="text-decoration: underline;"><strong>Saree Care:</strong></span></div>
<p><br><strong>Silk and Silk cotton Sarees:</strong><br>1. Never hand-wash or machine-wash a silk or a silk cotton saree.<br>2. In case the saree gets stained, immediately wipe the stain off with cold water. <br>3. It is advisable to only dry-clean silk and silk cotton sarees.<br>4. Never hang a silk or silk cotton saree to dry in direct sunlight as doing so will cause the colour to fade.<br>5. Don’t keep the saree bundled up as this will result in the threads of the zari/embroidery work getting entangled.<br>6. Store the saree in a light cotton muslin cloth. This will give the saree breathing space and will prevent one saree from sticking to another when kept in a pile.<br>7. Don’t store the saree in a plastic cover as this will cause the gold zari to turn black.<br><br><strong>Cotton Sarees</strong><br>1. Before washing a cotton saree soak the saree in warm water for 20 mins with rock salt. This will prevent the saree from colour bleeding in the subsequent washes.<br>2. Use shampoo or mild detergent to wash the saree. Do not brush the saree vigorously. Gently dip and dry the saree. Do not wring it vigorously; instead, hang it over a water-tap and allow the excess water to drain off.<br>3. It is advisable to starch cotton sarees to ensure that they retain their stiffness and stay stain-free.</p>
<p>4. Hang the saree to dry in a shaded area.Store the saree is an airy cupboard.</p>
<p><b>General Care</b><br>1. It is advised to to do dry clean for the first time. There might be excess dye on the dark coloured sarees which might bleed for the first few washes. However the colour will not fade. <br>2. Dry clean for the first time and gentle hand wash subsequently will reduce the colour bleeding on these sarees significantly<br>3. From the second wash, soak the saree in shampoo or mild detergent and gently dip and dry the saree in a shaded area.<br>4. Exposure to direct sunlight will cause the colour to fade.<br>5. These sarees can be soft ironed after wash.</p>
</div>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="cards">
                                    <a class="collapsed card-links"
                                       data-toggle="collapse"
                                       href="#description4" aria-expanded="true" aria-controls="collapseOne">
                                       <div class="card-headers">
                                          <h6 style="color: #333;"> Need help to order? - Send an enquiry now.</h6>
                                          <i class="fa fa-angle-down icn-arrow"></i>
                                       </div>
                                    </a>
                                    <div id="description4" class="collapse"
                                       data-parent="#accordion">
                                       <div class="card-bodys">
                                           <form>
                                          <div class="p-3">
                                <div class="form-group">
                                    <label>Name <span class="text-primary">*</span></label>
                                    <input type="text" class="form-control" value="" placeholder="Name" name="name" required="">
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" class="form-control" value="" placeholder="Email" name="email">
                                </div>
                                <div class="form-group">
                                    <label>Phone <span class="text-primary">*</span></label>
                                    <input type="text" class="form-control" placeholder="Phone" name="phone" required="">
                                </div>
                                <div class="form-group">
                                    <label>Message</label>
                                    <input type="text" class="form-control mb-3" placeholder="Message" name="message" >
                                </div>
                                    <div class="text-right">
                                      <button type="submit" class="btn btn-primary fw-600">Submit</button>
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
            </div>
        </div>
    </div>
</section>
<section class="mb-4">
    <div class="container">
        <div class="row reverse gutters-10">
            <div class="side col-xl-3" style="display:none;">
                <div class="text-left">
                    <div class="position-relative text-left">
                        @if ($detailedProduct->added_by == 'seller' &&
                            \App\BusinessSetting::where('type', 'vendor_system_activation')->first()->value == 1 &&
                            $detailedProduct->user->seller->verification_status == 1)
                        <div class="absolute-top-right p-2 bg-white z-1">
                            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" viewBox="0 0 287.5 442.2" width="22" height="34">
                                <polygon style="fill:#F8B517;" points="223.4,442.2 143.8,376.7 64.1,442.2 64.1,215.3 223.4,215.3 "/>
                                    <circle style="fill:#FBD303;" cx="143.8" cy="143.8" r="143.8"/>
                                    <circle style="fill:#F8B517;" cx="143.8" cy="143.8" r="93.6"/>
                                    <polygon style="fill:#FCFCFD;" points="143.8,55.9 163.4,116.6 227.5,116.6 175.6,154.3 195.6,215.3 143.8,177.7 91.9,215.3 111.9,154.3
                                        60,116.6 124.1,116.6 "/>
                                    </svg>
                                </div>
                                @endif
                                <!--<div class="fs-15 fs-12 border-bottom">{{ translate('Sold By') }}</div>-->
                                @if ($detailedProduct->added_by == 'seller' &&
                                    \App\BusinessSetting::where('type', 'vendor_system_activation')->first()->value == 1)
                                <a href="{{ route('shop.visit', $detailedProduct->user->shop->slug) }}" class="text-reset d-block fw-600">
                                    {{ $detailedProduct->user->shop->name }}
                                    @if ($detailedProduct->user->seller->verification_status == 1)
                                    <span class="ml-2"><i class="fa fa-check-circle" style="color:green"></i></span>
                                    @else
                                    <span class="ml-2"><i class="fa fa-times-circle" style="color:red"></i></span>
                                    @endif
                                </a>
                                <div class="location opacity-70">{{ $detailedProduct->user->shop->address }}</div>
                                @else
                                <!--<div class="fw-600">{{ env('APP_NAME') }}</div>-->
                                @endif
                                @php
                                $total = 0;
                                $rating = 0;
                                foreach ($detailedProduct->user->products as $key => $seller_product) {
                                $total += $seller_product->reviews->count();
                                $rating += $seller_product->reviews->sum('rating');
                                }
                                @endphp
                                <!--<div class="text-center border rounded p-2 mt-3">-->
                                <!--    <div class="rating">-->
                                <!--        @if ($total > 0)-->
                                <!--            {{ renderStarRating($rating / $total) }}-->
                                <!--        @else-->
                                <!--            {{ renderStarRating(0) }}-->
                                <!--        @endif-->
                                <!--    </div>-->
                                <!--    <div class="opacity-60 fs-12">({{ $total }} {{ translate('customer reviews') }})</div>-->
                                <!--</div>-->
                            </div>
                            @if ($detailedProduct->added_by == 'seller' &&
                                \App\BusinessSetting::where('type', 'vendor_system_activation')->first()->value == 1)
                            <div class="row no-gutters align-items-center border-top">
                                <div class="col">
                                    <a href="{{ route('shop.visit', $detailedProduct->user->shop->slug) }}" class="d-block btn btn-soft-primary rounded-0">{{ translate('Visit Store') }}</a>
                                </div>
                                <div class="col">
                                    <ul class="social list-inline mb-0">
                                        <li class="list-inline-item mr-0">
                                            <a href="{{ $detailedProduct->user->shop->facebook }}" class="facebook" target="_blank">
                                                <i class="lab la-facebook-f opacity-60"></i>
                                            </a>
                                        </li>
                                        <li class="list-inline-item mr-0">
                                            <a href="{{ $detailedProduct->user->shop->google }}" class="google" target="_blank">
                                                <i class="lab la-google opacity-60"></i>
                                            </a>
                                        </li>
                                        <li class="list-inline-item mr-0">
                                            <a href="{{ $detailedProduct->user->shop->twitter }}" class="twitter" target="_blank">
                                                <i class="lab la-twitter opacity-60"></i>
                                            </a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href="{{ $detailedProduct->user->shop->youtube }}" class="youtube" target="_blank">
                                                <i class="lab la-youtube opacity-60"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            @endif
                        </div>
                        <div class="rounded mb-3">
                            <div class="fs-15 p-3 border-bottom fs-16 fw-600">
                                {{ translate('Top Selling Products') }}
                            </div>
                            <div class="p-3">
                                <ul class="list-group list-group-flush">
                                    @foreach (filter_products(\App\Product::where('user_id', $detailedProduct->user_id)->orderBy('num_of_sale', 'desc'))->limit(6)->get() as $key => $top_product)
                                    <li class="py-3 px-0 list-group-item border-light">
                                        <div class="row gutters-10 align-items-center">
                                            <div class="col-5">
                                                <a href="{{ route('product', $top_product->slug) }}" class="d-block text-reset">
                                                    <img
                                                    class="img-fit lazyload  h-xl-80px"
                                                    src="{{ static_asset('assets/img/placeholder.gif') }}"
                                                    data-src="{{ uploaded_asset($top_product->thumbnail_img) }}"
                                                    alt="{{ $top_product->getTranslation('name') }}"
                                                    onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.gif') }}';"
                                                     style="height:300px;">
                                                </a>
                                            </div>
                                            <div class="col-7 text-left">
                                                <h4 class="fs-13 text-truncate-2">
                                                <a href="{{ route('product', $top_product->slug) }}" class="d-block text-reset">{{ $top_product->getTranslation('name') }}</a>
                                                </h4>
                                                <!--<div class="rating rating-sm mt-1">-->
                                                <!--    {{ renderStarRating($top_product->rating) }}-->
                                                <!--</div>-->
                                                @if (Auth::check())
                                                @if (Auth::user()->is_wholesale_customer == 1 && Auth::user()->validate_wholesale_customer == 1)

                                                <div class="mt-2">
                                                    <span class="fs-17 fw-600 text-primary">{{ home_discounted_base_price_wholesale($top_product->id) }}</span>
                                                </div>

                                                @else
                                                <div class="mt-2">
                                                    <span class="fs-17 fw-600 text-primary">{{ home_discounted_base_price($top_product->id) }}</span>
                                                </div>
                                                @endif
                                                @else
                                                <div class="mt-2">
                                                    <span class="fs-17 fw-600 text-primary">{{ home_discounted_base_price($top_product->id) }}</span>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="product col-xl-12">
                        <div class="bg-white mb-3 shadow-sm rounded">
                            <div class="nav border-bottom aiz-nav-tabs">
                                <a href="#tab_default_1" data-toggle="tab" class="p-2 fs-17  text-reset active">{{ translate('Description') }}</a>
                                @if ($detailedProduct->video_link != null)
                                <a href="#tab_default_2" data-toggle="tab" class="p-2 fs-17 text-reset">{{ translate('Video') }}</a>
                                @endif
                                @if ($detailedProduct->pdf != null)
                                <a href="#tab_default_3" data-toggle="tab" class="p-2 fs-17 text-reset">{{ translate('Downloads') }}</a>
                                @endif
                                <a href="#tab_default_4" data-toggle="tab" class="p-2 fs-17 text-reset">{{ translate('Reviews') }}</a>
                            </div>
                            <div class="tab-content pt-0">
                                <div class="tab-pane fade active show" id="tab_default_1" style="height: fit-content;">
                                    <div class="p-4">
                                        <div class="mw-100 overflow-hidden text-left">
                                            <?php echo $detailedProduct->getTranslation('description'); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="tab_default_2">
                                    <div class="p-4">
                                        <div class="embed-responsive embed-responsive-16by9">
                                            @if ($detailedProduct->video_provider == 'youtube' && $detailedProduct->video_link != null)
                                            <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/{{ explode('=', $detailedProduct->video_link)[1] }}"></iframe>
                                            @elseif ($detailedProduct->video_provider == 'dailymotion' && $detailedProduct->video_link != null)
                                            <iframe class="embed-responsive-item" src="https://www.dailymotion.com/embed/video/{{ explode('video/', $detailedProduct->video_link)[1] }}"></iframe>
                                            @elseif ($detailedProduct->video_provider == 'vimeo' && $detailedProduct->video_link != null)
                                            <iframe src="https://player.vimeo.com/video/{{ explode('vimeo.com/', $detailedProduct->video_link)[1] }}" width="500" height="281" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="tab_default_3">
                                    <div class="p-4 text-center ">
                                        <a href="{{ uploaded_asset($detailedProduct->pdf) }}" class="btn btn-primary">{{ translate('Download') }}</a>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="tab_default_4" style="height: fit-content;">
                                    <div class="p-4">
                                        <ul class="list-group list-group-flush">
                                            @foreach ($detailedProduct->reviews as $key => $review)
                                            <li class="media list-group-item d-flex">
                                                <span class="avatar avatar-md mr-3">
                                                    <img
                                                    class="lazyload"
                                                    src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                                    onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';"
                                                    @if ($review->user->avatar_original != null)
                                                    data-src="{{ uploaded_asset($review->user->avatar_original) }}"
                                                    @else
                                                    data-src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                                    @endif
                                                    >
                                                </span>
                                                <div class="media-body text-left">
                                                    <div class="d-flex justify-content-between">
                                                        <h3 class="fs-15 fw-600 mb-0">{{ $review->user->name }}</h3>
                                                        <span class="rating rating-sm">
                                                            @for ($i = 0; $i < $review->rating; $i++)
                                                            <i class="las la-star active"></i>
                                                            @endfor
                                                            @for ($i = 0; $i < 5 - $review->rating; $i++)
                                                            <i class="las la-star"></i>
                                                            @endfor
                                                        </span>
                                                    </div>
                                                    <div class="opacity-60 mb-2">{{ date('d-m-Y', strtotime($review->created_at)) }}</div>
                                                    <p class="comment-text">
                                                        {{ $review->comment }}
                                                    </p>
                                                </div>
                                            </li>
                                            @endforeach
                                        </ul>
                                        @if (count($detailedProduct->reviews) <= 0)
                                        <div class="text-center fs-18 opacity-70">
                                            {{ translate('There have been no reviews for this product yet.') }}
                                        </div>
                                        @endif
                                        @if (Auth::check())
                                        @php
                                        $commentable = false;
                                        @endphp
                                        @foreach ($detailedProduct->orderDetails as $key => $orderDetail)
                                        @if ($orderDetail->order != null &&
                                            $orderDetail->order->user_id == Auth::user()->id &&
                                            $orderDetail->delivery_status == 'delivered' &&
                                            \App\Review::where('user_id', Auth::user()->id)->where('product_id', $detailedProduct->id)->first() == null)
                                        @php
                                        $commentable = true;
                                        @endphp
                                        @endif
                                        @endforeach
                                        @if ($commentable)
                                        <div class="pt-4">
                                            <div class="border-bottom mb-4">
                                                <h3 class="fs-17 fw-600">
                                                {{ translate('Write a review') }}
                                                </h3>
                                            </div>
                                            <form class="form-default" role="form" action="{{ route('reviews.store') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $detailedProduct->id }}">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="" class="text-uppercase c-gray-light">{{ translate('Your name') }}</label>
                                                            <input type="text" name="name" value="{{ Auth::user()->name }}" class="form-control" disabled required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="" class="text-uppercase c-gray-light">{{ translate('Email') }}</label>
                                                            <input type="text" name="email" value="{{ Auth::user()->email }}" class="form-control" required disabled>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="opacity-60">{{ translate('Rating') }}</label>
                                                    <div class="rating rating-input">
                                                        <label>
                                                            <input type="radio" name="rating" value="1">
                                                            <i class="las la-star"></i>
                                                        </label>
                                                        <label>
                                                            <input type="radio" name="rating" value="2">
                                                            <i class="las la-star"></i>
                                                        </label>
                                                        <label>
                                                            <input type="radio" name="rating" value="3">
                                                            <i class="las la-star"></i>
                                                        </label>
                                                        <label>
                                                            <input type="radio" name="rating" value="4">
                                                            <i class="las la-star"></i>
                                                        </label>
                                                        <label>
                                                            <input type="radio" name="rating" value="5">
                                                            <i class="las la-star"></i>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="opacity-60">{{ translate('Comment') }}</label>
                                                    <textarea class="form-control" rows="4" name="comment" placeholder="{{ translate('Your review') }}" required></textarea>
                                                </div>
                                                <div class="text-right">
                                                    <button type="submit" class="btn btn-primary mt-3">
                                                    {{ translate('Submit review') }}
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                        @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="bg-white rounded shadow-sm">
                            <div class="border-bottom p-3">
                                <h3 class="fs-16 fw-600 mb-0">
                                <span class="mr-4">{{ translate('Related products') }}</span>
                                </h3>
                            </div>
                            <div class="p-3">
                                <div class="aiz-carousel gutters-5 half-outside-arrow" data-items="5" data-xl-items="4" data-lg-items="4"  data-md-items="3" data-sm-items="2" data-xs-items="2" data-arrows='true' data-infinite='true'>
                                    @foreach (filter_products(\App\Product::where('subcategory_id', $detailedProduct->subcategory_id)->where('id', '!=', $detailedProduct->id))->limit(6)->get() as $key => $related_product)
                                    <div class="carousel-box">
                                        <div class="aiz-card-box border border-light rounded hov-shadow-md my-2 has-transition">
                                            <div class="">
                                                <a href="{{ route('product', $related_product->slug) }}" class="d-block">
                                                    <img
                                                    class="img-fit lazyload mx-auto"
                                                    src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                                    data-src="{{ uploaded_asset($related_product->thumbnail_img) }}"
                                                    alt="{{ $related_product->getTranslation('name') }}"
                                                    onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';"
                                                    >
                                                </a>
                                            </div>
                                            <div class="p-md-3 p-2 text-left">

                                                <h3 class="fw-600 fs-13 text-truncate-2 lh-1-4 mb-0">
                                                <a href="{{ route('product', $related_product->slug) }}" class="d-block text-reset">{{ $related_product->getTranslation('name') }}</a>
                                                </h3>

                                                <div class="rating">
                                                    <!--{{ renderStarRating($related_product->rating) }}-->
                                                </div>

                                                <div class="info">

                                                    @if (Auth::check())

                                                    @if (Auth::user()->is_wholesale_customer == 1 && Auth::user()->validate_wholesale_customer == 1)

                                                    <span class="fw-700">{{ home_discounted_base_price_wholesale($related_product->id) }}</span>

                                                    @if (home_base_price_wholesale($related_product->id) !=
                                                        home_discounted_base_price_wholesale($related_product->id))
                                                    <del class="fw-600 text-primary mr-1">{{ home_base_price_wholesale($related_product->id) }}</del>
                                                    @endif


                                                    @else

                                                    <span class="fw-700">{{ home_discounted_base_price($related_product->id) }}</span>
                                                    @if (home_base_price($related_product->id) != home_discounted_base_price($related_product->id))
                                                    <del class="fw-600 text-primary mr-1">{{ home_base_price($related_product->id) }}</del>
                                                    @endif

                                                    @endif
                                                    @else

                                                    <span class="fw-700">{{ home_discounted_base_price($related_product->id) }}</span>
                                                    @if (home_base_price($related_product->id) != home_discounted_base_price($related_product->id))
                                                    <del class="fw-600 text-primary mr-1">{{ home_base_price($related_product->id) }}</del>
                                                    @endif


                                                    @endif

                                                </div>

                                                @if (\App\Addon::where('unique_identifier', 'club_point')->first() != null &&
                                                    \App\Addon::where('unique_identifier', 'club_point')->first()->activated)
                                                <div class="rounded px-2 mt-2 bg-soft-primary border-soft-primary border">
                                                    {{ translate('Club Point') }}:
                                                    <span class="fw-700 float-right">{{ $related_product->earn_point }}</span>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                       <div class="bg-white rounded shadow-sm mb-3">
                            <div class="border-bottom p-3">
                                <h3 class="fs-16 fw-600 mb-0">
                                <span class="mr-4">{{ translate('Top Selling Products') }}</span>
                                </h3>
                            </div>
                            <div class="p-3">
                                <div class="aiz-carousel gutters-5 half-outside-arrow" data-items="5" data-xl-items="4" data-lg-items="4"  data-md-items="3" data-sm-items="2" data-xs-items="2" data-arrows='true' data-infinite='true'>
                                    @foreach (\App\Product::where('user_id', $detailedProduct->user_id)->orderBy('num_of_sale', 'desc')->limit(6)->get() as $key => $top_product)
                                    <div class="carousel-box">
                                        <div class="aiz-card-box border border-light rounded hov-shadow-md my-2 has-transition">
                                            <div class="">
                                                <a href="{{ route('product', $top_product->slug) }}" class="d-block">
                                                    <img
                                                    class="img-fit lazyload mx-auto"
                                                    src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                                    data-src="{{ uploaded_asset($top_product->thumbnail_img) }}"
                                                    alt="{{ $top_product->getTranslation('name') }}"
                                                    onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';"
                                                    >
                                                </a>
                                            </div>
                                            <div class="p-md-3 p-2 text-left">

                                                <h3 class="fw-600 fs-13 text-truncate-2 lh-1-4 mb-0">
                                                <a href="{{ route('product', $top_product->slug) }}" class="d-block text-reset">{{ $top_product->getTranslation('name') }}</a>
                                                </h3>

                                                <div class="rating">
                                                    <!--{{ renderStarRating($top_product->rating) }}-->
                                                </div>

                                                <div class="info">

                                                    @if (Auth::check())

                                                    @if (Auth::user()->is_wholesale_customer == 1 && Auth::user()->validate_wholesale_customer == 1)

                                                    <span class="fw-700">{{ home_discounted_base_price_wholesale($top_product->id) }}</span>

                                                    @if (home_base_price_wholesale($top_product->id) != home_discounted_base_price_wholesale($top_product->id))
                                                    <del class="fw-600 text-primary mr-1">{{ home_base_price_wholesale($top_product->id) }}</del>
                                                    @endif


                                                    @else

                                                    <span class="fw-700">{{ home_discounted_base_price($top_product->id) }}</span>
                                                    @if (home_base_price($top_product->id) != home_discounted_base_price($top_product->id))
                                                    <del class="fw-600 text-primary mr-1">{{ home_base_price($top_product->id) }}</del>
                                                    @endif

                                                    @endif
                                                    @else

                                                    <span class="fw-700">{{ home_discounted_base_price($top_product->id) }}</span>
                                                    @if (home_base_price($top_product->id) != home_discounted_base_price($top_product->id))
                                                    <del class="fw-600 text-primary mr-1">{{ home_base_price($top_product->id) }}</del>
                                                    @endif


                                                    @endif

                                                </div>

                                                @if (\App\Addon::where('unique_identifier', 'club_point')->first() != null &&
                                                    \App\Addon::where('unique_identifier', 'club_point')->first()->activated)
                                                <div class="rounded px-2 mt-2 bg-soft-primary border-soft-primary border">
                                                    {{ translate('Club Point') }}:
                                                    <span class="fw-700 float-right">{{ $top_product->earn_point }}</span>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        @endsection
        @section('modal')
        <div class="modal fade" id="chat_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-zoom product-modal" id="modal-size" role="document">
                <div class="modal-content position-relative">
                    <div class="modal-header">
                        <h5 class="modal-title fw-600 h5">{{ translate('Any query about this product') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form class="" action="{{ route('conversations.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $detailedProduct->id }}">
                        <div class="modal-body gry-bg px-3 pt-3">
                            <div class="form-group">
                                <input type="text" class="form-control mb-3" name="title" value="{{ $detailedProduct->name }}" placeholder="{{ translate('Product Name') }}" required>
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" rows="8" name="message" required placeholder="{{ translate('Your Question') }}">{{ route('product', $detailedProduct->slug) }}</textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-primary fw-600" data-dismiss="modal">{{ translate('Cancel') }}</button>
                            <button type="submit" class="btn btn-primary fw-600">{{ translate('Send') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="login_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-zoom" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title fw-600">{{ translate('Login') }}</h6>
                        <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true"></span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="p-3">
                            <form class="form-default" role="form" action="{{ route('register') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    @if (\App\Addon::where('unique_identifier', 'otp_system')->first() != null &&
                                        \App\Addon::where('unique_identifier', 'otp_system')->first()->activated)
                                    <input type="text" class="form-control h-auto form-control-lg {{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}" placeholder="{{ translate('Email Or Phone') }}" name="email" id="email">
                                    @else
                                    <input type="email" class="form-control h-auto form-control-lg {{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}" placeholder="{{ translate('Email') }}" name="email">
                                    @endif
                                    @if (\App\Addon::where('unique_identifier', 'otp_system')->first() != null &&
                                        \App\Addon::where('unique_identifier', 'otp_system')->first()->activated)
                                    <span class="opacity-60">{{ translate('Use country code before number') }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <input type="password" name="password" class="form-control h-auto form-control-lg" placeholder="{{ translate('Password') }}">
                                </div>
                                <div class="row mb-2">
                                    <div class="col-6">
                                        <label class="aiz-checkbox">
                                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                            <span class=opacity-60>{{ translate('Remember Me') }}</span>
                                            <span class="aiz-square-check"></span>
                                        </label>
                                    </div>
                                    <div class="col-6 text-right">
                                        <a href="{{ route('password.request') }}" class="text-reset opacity-60 fs-14">{{ translate('Forgot password?') }}</a>
                                    </div>
                                </div>
                                <div class="mb-5">
                                    <button type="submit" class="btn btn-primary btn-block fw-600">{{ translate('Login') }}</button>
                                </div>
                            </form>
                            <div class="text-center mb-3">
                                <p class="text-muted mb-0">{{ translate('Dont have an account?') }}</p>
                                <a href="{{ route('user.registration') }}">{{ translate('Register Now') }}</a>
                            </div>
                            @if (\App\BusinessSetting::where('type', 'google_login')->first()->value == 1 ||
                                \App\BusinessSetting::where('type', 'facebook_login')->first()->value == 1 ||
                                \App\BusinessSetting::where('type', 'twitter_login')->first()->value == 1)
                            <div class="separator mb-3">
                                <span class="bg-white px-3 opacity-60">{{ translate('Or Login With') }}</span>
                            </div>
                            <ul class="list-inline social colored text-center mb-5">
                                @if (\App\BusinessSetting::where('type', 'facebook_login')->first()->value == 1)
                                <li class="list-inline-item">
                                    <a href="{{ route('social.login', ['provider' => 'facebook']) }}" class="facebook">
                                        <i class="lab la-facebook-f"></i>
                                    </a>
                                </li>
                                @endif
                                @if (\App\BusinessSetting::where('type', 'google_login')->first()->value == 1)
                                <li class="list-inline-item">
                                    <a href="{{ route('social.login', ['provider' => 'google']) }}" class="google">
                                        <i class="lab la-google"></i>
                                    </a>
                                </li>
                                @endif
                                @if (\App\BusinessSetting::where('type', 'twitter_login')->first()->value == 1)
                                <li class="list-inline-item">
                                    <a href="{{ route('social.login', ['provider' => 'twitter']) }}" class="twitter">
                                        <i class="lab la-twitter"></i>
                                    </a>
                                </li>
                                @endif
                            </ul>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>


<!-- Button trigger modal -->
{{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#enquirymdl">
  Launch demo modal
</button> --}}

<!-- Modal -->
<div class="modal fade" id="enquirymdl" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Enquiry Now</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
          <form method="post" action="{{ route('enquiry') }}">
              @csrf()
      <div class="modal-body">

                   <div class="row">
                     <div class="col-md-12 col-xs-12">
                    <div class="form-group">
                        <label label="username">Name <span>*</span></label>
                        <input type="text" placeholder="Enter Your Name" class="form-control" name="name" required="">
                    </div>
                     </div>
                     <div class="col-md-6 col-xs-12">
                     <div class="form-group">
                        <label name="userphone">Mobile <span>*</span></label>
                        <input type="number" placeholder="Mobile Number" class="form-control" name="phone" required="">
                    </div>
                     </div>
                     <div class="col-md-6 col-xs-12">
                          <div class="form-group">
                        <label name="quantity">Quantity</label>
                        <input type="number" placeholder="Quantity" Value="1" class="form-control" name="qntity">
                    </div>
                    </div>

                      <div class="col-md-12 col-xs-12">
                          <div class="form-group">
                        <label name="quantity">Remark</label>
                         <textarea class="form-control textarea-autogrow mb-3" placeholder="Your Message" rows="3" name="remark" required="" spellcheck="false"></textarea>
                    </div>
                    </div>


                    </div>

      </div>
      <div class="modal-footer">
        <input type="hidden" value="{{ $detailedProduct->id }}" name="product_id">
        <button type="submit" name="submit" class="btn btn-primary">Save changes</button>
      </div>
      </form>
    </div>
  </div>
</div>
        @endsection
        @section('script')
        <script type="text/javascript">
        $(document).ready(function() {
        getVariantPrice();
        });
        function CopyToClipboard(containerid) {
        if (document.selection) {
        var range = document.body.createTextRange();
        range.moveToElementText(document.getElementById(containerid));
        range.select().createTextRange();
        document.execCommand("Copy");
        } else if (window.getSelection) {
        var range = document.createRange();
        document.getElementById(containerid).style.display = "block";
        range.selectNode(document.getElementById(containerid));
        window.getSelection().addRange(range);
        document.execCommand("Copy");
        document.getElementById(containerid).style.display = "none";
        }
        AIZ.plugins.notify('success', 'Copied');
        }
        function show_chat_modal(){
        @if (Auth::check())
        $('#chat_modal').modal('show');
        @else
        $('#login_modal').modal('show'); @endif
            }
            </script>

            <script src="{{ static_asset('assets/js/zoom-image.js') }}"></script>

            <script type="text/javascript">
                if (window.innerWidth > 768) {
                    $('.imgBox').imgZoom({
                        boxWidth: 500,
                        boxHeight: 500,
                        marginLeft: 5,
                        origin: 'data-origin'
                    });
                }

                $(document).ready(function() {
                    $('.show-small-img').click(function() {
                        $('#show-img').attr('data-origin', $(this).attr('src'));
                    });
                });
            </script>

        @endsection
