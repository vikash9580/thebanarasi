@php $home_categories = json_decode(get_setting('home_categories')); @endphp
@foreach ($home_categories as $key => $value)
    @php 
     $result=explode("_",$value);
     $cat = $result[0];
     $id = $result[1];
    @endphp
    @if($cat=="cat")
     @php $category = \App\Category::find($id); @endphp
     <section class="product mb-4">
        <div class="container-fluid">
            <div class="px-2 py-4 px-md-4 py-md-3">
                <div class="d-flex mb-3 align-items-baseline ">
                  <div class="section-header">
                     <h2>{{ $category->getTranslation('name') }}</h2>
                    </div>
                    <a href="{{ route('products.category', $category->slug) }}" class="ml-auto cell">{{ translate('View More') }}</a>
               </div>
                <div class="aiz-carousel gutters-10 half-outside-arrow" data-items="6" data-xl-items="5" data-lg-items="4"  data-md-items="3" data-sm-items="2" data-xs-items="2" data-arrows='true' data-infinite='true'>
                    @foreach (get_cached_products($category->id) as $key => $product)
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
                            
                             <h3 class="text-truncate-2 lh-1-4 mb-0">
                                <a href="{{ route('product', $product->slug) }}" class="d-block text-reset">{{  $product->getTranslation('name')  }}</a>
                            </h3>

                        
                          
                            <div class="rating rating-sm mt-1">
                                 
                                  @php
                                  $flash_deal_feature= \App\FlashDeal::where('flash_deals.status', 1)->where('flash_deals.featured', 1)->where('flash_deal_products.product_id', $product->id)->leftJoin('flash_deal_products', 'flash_deals.id', '=', 'flash_deal_products.flash_deal_id')->first();
                                  
                                  @endphp
                                  
                                    </div>
                                  @if($flash_deal_feature)
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
                            
                              
                               
                            <div class="info">
                               
                              @if(Auth::user()->is_wholesale_customer==1 && Auth::user()->validate_wholesale_customer==1)
                               <span>{{ home_discounted_base_price_wholesale($product->id) }}</span>
                              @else
                                <span >{{ home_discounted_base_price($product->id) }}</span>
                                @endif
                                
                                    @if(Auth::user()->is_wholesale_customer==1 && Auth::user()->validate_wholesale_customer==1)
                                     <del class="text-primary mr-1" >{{ home_base_price_wholesale($product->id) }}</del>
                                 @else  
                                @if(home_base_price($product->id) != home_discounted_base_price($product->id))
                                    <del class="text-primary mr-1" >{{ home_base_price($product->id) }}</del>
                                @endif
                                 @endif
                             
                              
                            </div>
                            
                            <div class="views">
                                        
                                   <a href="javascript:void(0)" onclick="showAddToCartModal({{ $product->id }})" data-title="{{ translate('Add to cart') }}" data-placement="left">
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
                               
                                <span>{{ home_discounted_base_price($product->id) }}</span>&nbsp;
                                
                                @if(home_base_price($product->id) != home_discounted_base_price($product->id))
                                    <del class="text-primary mr-1" >{{ home_base_price($product->id) }}</del>
                                @endif
                               
                            </div>
                            
                              <div class="views">
                                        
                                   <a href="javascript:void(0)" onclick="showAddToCartModal({{ $product->id }})" data-title="{{ translate('Add to cart') }}" data-placement="left">
                                   <i class="far fa-shopping-cart"></i> Add To Cart</a>
                                        
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
     </section>
    @endif
    @if($cat=="sub")
     @php $subcategory = \App\SubCategory::find($id); @endphp
     <section class="product mb-4">
        <div class="container-fluid">
            <div class="px-2 py-4 px-md-4 py-md-3">
                <div class="d-flex mb-3 align-items-baseline ">
                  <div class="section-header">
                     <h2>{{ $subcategory->name }}</h2>
                    </div>
                    <a href="{{ route('products.subcategory', $subcategory->slug) }}" class="ml-auto cell">{{ translate('View More') }}</a>
               </div>
                <div class="aiz-carousel gutters-10 half-outside-arrow" data-items="6" data-xl-items="5" data-lg-items="4"  data-md-items="3" data-sm-items="2" data-xs-items="2" data-arrows='true' data-infinite='true'>
                    @foreach (get_cached_sub_category_products($subcategory->id) as $key => $product)
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
                            
                             <h3 class="text-truncate-2 lh-1-4 mb-0">
                                <a href="{{ route('product', $product->slug) }}" class="d-block text-reset">{{  $product->getTranslation('name')  }}</a>
                            </h3>

                        
                          
                            <div class="rating rating-sm mt-1">
                                 
                                  @php
                                  $flash_deal_feature= \App\FlashDeal::where('flash_deals.status', 1)->where('flash_deals.featured', 1)->where('flash_deal_products.product_id', $product->id)->leftJoin('flash_deal_products', 'flash_deals.id', '=', 'flash_deal_products.flash_deal_id')->first();
                                  
                                  @endphp
                                  
                                    </div>
                                  @if($flash_deal_feature)
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
                            
                              
                               
                            <div class="info">
                               
                              @if(Auth::user()->is_wholesale_customer==1 && Auth::user()->validate_wholesale_customer==1)
                               <span>{{ home_discounted_base_price_wholesale($product->id) }}</span>
                              @else
                                <span >{{ home_discounted_base_price($product->id) }}</span>
                                @endif
                                
                                    @if(Auth::user()->is_wholesale_customer==1 && Auth::user()->validate_wholesale_customer==1)
                                     <del class="text-primary mr-1" >{{ home_base_price_wholesale($product->id) }}</del>
                                 @else  
                                @if(home_base_price($product->id) != home_discounted_base_price($product->id))
                                    <del class="text-primary mr-1" >{{ home_base_price($product->id) }}</del>
                                @endif
                                 @endif
                             
                              
                            </div>
                            
                            <div class="views">
                                        
                                   <a href="javascript:void(0)" onclick="showAddToCartModal({{ $product->id }})" data-title="{{ translate('Add to cart') }}" data-placement="left">
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
                               
                                <span>{{ home_discounted_base_price($product->id) }}</span>&nbsp;
                                
                                @if(home_base_price($product->id) != home_discounted_base_price($product->id))
                                    <del class="text-primary mr-1" >{{ home_base_price($product->id) }}</del>
                                @endif
                               
                            </div>
                            
                              <div class="views">
                                        
                                   <a href="javascript:void(0)" onclick="showAddToCartModal({{ $product->id }})" data-title="{{ translate('Add to cart') }}" data-placement="left">
                                   <i class="far fa-shopping-cart"></i> Add To Cart</a>
                                        
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
     </section>
    @endif
@endforeach
