@extends('frontend.layouts.app')
@section('content')
@if($flash_deal->status == 1 && strtotime(date('Y-m-d H:i:s')) <= $flash_deal->end_date) 
<div style="background-color:{{ $flash_deal->background_color }}">
<!--<section class="text-center mb-5">-->
<!--    <img-->
<!--        src="{{ static_asset('assets/img/placeholder-rect.jpg') }}"-->
<!--        data-src="{{ uploaded_asset($flash_deal->banner) }}"-->
<!--        alt="{{ $flash_deal->title }}"-->
<!--        class="img-fit w-100 lazyload"-->
<!--    >-->
<!--</section>-->
<section class="mb-4">
   <div class="container-fluid">
      <div class="px-2 py-4 px-md-4 py-md-3">
         <div class="text-center my-4 text-{{ $flash_deal->text_color }}">
            <div class="section-header text-center">
               <h2>{{ $flash_deal->title }}</h2>
            </div>
           <div class="aiz-count-down ml-auto ml-lg-3 align-items-center" data-date="{{ date('Y/m/d H:i:s', $flash_deal->end_date) }}"></div>
         </div>
         <div class="row gutters-5 row-cols-xxl-5 row-cols-lg-5 row-cols-md-3 row-cols-2">
            @foreach ($flash_deal->flash_deal_products as $key => $flash_deal_product)
            @php
            $product = \App\Product::find($flash_deal_product->product_id);
            @endphp
            @if ($product->published != 0)
            <div class="col">
               <div class="aiz-card-box">
                  <div class="position-relative">
                     <a href="{{ route('product', $product->slug) }}" class="d-block">
                     <img
                        class="img-fit lazyload mx-auto h-140px h-md-220px"
                        src="{{ static_asset('assets/img/placeholder.jpg') }}"
                        data-src="{{ uploaded_asset($product->thumbnail_img) }}"
                        alt="{{  $product->getTranslation('name')  }}"
                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';"
                        >
                     </a>
                     <div class="absolute-top-wish">
                        <a href="javascript:void(0)" onclick="addToWishList({{ $product->id }})"  data-toggle="tooltip" data-title="{{ translate('Add to wishlist') }}" data-placement="left">
                        <i class="fad fa-heart"></i>
                        </a> 
                     </div>
                     <!--<div class="absolute-top-right aiz-p-hov-icon">-->
                     <!--    <a href="javascript:void(0)" onclick="addToWishList({{ $product->id }})" data-toggle="tooltip" data-title="{{ translate('Add to wishlist') }}" data-placement="left">-->
                     <!--        <i class="la la-heart-o"></i>-->
                     <!--    </a>-->
                     <!--    <a href="javascript:void(0)" onclick="addToCompare({{ $product->id }})" data-toggle="tooltip" data-title="{{ translate('Add to compare') }}" data-placement="left">-->
                     <!--        <i class="las la-sync"></i>-->
                     <!--    </a>-->
                     <!--    <a href="javascript:void(0)" onclick="showAddToCartModal({{ $product->id }})" data-toggle="tooltip" data-title="{{ translate('Add to cart') }}" data-placement="left">-->
                     <!--        <i class="las la-shopping-cart"></i>-->
                     <!--    </a>-->
                     <!--</div>-->
                  </div>
                  @if(Auth::check())
                  <div class="p-md-3 p-2 text-center">
                     <h3 class="fw-600 fs-13 text-truncate-2 lh-1-4 mb-0">
                        <a href="{{ route('product', $product->slug) }}" class="d-block text-reset">{{  $product->getTranslation('name')  }}</a>
                     </h3>
                     <div class="rating rating-sm mt-1">
                        <!--{{ renderStarRating($product->rating) }}-->
                        @php
                        $flash_deal_feature= \App\FlashDeal::where('flash_deals.status', 1)->where('flash_deals.featured', 1)->where('flash_deal_products.product_id', $product->id)->leftJoin('flash_deal_products', 'flash_deals.id', '=', 'flash_deal_products.flash_deal_id')->first();
                        @endphp
                     </div>
                     <div class="info">
                        @if(Auth::user()->is_wholesale_customer==1 && Auth::user()->validate_wholesale_customer==1)
                        <del class="fw-600 text-primary mr-1" >{{ home_base_price_wholesale($product->id) }}</del>
                        @else  
                        @if(home_base_price($product->id) != home_discounted_base_price($product->id))
                        <del class="fw-600 text-primary mr-1" >{{ home_base_price($product->id) }}</del>
                        @endif
                        @endif
                        @if(Auth::user()->is_wholesale_customer==1 && Auth::user()->validate_wholesale_customer==1)
                        <span class="fw-700">{{ home_discounted_base_price_wholesale($product->id) }}</span>
                        @else
                        <span class="fw-700">{{ home_discounted_base_price($product->id) }}</span>
                        @endif
                     </div>
                     <div class="new-label new-top">
                        @if(Auth::user()->is_wholesale_customer==1 && Auth::user()->validate_wholesale_customer==1)
                        @if($flash_deal_feature['wholesale_discount'])
                        <p>@if($flash_deal_feature['wholesale_discount_type']=='percent') {{ $flash_deal_feature['wholesale_discount'] }}% Flash @endif</p>
                        <p>@if($flash_deal_feature['wholesale_discount_type']=='amount') {{ $flash_deal_feature['wholesale_discount'] }}Rs Flash @endif</p>
                        @else
                        <p>@if($product->wholesale_discount_type=='percent') {{ $product->wholesale_discount }}% Off @endif</p>
                        <p>@if($product->wholesale_discount_type=='amount') {{ $product->wholesale_discount }}Rs Off @endif</p>
                        @endif
                        @else
                        @if($flash_deal_feature['discount'])
                        <p>@if($flash_deal_feature['discount_type']=='percent') {{ $flash_deal_feature['discount'] }}% Flash @endif</p>
                        <p>@if($flash_deal_feature['discount_type']=='amount') {{ $flash_deal_feature['discount'] }}Rs Flash @endif</p>
                        @else
                        <p>@if($product->discount_type=='percent') {{ $product->discount }}% Off @endif</p>
                        <p>@if($product->discount_type=='amount') {{ $product->discount }}Rs Off @endif</p>
                        @endif
                        @endif
                     </div>
                     <div class="views">
                        <a href="javascript:void(0)" onclick="showAddToCartModal({{ $product->id }})" data-title="{{ translate('Add to cart') }}" data-placement="left">
                        <i class="las la-shopping-cart"></i> Add To Cart</a>
                     </div>
                     @if (\App\Addon::where('unique_identifier', 'club_point')->first() != null && \App\Addon::where('unique_identifier', 'club_point')->first()->activated)
                     <div class="rounded px-2 mt-2 bg-soft-primary border-soft-primary border">
                        {{ translate('Club Point') }}:
                        <span class="fw-700">{{ $product->earn_point }}</span>
                     </div>
                     @endif
                  </div>
                  @else
                  <div class="p-md-3 p-2 text-center">
                        <h3 class="fw-600 fs-13 text-truncate-2 lh-1-4 mb-0">
                           <a href="{{ route('product', $product->slug) }}" class="d-block text-reset">{{  $product->getTranslation('name')  }}</a>
                        </h3>
                        <div class="rating rating-sm mt-1">
                           <!--{{ renderStarRating($product->rating) }}-->
                        </div>
                        
                        <div class="info">
                           @if(home_base_price($product->id) != home_discounted_base_price($product->id))
                           <del class="fw-600 text-primary mr-1" >{{ home_base_price($product->id) }}</del>
                           @endif
                           <span class="fw-700 ">{{ home_discounted_base_price($product->id) }}</span>
                        </div>
                        <div class="new-label new-top">
                           @php
                           $flash_deal_feature= \App\FlashDeal::where('flash_deals.status', 1)->where('flash_deals.featured', 1)->where('flash_deal_products.product_id', $product->id)->leftJoin('flash_deal_products', 'flash_deals.id', '=', 'flash_deal_products.flash_deal_id')->first();
                           @endphp
                           @if($flash_deal_feature['discount'])
                           <p>@if($flash_deal_feature['discount_type']=='percent') {{ $flash_deal_feature['discount'] }}% Flash @endif</p>
                           <p>@if($flash_deal_feature['discount_type']=='amount') {{ $flash_deal_feature['discount'] }}Rs Flash @endif</p>
                           @else
                           <p>@if($product->discount_type=='percent') {{ $product->discount }}% Off @endif</p>
                           <p>@if($product->discount_type=='amount') {{ $product->discount }}Rs Off @endif</p>
                           @endif
                        </div>
                        @if (\App\Addon::where('unique_identifier', 'club_point')->first() != null && \App\Addon::where('unique_identifier', 'club_point')->first()->activated)
                        <div class="rounded px-2 mt-2 bg-soft-primary border-soft-primary border">
                           {{ translate('Club Point') }}:
                           <span class="fw-700">{{ $product->earn_point }}</span>
                        </div>
                        @endif
                     </div>
                     @endif
                  </div>
               </div>
               @endif
               @endforeach
            </div>
         </div>
</section>
</div>
</div>
@else
<div style="background-color:{{ $flash_deal->background_color }}">
   <section class="text-center">
      <img src="{{ uploaded_asset($flash_deal->banner) }}" alt="{{ $flash_deal->title }}" class="img-fit w-100">
   </section>
   <section class="pb-4">
      <div class="container">
         <div class="text-center text-{{ $flash_deal->text_color }}">
            <h1 class="h3 my-4">{{ $flash_deal->title }}</h1>
            <p class="h4">{{  translate('This offer has been expired.') }}</p>
         </div>
      </div>
   </section>
</div>
@endif
@endsection