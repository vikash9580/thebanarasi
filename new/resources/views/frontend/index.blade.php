@extends('frontend.layouts.app')
@section('content')
{{-- Categories , Sliders . Today's deal --}}
<div class="home-banner-area mb-4">
   @php
   $num_todays_deal = count(filter_products(\App\Product::where('published', 1)->where('todays_deal', 1 ))->get());
   $featured_categories = \App\Category::where('featured', 1)->get();
   @endphp
   <div class="@if($num_todays_deal > 0) col-lg-7 @else pd @endif">
      @if (get_setting('home_slider_images') != null)
      <div class="aiz-carousel slide dots-inside-bottom mobile-img-auto-height" data-arrows="true" data-dots="true" data-autoplay="true" data-infinite="true">
         @php $slider_images = json_decode(get_setting('home_slider_images'), true);  @endphp
         @foreach ($slider_images as $key => $value)
         <div class="carousel-box">
            <a href="{{ json_decode(get_setting('home_slider_links'), true)[$key] }}">
            <img
            class="d-block mw-100 lazyload img-fit shadow-sm"
            src="{{ static_asset('assets/img/placeholder-rect.jpg') }}"
            data-src="{{ uploaded_asset($slider_images[$key]) }}"
            alt="{{ env('APP_NAME')}} promo"
            @if(count($featured_categories) == 0)
            height="620"
            @else
            height="620"
            @endif
            onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder-rect.jpg') }}';"
            >
            </a>
         </div>
         @endforeach
      </div>
      @endif
   </div>
   <div class="latest-blogs">
      <!--<div class="container-fluid">-->
      <!--   <div class="row">-->
      <!--      <div class="col-md-4">-->
      <!--         <div class="row">-->
      <!--            <div class="col-md-12 ">-->
      <!--               <article class="post">-->
      <!--                  <div class="post-thumb-content">-->
      <!--                     <figure class="post-thumb">-->
      <!--                        <a href="/search?category=banarasi-silk-stoles"><img class="img-responsive" alt="thumb" src="../public/assets/img/stole.png"> </a>-->
      <!--                     </figure>-->
      <!--                     <div class="product_var_one_text">-->
      <!--                        <h4 class="color_one">Outerwear</h4>-->
      <!--                        <h2>Stole</h2>-->
      <!--                        <h4>Collection</h4>-->
      <!--                        <a href="/search?category=banarasi-silk-stoles" class="theme-btn-one">Shop Now</a>-->
      <!--                     </div>-->
      <!--                  </div>-->
      <!--               </article>-->
      <!--            </div>-->
      <!--            <div class="col-md-12">-->
      <!--               <article class="post">-->
      <!--                  <div class="post-thumb-content">-->
      <!--                     <figure class="post-thumb">-->
      <!--                        <a href="/search?category=banarasi-silk-dupatta"> <img class="img-responsive" alt="thumb" src="../public/assets/img/dupatta.png"> </a>-->
      <!--                     </figure>-->
      <!--                     <div class="product_var_one_text">-->
      <!--                        <h4 class="color_one">Outerwear</h4>-->
      <!--                        <h2>Dupatta</h2>-->
      <!--                        <h4>Collection</h4>-->
      <!--                        <a href="/search?category=banarasi-silk-dupatta" class="theme-btn-one">Shop Now</a>-->
      <!--                     </div>-->
      <!--                  </div>-->
      <!--               </article>-->
      <!--            </div>-->
      <!--         </div>-->
      <!--      </div>-->
            <!--/.col-md-12-->
      <!--      <div class="col-md-4">-->
      <!--         <article class="post">-->
      <!--            <div class="post-thumb-content">-->
      <!--               <figure class="post-thumb">-->
      <!--                  <a href="/search?category=banarasi-silk-sarees"><img class="img-responsive" alt="thumb" src="../public/assets/img/saree.png"> </a>-->
      <!--               </figure>-->
      <!--               <div class="product_var_one_text product_var_one_text_center">-->
      <!--                  <h4 class="color_one">Fashion</h4>-->
      <!--                  <h2>Saree</h2>-->
      <!--                  <h4>Collection</h4>-->
      <!--                  <a href="/search?category=banarasi-silk-sarees" class="theme-btn-one">Shop Now</a>-->
      <!--               </div>-->
      <!--            </div>-->
      <!--         </article>-->
      <!--      </div>-->
            <!--/.col-md-4-->
      <!--      <div class="col-md-4">-->
      <!--         <div class="row">-->
      <!--            <div class="col-md-12 ">-->
      <!--               <article class="post">-->
      <!--                  <div class="post-thumb-content">-->
      <!--                     <figure class="post-thumb">-->
      <!--                        <a href="/search?category=pashmina-shawls"><img class="img-responsive" alt="thumb" src="../public/assets/img/parshmani-shawl.png"> </a>-->
      <!--                     </figure>-->
      <!--                     <div class="product_var_one_text">-->
      <!--                        <h4 class="color_one">Outerwear</h4>-->
      <!--                        <h2>Pashmina </h2>-->
      <!--                        <h4>Shawls</h4>-->
      <!--                        <a href="/search?category=pashmina-shawls" class="theme-btn-one">Shop Now</a>-->
      <!--                     </div>-->
      <!--                  </div>-->
      <!--               </article>-->
      <!--            </div>-->
      <!--            <div class="col-md-12">-->
      <!--               <article class="post">-->
      <!--                  <div class="post-thumb-content">-->
      <!--                     <figure class="post-thumb">-->
      <!--                        <a href="/search?category=fabric"> <img class="img-responsive" alt="thumb" src="../public/assets/img/fabric.png"> </a>-->
      <!--                     </figure>-->
      <!--                     <div class="product_var_one_text">-->
      <!--                        <h4 class="color_one">Outerwear</h4>-->
      <!--                        <h2>Fabric</h2>-->
      <!--                        <h4>Collection</h4>-->
      <!--                        <a href="/search?category=fabric" class="theme-btn-one">Shop Now</a>-->
      <!--                     </div>-->
      <!--                  </div>-->
      <!--               </article>-->
      <!--            </div>-->
      <!--         </div>-->
      <!--      </div>-->
            <!--/.c
               <!--/.col-md-3-->
      <!--   </div>-->
         <!--/.row-->
      <!--</div>-->
      
      
      <div class="container-fluid">
          <div class="row">
             <div class="col-md-6">
               <article class="post">
                  <div class="post-thumb-content">
                     <figure class="post-thumb promo-grid__container">
                        <a href="/search?category=banarasi-silk-sarees"><img class="img-responsive" alt="thumb" src="../public/assets/img/saree.jpg"> </a>
                     </figure>
                     <div class="product_var_one_text product_var_one_text_center text-left">
                        <h4>Designer Choice</h4>
                        <h2>Saree</h2>
                        <a href="/search?category=banarasi-silk-sarees" class="theme-btn-one">Shop Now</a>
                     </div>
                  </div>
               </article>
            </div>
             <div class="col-md-6">
               <article class="post">
                  <div class="post-thumb-content">
                     <figure class="post-thumb promo-grid__container">
                        <a href="/search?category=Suit-c5zdg"><img class="img-responsive" alt="thumb" src="../public/assets/img/suit.jpg"> </a>
                     </figure>
                     <div class="product_var_one_text product_var_one_text_center text-right">
                        <h4>Latest Collection</h4>
                        <h2>Suits</h2>
                        <a href="/search?category=Suit-c5zdg" class="theme-btn-one">Shop Now</a>
                     </div>
                  </div>
               </article>
            </div>
          </div>
            
           <div class="row">
               <div class="col-md-3 col-xs-6">
               <article class="post">
                  <div class="post-thumb-content">
                     <figure class="post-thumb">
                        <a href="/search?category=banarasi-silk-sarees"><img class="img-responsive" alt="thumb" src="../public/assets/img/pashmin_shwl.jpg"> </a>
                     </figure>
                     <div class="product_var_one_text product_var_one_text_center">
                        <h4>Latest Collection</h4>
                        <h2>Pashmina Shawls</h2>
                       <a href="/search?category=pashmina-shawls" class="theme-btn-one">Shop Now</a>
                     </div>
                  </div>
               </article>
            </div>
              <!--/.col-md-3-->
               <div class="col-md-3 col-xs-6">
               <article class="post">
                  <div class="post-thumb-content">
                     <figure class="post-thumb">
                        <a href="/search?category=banarasi-silk-sarees"><img class="img-responsive" alt="thumb" src="../public/assets/img/stole_720.jpg"> </a>
                     </figure>
                     <div class="product_var_one_text product_var_one_text_center">
                        <h4>Designer Choice</h4>
                        <h2>Stole</h2>
                        <a href="/search?category=banarasi-silk-stoles" class="theme-btn-one">Shop Now</a>
                     </div>
                  </div>
               </article>
            </div>
             <!--/.col-md-3-->
             <div class="col-md-3 col-xs-6">
               <article class="post">
                  <div class="post-thumb-content">
                     <figure class="post-thumb">
                        <a href="/search?category=banarasi-silk-sarees"><img class="img-responsive" alt="thumb" src="../public/assets/img/dupatta_1.jpg"> </a>
                     </figure>
                     <div class="product_var_one_text product_var_one_text_center">
                        <h4>Latest Styles</h4>
                        <h2>Dupatta</h2>
                        <a href="/search?category=banarasi-silk-dupatta" class="theme-btn-one">Shop Now</a>
                     </div>
                  </div>
               </article>
            </div>
             <!--/.col-md-3-->
             <div class="col-md-3 col-xs-6">
               <article class="post">
                  <div class="post-thumb-content">
                     <figure class="post-thumb">
                        <a href="/search?category=fabric"><img class="img-responsive" alt="thumb" src="../public/assets/img/fabrics_720.jpg"> </a>
                     </figure>
                     <div class="product_var_one_text product_var_one_text_center">
                        <h4>Latest Collection</h4>
                        <h2>Fabric</h2>
                        <a href="/search?category=fabric" class="theme-btn-one">Shop Now</a>
                     </div>
                  </div>
               </article>
            </div>
            <!--/.col-md-3-->
             <!--/.row-->
          </div>
      
      <!--/.container-->
   </div>
   <!--/.post-->
   @if($num_todays_deal > 0)
   <div class="col-lg-2 order-3 mt-3 mt-lg-0">
      <div class="bg-white rounded shadow-sm">
         <div class="bg-soft-primary rounded-top p-3 d-flex align-items-center justify-content-center">
            <span class="fw-600 fs-16 mr-2 text-truncate">
            {{ translate('Todays Deal') }}
            </span>
            <span class="badge badge-primary badge-inline">{{ translate('Hot') }}</span>
         </div>
         <div class="c-scrollbar-light overflow-auto h-lg-400px p-2 bg-primary rounded-bottom">
            <div class="gutters-5 lg-no-gutters row row-cols-2 row-cols-lg-1">
               @foreach (filter_products(\App\Product::where('published', 1)->where('todays_deal', '1'))->get() as $key => $product)
               @if ($product != null)
               <div class="col">
                  <a href="{{ route('product', $product->slug) }}" class="d-block p-2 text-reset bg-white mb-2 rounded">
                     <div class="row gutters-5 align-items-center">
                        <div class="col-lg">
                           <div class="img">
                              <img
                                 class="lazyload img-fit h-140px h-lg-80px"
                                 src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                 data-src="{{ uploaded_asset($product->thumbnail_img) }}"
                                 alt="{{ $product->getTranslation('name') }}"
                                 onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';"
                                 >
                           </div>
                        </div>
                        <div class="col-lg">
                           <div class="fs-16">
                              <span class="d-block text-primary fw-600">{{ home_discounted_base_price($product->id) }}</span>
                              @if(home_base_price($product->id) != home_discounted_base_price($product->id))
                              <del class="d-block opacity-70">{{ home_base_price($product->id) }}</del>
                              @endif
                           </div>
                        </div>
                     </div>
                  </a>
               </div>
               @endif
               @endforeach
            </div>
         </div>
      </div>
   </div>
   @endif
</div>
                       

     @php
         $flash_deal = \App\FlashDeal::where('status', 1)->where('featured', 1)->first();
         @endphp

  @if($flash_deal != null && strtotime(date('Y-m-d H:i:s')) >= $flash_deal->start_date && strtotime(date('Y-m-d H:i:s')) <= $flash_deal->end_date)
  
            
            
<section class="product">
   <div class="container-fluid">
         <div class="section-header text-center">
            <h2>Flash Deal</h2>
         </div>
         <div class="d-flex flex-wrap mb-3 align-items-baseline">
                  <div class="aiz-count-down ml-auto ml-lg-3 align-items-center" data-date="{{ date('Y/m/d H:i:s', $flash_deal->end_date) }}"></div>
                  <a href="{{ route('flash-deal-details', $flash_deal->slug) }}" class="ml-auto cell">{{ translate('View More') }}</a>
               </div>
            <div class="px-2 py-4 px-md-4 py-md-3">
               <div class="aiz-carousel gutters-10 half-outside-arrow" data-items="6" data-xl-items="5" data-lg-items="4"  data-md-items="3" data-sm-items="2" data-xs-items="2" data-arrows='true' data-infinite='true'>
                  @foreach ($flash_deal->flash_deal_products as $key => $flash_deal_product)
                  @php
                  $product = \App\Product::find($flash_deal_product->product_id);
                  @endphp
                  @if ($product != null && $product->published != 0)
                  <div class="carousel-box">
                     <div class="aiz-card-box">
                        <div class="position-relative">
                           <a href="{{ route('product', $product->slug) }}" class="d-block">
                           <img
                              class="img-fit lazyload mx-auto"
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
                        </div>
                        @if(Auth::check())
                        <div class="p-md-3 p-2 text-center">
                           <h3 class="fw-600 fs-13 text-truncate-2 lh-1-4 mb-0">
                              <a href="{{ route('product', $product->slug) }}" class="d-block text-reset">{{  $product->getTranslation('name')  }}</a>
                           </h3>
                           <div class="rating text-center rating-sm mt-1">
                              @php
                              $flash_deal_feature= \App\FlashDeal::where('flash_deals.status', 1)->where('flash_deals.featured', 1)->where('flash_deal_products.product_id', $product->id)->leftJoin('flash_deal_products', 'flash_deals.id', '=', 'flash_deal_products.flash_deal_id')->first();
                              @endphp
                           </div>
                           @if(Auth::user()->is_wholesale_customer==1 && Auth::user()->validate_wholesale_customer==1)
                           @if($flash_deal_feature['wholesale_discount'])
                           <div class="new-label new-top">
                              <p>@if($flash_deal_feature['wholesale_discount_type']=='percent') {{ $flash_deal_feature['wholesale_discount'] }}% Flash @endif</p>
                              <p>@if($flash_deal_feature['wholesale_discount_type']=='amount') {{ $flash_deal_feature['wholesale_discount'] }}Rs Flash @endif</p>
                           </div>
                           @else
                           <div class="new-label new-top">
                              <p>@if($product->wholesale_discount_type=='percent' && $product->wholesale_discount!=0) {{ $product->wholesale_discount }}% Off @endif</p>
                              <p>@if($product->wholesale_discount_type=='amount' && $product->wholesale_discount!=0) {{ $product->wholesale_discount }}Rs Off @endif</p>
                           </div>
                           @endif
                           @else
                           @if($flash_deal_feature['discount'])
                           @if($flash_deal_feature['discount_type']=='percent')
                           <div class="new-label new-top">
                              <p> {{ $flash_deal_feature['discount'] }}% Flash</p>
                           </div>
                           @endif
                           @if($flash_deal_feature['discount_type']=='amount')
                           <div class="new-label new-top">
                              <p> {{ $flash_deal_feature['discount'] }}Rs Flash</p>
                           </div>
                           @endif
                           @else
                           @if($product->discount_type=='percent' && $product->discount!=0)
                           <div class="new-label new-top">
                              <p> {{ $product->discount }}% Off</p>
                           </div>
                           @endif
                           @if($product->discount_type=='amount' && $product->discount!=0)
                           <div class="new-label new-top">
                              <p> {{ $product->discount }}Rs Off </p>
                           </div>
                           @endif
                           @endif
                           @endif
                           <div class="info">
                              @if(Auth::user()->is_wholesale_customer==1 && Auth::user()->validate_wholesale_customer==1)
                              <del class="fw-600  text-primary mr-1" >{{ home_base_price_wholesale($product->id) }}</del>
                              @else  
                              @if(home_base_price($product->id) != home_discounted_base_price($product->id))
                              <del class="fw-600  text-primary mr-1" >{{ home_base_price($product->id) }}</del>
                              @endif
                              @endif
                              @if(Auth::user()->is_wholesale_customer==1 && Auth::user()->validate_wholesale_customer==1)
                              <span class="fw-700">{{ home_discounted_base_price_wholesale($product->id) }}</span>
                              @else
                              <span class="fw-700">{{ home_discounted_base_price($product->id) }}</span>
                              @endif
                           </div>
                           <div class="views">
                              <a href="javascript:void(0)" onclick="showAddToCartModal({{ $product->id }})" data-title="{{ translate('Add to cart') }}" data-placement="left">
                              <i class="las la-shopping-cart"></i> Add To Cart</a>
                           </div>
                           @if (\App\Addon::where('unique_identifier', 'club_point')->first() != null && \App\Addon::where('unique_identifier', 'club_point')->first()->activated)
                           <div class="rounded px-2 mt-2 bg-soft-primary border-soft-primary border">
                              {{ translate('Club Point') }}:
                              <span class="fw-700 float-right">{{ $product->earn_point }}</span>
                           </div>
                           @endif
                        </div>
                        @else
                        <div class="p-md-3 p-2 text-center">
                           <h3 class="fw-600 fs-13 text-truncate-2 lh-1-4 mb-0">
                              <a href="{{ route('product', $product->slug) }}" class="d-block text-reset">{{  $product->getTranslation('name')  }}</a>
                           </h3>
                           <div class="rating">
                              <!--{{ renderStarRating($product->rating) }}-->
                              @php
                              $flash_deal_feature= \App\FlashDeal::where('flash_deals.status', 1)->where('flash_deals.featured', 1)->where('flash_deal_products.product_id', $product->id)->leftJoin('flash_deal_products', 'flash_deals.id', '=', 'flash_deal_products.flash_deal_id')->first();
                              @endphp
                           </div>
                           @if($flash_deal_feature['discount'])
                           @if($flash_deal_feature['discount_type']=='percent')
                           <div class="new-label new-top">
                              <p> {{ $flash_deal_feature['discount'] }}% Flash</p>
                           </div>
                           @endif
                           @if($flash_deal_feature['discount_type']=='amount')
                           <div class="new-label new-top">
                              <p> {{ $flash_deal_feature['discount'] }}Rs Flash</p>
                           </div>
                           @endif
                           @else
                           @if($product->discount_type=='percent' && $product->discount!=0)
                           <div class="new-label new-top">
                              <p> {{ $product->discount }}% Off</p>
                           </div>
                           @endif
                           @if($product->discount_type=='amount' && $product->discount!=0)
                           <div class="new-label new-top">
                              <p> {{ $product->discount }}Rs Off </p>
                           </div>
                           @endif
                           @endif
                           <div class="info">
                              @if(home_base_price($product->id) != home_discounted_base_price($product->id))
                              <del class="fw-600 text-primary  mr-1" >{{ home_base_price($product->id) }}</del>
                              @endif
                              <span class="fw-700">{{ home_discounted_base_price($product->id) }}</span>
                           </div>
                           <div class="views">
                              <a href="javascript:void(0)" onclick="showAddToCartModal({{ $product->id }})" data-title="{{ translate('Add to cart') }}" data-placement="left">
                              <i class="far fa-shopping-cart"></i> Add To Cart</a>
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
         @endif
   </div>
</section>
  


  

<section class="product">
   <div class="container-fluid">
      <div class="mb-3">
         <div class="section-header text-center">
            <h2>Trending Products</h2>
         </div>
         <div class="nav nav-tabs products-tab clearfix">
            <a href="#new_arrivals" data-toggle="tab" class="active">{{ translate('New Arrivals')}}</a>
            <a href="#section_featured" data-toggle="tab" id="fp" class="text-reset">{{ translate('Featured Products')}}</a>
            <a href="#section_best_selling" data-toggle="tab" id="bs" class="text-reset">{{ translate('Best Selling')}}</a>
         </div>
         <div class="tab-content pt-0">
            <div class="tab-pane active show" id="new_arrivals">
                  <div class="px-2 py-4 px-md-4 py-md-3">
                     <div class="aiz-carousel gutters-10 half-outside-arrow" data-items="6" data-xl-items="5" data-lg-items="4"  data-md-items="3" data-sm-items="2" data-xs-items="2" data-arrows='true' data-infinite='true'>
                        @foreach (filter_products(\App\Product::where('published', 1)->orderBy('id', 'desc'))->limit(12)->get() as $key => $product)
                        <div class="carousel-box">
                           <div class="aiz-card-box">
                              <div class="position-relative">
                                 <a href="{{ route('product', $product->slug) }}" class="d-block">
                                 <img
                                    class="img-fit lazyload mx-auto"
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
                              </div>
                             
  
                              @if(Auth::check())
                              <div class="p-md-3 p-2 text-center">
                                 <h3 class="text-truncate-2 lh-1-4 mb-0">
                                    <a href="{{ route('product', $product->slug) }}" class="d-block text-reset">{{  $product->getTranslation('name')  }}</a>
                                 </h3>
                                 <div class="rating">
                                    <!--{{ renderStarRating($product->rating) }}-->
                                    @php
                                    $flash_deal_feature= \App\FlashDeal::where('flash_deals.status', 1)->where('flash_deals.featured', 1)->where('flash_deal_products.product_id', $product->id)->leftJoin('flash_deal_products', 'flash_deals.id', '=', 'flash_deal_products.flash_deal_id')->first();
                                    @endphp
                                 </div>
                                @if($flash_deal_feature)
                                 	<div class="info">
                                      	@if(Auth::user()->is_wholesale_customer==1 && Auth::user()->validate_wholesale_customer==1)
                                      		<span>{{ home_discounted_base_price_wholesale($product->id) }}</span>
                                      	@else
                                    		<span>{{ home_discounted_base_price($product->id) }}</span>
                                    	@endif
                                    	@if(Auth::user()->is_wholesale_customer==1 && Auth::user()->validate_wholesale_customer==1)
                                    		<del class=" text-primary mr-1" >{{ home_base_price_wholesale($product->id) }}</del>
                                    	@else  
                                    		@if(home_base_price($product->id) != home_discounted_base_price($product->id))
                                    			<del class="text-primary  mr-1" >{{ home_base_price($product->id) }}</del>
                                    		@endif
                                    	@endif
                                 	</div>
                                 	@if(Auth::user()->is_wholesale_customer==1 && Auth::user()->validate_wholesale_customer==1)
                                 		@if($flash_deal_feature['wholesale_discount'])
                                 			<div class="new-label new-top">
                                    			<p>@if($flash_deal_feature['wholesale_discount_type']=='percent') {{ $flash_deal_feature['wholesale_discount'] }}% Flash @endif</p>
                                    			<p>@if($flash_deal_feature['wholesale_discount_type']=='amount') {{ $flash_deal_feature['wholesale_discount'] }}Rs Flash @endif</p>
                                 			</div>
                                 		@else
                                          	<div class="new-label new-top">
                                              	<p>@if($product->wholesale_discount_type=='percent' && $product->wholesale_discount!=0) {{ $product->wholesale_discount }}% Off @endif</p>
                                              	<p>@if($product->wholesale_discount_type=='amount' && $product->wholesale_discount!=0) {{ $product->wholesale_discount }}Rs Off @endif</p>
                                          	</div>
                                 		@endif
                                 	@else
                                        @if($flash_deal_feature['discount'])
                                            @if($flash_deal_feature['discount_type']=='percent')
                                                <div class="new-label new-top">
                                                    <p> {{ $flash_deal_feature['discount'] }}% Flash</p>
                                                </div>
                                            @endif
                                            @if($flash_deal_feature['discount_type']=='amount')
                                                <div class="new-label new-top">
                                                    <p> {{ $flash_deal_feature['discount'] }}Rs Flash</p>
                                                </div>
                                            @endif
                                        @else
                                            @if($product->discount_type=='percent' && $product->discount!=0)
                                                <div class="new-label new-top">
                                                    <p> {{ $product->discount }}% Off</p>
                                                </div>
                                            @endif
                                            @if($product->discount_type=='amount' && $product->discount!=0)
                                                <div class="new-label new-top">
                                                    <p> {{ $product->discount }}Rs Off </p>
                                                </div>
                                            @endif
                                        @endif
                                 	@endif
                                @endif
                                 <div class="views">
                                    <a href="javascript:void(0)" onclick="showAddToCartModal({{ $product->id }})" data-title="{{ translate('Add to cart') }}" data-placement="">
                                    <i class="far fa-shopping-cart"></i> Add To Cart</a>
                                 </div>
                                 @if (\App\Addon::where('unique_identifier', 'club_point')->first() != null && \App\Addon::where('unique_identifier', 'club_point')->first()->activated)
                                 <div class="rounded px-2 mt-2 bg-soft-primary border-soft-primary border">
                                    {{ translate('Club Point') }}:
                                    <span class="float-right">{{ $product->earn_point }}</span>
                                 </div>
                                 @endif
                              </div>
                              @else
                               
  
    
                              <div class="p-md-3 p-2 text-center">
                                 <h3 class="text-truncate-2 lh-1-4 mb-0">
                                    <a href="{{ route('product', $product->slug) }}" class="d-block text-reset">{{  $product->getTranslation('name')  }}</a>
                                 </h3>
                                 <div class="rating">
                                    <!--{{ renderStarRating($product->rating) }}-->
                                    @php
                                    $flash_deal_feature= \App\FlashDeal::where('flash_deals.status', 1)->where('flash_deals.featured', 1)->where('flash_deal_products.product_id', $product->id)->leftJoin('flash_deal_products', 'flash_deals.id', '=', 'flash_deal_products.flash_deal_id')->first();
                                    @endphp
                                 </div>
                                @if($flash_deal_feature)
                                 	<div class="info">
                                    	<span>{{ home_discounted_base_price($product->id) }}</span>&nbsp;
                                    	@if(home_base_price($product->id) != home_discounted_base_price($product->id))
                                    		<del class="text-primary mr-1" >{{ home_base_price($product->id) }}</del>
                                    	@endif
                                 	</div>
                                 	@if($flash_deal_feature['discount'])
                                   		@if($flash_deal_feature['discount_type']=='percent')
                                   			<div class="new-label new-top">
                                      			<p> {{ $flash_deal_feature['discount'] }}% Flash</p>
                                   			</div>
                                   		@endif
                                   		@if($flash_deal_feature['discount_type']=='amount')
                                   			<div class="new-label new-top">
                                      			<p> {{ $flash_deal_feature['discount'] }}Rs Flash</p>
                                   			</div>
                                   		@endif
                                 	@else
                                 		@if($product->discount_type=='percent' && $product->discount!=0)
                                   			<div class="new-label new-top">
                                      			<p> {{ $product->discount }}% Off</p>
                                   			</div>
                                   		@endif
                                   		@if($product->discount_type=='amount' && $product->discount!=0)
                                   			<div class="new-label new-top">
                                      			<p> {{ $product->discount }}Rs Off </p>
                                   			</div>
                                   		@endif
                                 	@endif
                                @endif
                                 <div class="views">
                                    <a href="javascript:void(0)" onclick="showAddToCartModal({{ $product->id }})" data-toggle="tooltip" data-title="{{ translate('Add to cart') }}" data-placement="">
                                    <i class="far fa-shopping-cart"></i> Add To Cart
                                    </a>
                                 </div>
                                 @if (\App\Addon::where('unique_identifier', 'club_point')->first() != null && \App\Addon::where('unique_identifier', 'club_point')->first()->activated)
                                 <div class="rounded px-2 mt-2 bg-soft-primary border-soft-primary border">
                                    {{ translate('Club Point') }}:
                                    <span class="float-right">{{ $product->earn_point }}</span>
                                 </div>
                                 @endif
                              </div>
                              @endif
                           </div>
                        </div>
                        @endforeach
                     </div>
                  </div>
            </div>
            <div id="section_featured" class="tab-pane fade text-center"></div>
            <div id="section_best_selling" class="tab-pane fade text-center"></div>
         </div>
      </div>
   </div>

                                
</section>
{{-- Banner section 1 --}}

{{--<div class="hide banner">
   <div class="container-fluid">
      <div class="row">
         @if (get_setting('home_banner1_images') != null)
         @php $banner_1_imags = json_decode(get_setting('home_banner1_images')); @endphp
         @foreach ($banner_1_imags as $key => $value)
         <div class="pdd col-xl col-md-6">
            <div class="mb-3 mb-lg-0">
               <a href="/search" class="d-block text-reset">
               <img src="{{ static_asset('assets/img/placeholder-rect.jpg') }}" data-src="{{ uploaded_asset($banner_1_imags[$key]) }}" alt="{{ env('APP_NAME') }} promo" class="img-fluid lazyload">
               </a>
            </div>
         </div>
         @endforeach
         @endif
      </div>
   </div>
</div> --}}
  


{{-- Category wise Products --}}
<div id="section_home_categories"></div>


<!-- Start Testimonials -->
<link rel="stylesheet" href="{{ static_asset('assets/frontend/testimonial.min.css') }}">
<div class="testimonial">
   <div class="container">
         <div class="section-header text-center">
            <h2>What Client Say</h2>
            <div id="testimonial-slider" class="owl-carousel">
               <div class="testimonial">
                  <p class="description">
                     <i class="la la-quote-left" aria-hidden="true"></i>
                      Thank you so much for sending all our stuff. The constant advise & care of all of you wonderful people have not only helped us get nice products but also very nice friends. All the best for your business !
                  </p>
                  <div class="testimonial-content">
                     <div class="pic">
                        <img src="{{ static_asset('assets/img/profile.png') }}">
                     </div>
                     <h3 class="title">Shivi Tiwari</h3>
                  </div>
               </div>
               <div class="testimonial">
                  <p class="description">
                     <i class="la la-quote-left" aria-hidden="true"></i>
                      I had bought recently a Satin Silk Saree with zari patli pallu.i am very much satisfied with the quality of the saree.Hoping to buy again such fabulous sarees.
                  </p>
                  <div class="testimonial-content">
                     <div class="pic">
                        <img src="{{ static_asset('assets/img/profile.png') }}">
                     </div>
                     <h3 class="title">Deepika Rai</h3>
                  </div>
               </div>
               <div class="testimonial">
                  <p class="description">
                     <i class="la la-quote-left" aria-hidden="true"></i>
                      I have very good experience with The Banarasi Saree.Their products are genuine and awesome . Collections of the shop are very good and selles persons are also very good and co-operative.
                  </p>
                  <div class="testimonial-content">
                     <div class="pic">
                        <img src="{{ static_asset('assets/img/profile.png') }}">
                     </div>
                     <h3 class="title">Khushbu singh</h3>
                  </div>
               </div>
            </div>
         
      </div>
   </div>
</div>
<!-- END Top Testimonials -->
{{-- Classified Product --}}
@if(\App\BusinessSetting::where('type', 'classified_product')->first()->value == 1)
@php
$customer_products = \App\CustomerProduct::where('status', '1')->where('published', '1')->take(10)->get();
@endphp
@if (count($customer_products) > 0)
<section class="mb-4">
   <div class="container">
      <div class="px-2 py-4 px-md-4 py-md-3 bg-white shadow-sm rounded">
         <div class="d-flex mb-3 align-items-baseline border-bottom">
            <h3 class="h5 fw-700 mb-0">
               <span class="border-bottom border-primary border-width-2 pb-3 d-inline-block">{{ translate('Classified Ads') }}</span>
            </h3>
            <a href="{{ route('customer.products') }}" class="ml-auto mr-0 btn btn-primary btn-sm shadow-md">{{ translate('View More') }}</a>
         </div>
         <div class="aiz-carousel gutters-10 half-outside-arrow" data-items="6" data-xl-items="5" data-lg-items="4"  data-md-items="3" data-sm-items="2" data-xs-items="2" data-arrows='true' data-infinite='true'>
            @foreach ($customer_products as $key => $customer_product)
            <div class="carousel-box">
               <div class="aiz-card-box border border-light rounded hov-shadow-md my-2 has-transition">
                  <div class="position-relative">
                     <a href="{{ route('customer.product', $customer_product->slug) }}" class="d-block">
                     <img
                        class="img-fit lazyload mx-auto h-140px h-md-300px"
                        src="{{ static_asset('assets/img/placeholder.jpg') }}"
                        data-src="{{ uploaded_asset($customer_product->thumbnail_img) }}"
                        alt="{{ $customer_product->getTranslation('name') }}"
                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';"
                        >
                     </a>
                     <div class="absolute-top-left pt-2 pl-2">
                        @if($customer_product->conditon == 'new')
                        <span class="badge badge-inline badge-success">{{translate('new')}}</span>
                        @elseif($customer_product->conditon == 'used')
                        <span class="badge badge-inline badge-danger">{{translate('Used')}}</span>
                        @endif
                     </div>
                  </div>
                  <div class="p-md-3 p-2 text-left">
                     <div class="fs-15 mb-1">
                        <span class="fw-700 text-primary">{{ single_price($customer_product->unit_price) }}</span>
                     </div>
                     <h3 class="fw-600 fs-13 text-truncate-2 lh-1-4 mb-0">
                        <a href="{{ route('customer.product', $customer_product->slug) }}" class="d-block text-reset">{{ $customer_product->getTranslation('name') }}</a>
                     </h3>
                  </div>
               </div>
            </div>
            @endforeach
         </div>
      </div>
   </div>
</section>
@endif
@endif
{{-- Banner Section 2 --}}
<div class="mb-4">
   <div class="container">
      <div class="row gutters-10">
         @if (get_setting('home_banner2_images') != null)
         @php $banner_2_imags = json_decode(get_setting('home_banner2_images')); @endphp
         @foreach ($banner_2_imags as $key => $value)
         <div class="col-xl col-md-6">
            <div class="mb-3 mb-lg-0">
               <a href="{{ json_decode(get_setting('home_banner2_links'), true)[$key] }}" class="d-block text-reset">
               <img src="{{ static_asset('assets/img/placeholder-rect.jpg') }}" data-src="{{ uploaded_asset($banner_2_imags[$key]) }}" alt="{{ env('APP_NAME') }} promo" class="img-fluid lazyload">
               </a>
            </div>
         </div>
         @endforeach
         @endif
      </div>
   </div>
</div>
{{-- Best Seller --}}
@if (\App\BusinessSetting::where('type', 'vendor_system_activation')->first()->value == 1)
<div id="section_best_sellers"></div>
@endif
{{-- Top 10 categories and Brands --}}
<!--<div class="modal fade" id="MyModal" role="dialog" data-keyboard="false" data-backdrop="static" style="z-index:999999;">-->
<!--   <div class="modal-dialog" style="max-width: fit-content;">-->
      <!-- Modal content-->
<!--      <div class="modal-content">-->
<!--         <div class="section-full">-->
<!--            <button type="button" class="close" data-dismiss="modal">&times;</button>-->
<!--            <div class="container">-->
<!--               <div class="row">-->
<!--                  <div class="popup">-->
                     <!--<h2>For Wholesale Call us Now</h2>-->
<!--                     <img class="img-responsive" alt="thumb" src="../public/assets/img/popup.jpg">-->
                     <!--<button type="button" class="btn btn-primary call-now"><a href="tel:+91-8177062481">-->
                     <!--                   <i class="la la-phone"></i> Call Now</a>-->
                     <!--               </button>-->
<!--                  </div>-->
<!--               </div>-->
<!--            </div>-->
<!--         </div>-->
<!--      </div>-->
<!--   </div>-->
<!--</div>-->
</div>
<!-- modal is end here ---->
@endsection

<!-- modal script is end here ----->
@section('script')
<!--- modal script is here ---->

<!-- Testimonial script is Start here ----->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.js"></script>
<script>
   $(document).ready(function(){
   $("#testimonial-slider").owlCarousel({
   items:2,
   itemsDesktop:[1000,2],
   itemsDesktopSmall:[979,2],
   itemsTablet:[768,1],
   pagination:true,
   autoPlay:false
   });
   });
</script>
<!-- Testimonial script is End here ----->
<script type="text/javascript">
   $(document).ready(function() {
   if (document.cookie.indexOf("FooBar=true") == -1) {
     document.cookie = "FooBar=true; max-age=86400"; // 86400: seconds in a day
     $('#MyModal').modal('show');
   }
   });
    
    
</script>
<script>
   $(document).ready(function(){
       $('#fp').click(function() {
            $('#section_featured').html("<img src='../public/assets/img/ajax-loader.gif'>");
       $.post('{{ route('home.section.featured') }}', {_token:'{{ csrf_token() }}'}, function(data){
           $('#section_featured').html(data);
           AIZ.plugins.slickCarousel();
       });
       });
        $('#bs').click(function() {
            $('#section_featured').html("<img src='../public/assets/img/ajax-loader.gif'>");
       $.post('{{ route('home.section.best_selling') }}', {_token:'{{ csrf_token() }}'}, function(data){
           $('#section_best_selling').html(data);
           AIZ.plugins.slickCarousel();
       });
        });
       $.post('{{ route('home.section.home_categories') }}', {_token:'{{ csrf_token() }}'}, function(data){
           $('#section_home_categories').html(data);
           AIZ.plugins.slickCarousel();
       });
   
       @if (\App\BusinessSetting::where('type', 'vendor_system_activation')->first()->value == 1)
       $.post('{{ route('home.section.best_sellers') }}', {_token:'{{ csrf_token() }}'}, function(data){
           $('#section_best_sellers').html(data);
           AIZ.plugins.slickCarousel();
       });
       @endif
   });
</script>
@endsection