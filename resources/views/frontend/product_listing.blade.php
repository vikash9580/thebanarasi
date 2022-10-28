@extends('frontend.layouts.app')
@if(isset($subsubcategory_id))
@php
$meta_title = \App\SubSubCategory::find($subsubcategory_id)->meta_title;
$meta_description = \App\SubSubCategory::find($subsubcategory_id)->meta_description;
@endphp
@elseif (isset($subcategory_id))
@php
$meta_title = \App\SubCategory::find($subcategory_id)->meta_title;
$meta_description = \App\SubCategory::find($subcategory_id)->meta_description;
@endphp
@elseif (isset($category_id))
@php
$meta_title = \App\Category::find($category_id)->meta_title;
$meta_description = \App\Category::find($category_id)->meta_description;
@endphp
@elseif (isset($brand_id))
@php
$meta_title = \App\Brand::find($brand_id)->meta_title;
$meta_description = \App\Brand::find($brand_id)->meta_description;
@endphp
@else
@php
$meta_title         = get_setting('meta_title');
$meta_description   = get_setting('meta_description');
@endphp
@endif
@section('meta_title'){{ $meta_title }}@stop
@section('meta_description'){{ $meta_description }}@stop
@section('meta')
<!-- Schema.org markup for Google+ -->
<meta itemprop="name" content="{{ $meta_title }}">
<meta itemprop="description" content="{{ $meta_description }}">
<!-- Twitter Card data -->
<meta name="twitter:title" content="{{ $meta_title }}">
<meta name="twitter:description" content="{{ $meta_description }}">
<!-- Open Graph data -->
<meta property="og:title" content="{{ $meta_title }}" />
<meta property="og:description" content="{{ $meta_description }}" />
@endsection
@section('content')

<section class="product mb-4 pt-2">
   <div class="container sm-px-0">
      <form class="" id="search-form" action="{{ route('search') }}" method="GET">
         <div class="row">
            <div class="side col-xl-3">
               <div class="aiz-filter-sidebar collapse-sidebar-wrap sidebar-xl sidebar-right z-1035">
                  <div class="overlay overlay-fixed dark c-pointer" data-toggle="class-toggle" data-target=".aiz-filter-sidebar" data-same=".filter-sidebar-thumb"></div>
                  <div class="collapse-sidebar c-scrollbar-light text-left">
                     <div class="d-flex d-xl-none justify-content-between align-items-center pl-3 border-bottom">
                        <h3 class="h6 mb-0 fw-600">{{ translate('Filters') }}</h3>
                        <button type="button" class="btn btn-sm p-2 filter-sidebar-thumb" data-toggle="class-toggle" data-target=".aiz-filter-sidebar" type="button">
                        <i class="las la-times la-2x"></i>
                        </button>
                     </div>
                     <div class="rounded mb-3">
                        <div class="fs-15 fw-600 p-3 border-bottom">
                           {{ translate('Categories')}}
                        </div>
                        <div class="pt-4">
                           <ul class="list-unstyled">
                              @if(!isset($category_id) && !isset($category_id) && !isset($subcategory_id) && !isset($subsubcategory_id))
                              @foreach(\App\Category::all() as $category)
                              <li class="mb-2 ml-2">
                                 <a class="text-reset fs-14" href="{{ route('products.category', $category->slug) }}">{{ $category->getTranslation('name') }}</a>
                              </li>
                              @endforeach
                              @endif
                              @if(isset($category_id))
                              <li class="mb-2">
                                 <a class="text-reset fs-14 fw-600" href="{{ route('products') }}">
                                 <i class="las la-angle-left"></i>
                                 {{ translate('All Categories')}}
                                 </a>
                              </li>
                              <li class="mb-2">
                                 <a class="text-reset fs-14 fw-600" href="{{ route('products.category', \App\Category::find($category_id)->slug) }}">
                                 <i class="las la-angle-left"></i>
                                 {{  translate(\App\Category::find($category_id)->getTranslation('name')) }}
                                 </a>
                              </li>
                              @foreach (\App\Category::find($category_id)->subcategories as $key2 => $subcategory)
                              <li class="ml-4 mb-2">
                                 <a class="text-reset fs-14" href="{{ route('products.subcategory', $subcategory->slug) }}">{{ $subcategory->getTranslation('name') }}</a>
                              </li>
                              @endforeach
                              @endif
                              @if(isset($subcategory_id))
                              <li class="mb-2">
                                 <a class="text-reset fs-14 fw-600" href="{{ route('products') }}">
                                 <i class="las la-angle-left"></i>
                                 {{ translate('All Categories')}}
                                 </a>
                              </li>
                              <li class="mb-2">
                                 <a class="text-reset fs-14 fw-600" href="{{ route('products.category', \App\SubCategory::find($subcategory_id)->category->slug) }}">
                                 <i class="las la-angle-left"></i>
                                 {{ \App\SubCategory::find($subcategory_id)->category->getTranslation('name') }}
                                 </a>
                              </li>
                              <li class="mb-2">
                                 <a class="text-reset fs-14 fw-600" href="{{ route('products.subcategory', \App\SubCategory::find($subcategory_id)->slug) }}">
                                 <i class="las la-angle-left"></i>
                                 {{  \App\SubCategory::find($subcategory_id)->getTranslation('name') }}
                                 </a>
                              </li>
                              @foreach (\App\SubCategory::find($subcategory_id)->subsubcategories as $key3 => $subsubcategory)
                              <li class="ml-4 mb-2">
                                 <a class="text-reset fs-14" href="{{ route('products.subsubcategory', $subsubcategory->slug) }}">{{  $subsubcategory->getTranslation('name') }}</a>
                              </li>
                              @endforeach
                              @endif
                              @if(isset($subsubcategory_id))
                              <li class="mb-2">
                                 <a class="text-reset fs-14 fw-600" href="{{ route('products') }}">
                                 <i class="las la-angle-left"></i>
                                 {{ translate('All Categories')}}
                                 </a>
                              </li>
                              <li class="mb-2">
                                 <a class="text-reset fs-14 fw-600" href="{{ route('products.category', \App\SubsubCategory::find($subsubcategory_id)->subcategory->category->slug) }}">
                                 <i class="las la-angle-left"></i>
                                 {{  \App\SubSubCategory::find($subsubcategory_id)->subcategory->category->getTranslation('name') }}
                                 </a>
                              </li>
                              <li class="mb-2">
                                 <a class="text-reset fs-14 fw-600" href="{{ route('products.subcategory', \App\SubsubCategory::find($subsubcategory_id)->subcategory->slug) }}">
                                 <i class="las la-angle-left"></i>
                                 {{  \App\SubsubCategory::find($subsubcategory_id)->subcategory->getTranslation('name') }}
                                 </a>
                              </li>
                              <li class="ml-4 mb-2">
                                 <a class="text-reset fs-14" href="{{ route('products.subsubcategory', \App\SubsubCategory::find($subsubcategory_id)->slug) }}">{{  \App\SubsubCategory::find($subsubcategory_id)->getTranslation('name') }}</a>
                              </li>
                              @endif
                           </ul>
                        </div>
                     </div>
                    
                     <div class="mb-3">
                        <div class="fs-15 fw-600 p-3 border-bottom">
                           {{ translate('Price range')}}
                        </div>
                        <div class="p-3">
                           <div class="aiz-range-slider">
                              <div
                                 id="input-slider-range"
                                 data-range-value-min="@if(count(\App\Product::query()->get()) < 1) 0 @else {{ filter_products(\App\Product::query())->get()->min('unit_price') }} @endif"
                                 data-range-value-max="@if(count(\App\Product::query()->get()) < 1) 0 @else {{ filter_products(\App\Product::query())->get()->max('unit_price') }} @endif"
                                 ></div>
                              <div class="row mt-2">
                                 <div class="col-6">
                                    <span class="range-slider-value value-low fs-14 fw-600 opacity-70"
                                    @if (isset($min_price))
                                    data-range-value-low="{{ $min_price }}"
                                    @elseif($products->min('unit_price') > 0)
                                    data-range-value-low="{{ $products->min('unit_price') }}"
                                    @else
                                    data-range-value-low="0"
                                    @endif
                                    id="input-slider-range-value-low"
                                    ></span>
                                 </div>
                                 <div class="col-6 text-right">
                                    <span class="range-slider-value value-high fs-14 fw-600 opacity-70"
                                    @if (isset($max_price))
                                    data-range-value-high="{{ $max_price }}"
                                    @elseif($products->max('unit_price') > 0)
                                    data-range-value-high="{{ $products->max('unit_price') }}"
                                    @else
                                    data-range-value-high="0"
                                    @endif
                                    id="input-slider-range-value-high"
                                    ></span>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="rounded mb-3">
                        <div class="fs-15 fw-600 p-3 border-bottom">
                           {{ translate('Filter by color')}}
                        </div>
                        <div class="p-3">
                           <div class="aiz-radio-inline">
                              @foreach ($all_colors as $key => $color)
                              <label class="aiz-megabox pl-0 mr-2" data-toggle="" data-title="{{ \App\Color::where('code', $color)->first()->name }}">
                              <input
                              type="radio"
                              name="color"
                              value="{{ $color }}"
                              onchange="filter()"
                              @if(isset($selected_color) && $selected_color == $color) checked @endif
                              >
                              <span class="aiz-megabox-elem rounded d-flex align-items-center justify-content-center p-1 mb-2">
                              <span class="size-30px d-inline-block rounded" style="background: {{ $color }};" title="{{ \App\Color::where('code', $color)->first()->name }}"></span>
                              </span>
                              </label>
                              @endforeach
                           </div>
                        </div>
                     </div>
                    
                     @foreach ($attributes as $key => $attribute)
                     @if (\App\Attribute::find($attribute['id']) != null)
                     <div class="rounded mb-3">
                        <div class="fs-15 fw-600 p-3 border-bottom">
                           {{ translate('Filter by') }} {{ \App\Attribute::find($attribute['id'])->getTranslation('name') }}
                        </div>
                        <div class="p-3">
                           <div class="aiz-checkbox-list">
                              @if(array_key_exists('values', $attribute))
                              @foreach ($attribute['values'] as $key => $value)
                              @php
                              $flag = false;
                              if(isset($selected_attributes)){
                              foreach ($selected_attributes as $key => $selected_attribute) {
                              if($selected_attribute['id'] == $attribute['id']){
                              if(in_array($value, $selected_attribute['values'])){
                              $flag = true;
                              break;
                              }
                              }
                              }
                              }
                              @endphp
                              <label class="aiz-checkbox">
                              <input
                              type="checkbox"
                              name="attribute_{{ $attribute['id'] }}[]"
                              value="{{ $value }}" @if ($flag) checked @endif
                              onchange="filter()"
                              >
                              <span class="aiz-square-check"></span>
                              <span>{{ $value }}</span>
                              </label>
                              @endforeach
                              @endif
                           </div>
                        </div>
                     </div>
                     @endif
                     @endforeach
                     {{-- <button type="submit" class="btn btn-styled btn-block btn-base-4">Apply filter</button> --}}
                  </div>
               </div>
            </div>
            <div class="col-xl-9">
               <ul class="breadcrumb bg-transparent p-0">
                  <li class="breadcrumb-item opacity-50">
                     <a class="text-reset" href="{{ route('home') }}">{{ translate('Home')}}</a>
                  </li>
                  @if(!isset($category_id) && !isset($subcategory_id) && !isset($subsubcategory_id))
                  <li class="breadcrumb-item fw-600  text-dark">
                     <a class="text-reset" href="{{ route('products') }}">"{{ translate('All Categories')}}"</a>
                  </li>
                  @else
                  <li class="breadcrumb-item opacity-50">
                     <a class="text-reset" href="{{ route('products') }}">{{ translate('All Categories')}}</a>
                  </li>
                  @endif
                  @if(isset($category_id))
                  <li class="text-dark fw-600 breadcrumb-item">
                     <a class="text-reset" href="{{ route('products.category', \App\Category::find($category_id)->slug) }}">"{{ \App\Category::find($category_id)->getTranslation('name') }}"</a>
                  </li>
                  @endif
                  @if(isset($subcategory_id))
                  <li class="breadcrumb-item opacity-50">
                     <a class="text-reset" href="{{ route('products.category', \App\SubCategory::find($subcategory_id)->category->slug) }}">{{ \App\SubCategory::find($subcategory_id)->category->getTranslation('name') }}</a>
                  </li>
                  <li class="text-dark fw-600 breadcrumb-item">
                     <a class="text-reset" href="{{ route('products.subcategory', \App\SubCategory::find($subcategory_id)->slug) }}">"{{ \App\SubCategory::find($subcategory_id)->getTranslation('name') }}"</a>
                  </li>
                  @endif
                  @if(isset($subsubcategory_id))
                  <li class="breadcrumb-item opacity-50">
                     <a class="text-reset" href="{{ route('products.category', \App\SubSubCategory::find($subsubcategory_id)->subcategory->category->slug) }}">{{ \App\SubSubCategory::find($subsubcategory_id)->subcategory->category->getTranslation('name') }}</a>
                  </li>
                  <li class="breadcrumb-item opacity-50">
                     <a class="text-reset" href="{{ route('products.subcategory', \App\SubsubCategory::find($subsubcategory_id)->subcategory->slug) }}">{{ \App\SubsubCategory::find($subsubcategory_id)->subcategory->getTranslation('name') }}</a>
                  </li>
                  <li class="text-dark fw-600 breadcrumb-item">
                     <a class="text-reset" href="{{ route('products.subsubcategory', \App\SubSubCategory::find($subsubcategory_id)->slug) }}">"{{ \App\SubSubCategory::find($subsubcategory_id)->getTranslation('name') }}"</a>
                  </li>
                  @endif
               </ul>
               @isset($category_id)
               <input type="hidden" name="category" value="{{ \App\Category::find($category_id)->slug }}">
               @endisset
               @isset($subcategory_id)
               <input type="hidden" name="subcategory" value="{{ \App\SubCategory::find($subcategory_id)->slug }}">
               @endisset
               @isset($subsubcategory_id)
               <input type="hidden" name="subsubcategory" value="{{ \App\SubSubCategory::find($subsubcategory_id)->slug }}">
               @endisset
              
                    
               <div class="">
                  <div class="d-flex">
                     <div class="form-group w-200px d-md-block">
                        <label class="mb-0 opacity-50">{{ translate('Sort by')}}</label>
                        <select class="form-control form-control-sm aiz-selectpicker" name="sort_by" onchange="filter()">
                        <option value="1" @isset($sort_by) @if ($sort_by == '1') selected @endif @endisset>{{ translate('Newest')}}</option>
                        <option value="2" @isset($sort_by) @if ($sort_by == '2') selected @endif @endisset>{{ translate('Oldest')}}</option>
                        <option value="3" @isset($sort_by) @if ($sort_by == '3') selected @endif @endisset>{{ translate('Price low to high')}}</option>
                        <option value="4" @isset($sort_by) @if ($sort_by == '4') selected @endif @endisset>{{ translate('Price high to low')}}</option>
                        </select>
                     </div>
                     <div class="form-group ml-auto mr-0 w-200px d-none d-md-block">
                        <label class="mb-0 opacity-50">{{ translate('Brands')}}</label>
                        <select class="form-control form-control-sm aiz-selectpicker" data-live-search="true" name="brand" onchange="filter()">
                           <option value="">{{ translate('All Brands')}}</option>
                           @foreach (\App\Brand::all() as $brand)
                           <option value="{{ $brand->slug }}" @isset($brand_id) @if ($brand_id == $brand->id) selected @endif @endisset>{{ $brand->getTranslation('name') }}</option>
                           @endforeach
                        </select>
                                              
                       

                     </div>
                     <div class="form-group ml-2 mr-0 w-200px d-none d-md-block">
                        <label class="mb-0 opacity-50">{{ translate('Sellers')}}</label>
                        <select class="form-control form-control-sm aiz-selectpicker" data-live-search="true" name="seller_id" onchange="filter()">
                           <option value="">{{ translate('All Sellers')}}</option>
                           @foreach (\App\Seller::all() as $key => $seller)
                           @if ($seller->user != null && $seller->user->shop != null)
                           <option value="{{ $seller->id }}" @isset($seller_id) @if ($seller_id == $seller->id) selected @endif @endisset>{{ $seller->user->shop->name }}</option>
                           @endif
                           @endforeach
                        </select>
                     </div>
                     <div class="d-xl-none ml-auto ml-md-3 mr-0 form-group align-self-end">
                        <button type="button" class="btn btn-icon p-0" data-toggle="class-toggle" data-target=".aiz-filter-sidebar">
                        <i class="la la-filter la-2x"></i>
                        </button>
                     </div>
                  </div>
               </div>
             
               <input type="hidden" name="min_price" value="">
               <input type="hidden" name="max_price" value="">
               <div class="scrolling-pagination">
               <div class="row gutters-5 row-cols-xxl-3 row-cols-xl-3 row-cols-lg-4 row-cols-md-3 row-cols-2 ">
                  @foreach ($products as $key => $product)
                  <div class="col" style="padding:0;">
                     <div class="aiz-card-box text-center">
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
                              <a href="javascript:void(0)" onclick="addToWishList({{ $product->id }})" data-toggle="tooltip" data-title="{{ translate('Add to wishlist') }}" data-placement="left">
                              <i class="fa fa-heart"></i>
                              </a> 
                           </div>
                        </div>
                        <div class="p-md-3 p-2 text-center">
                          
                           @if(Auth::check())
                           @if(Auth::user()->is_wholesale_customer==1 && Auth::user()->validate_wholesale_customer==1)
                           <h3 class="text-truncate-2 lh-1-4 mb-0 text-left">
                              <a href="{{ route('product', $product->slug) }}" class="d-block text-reset">{{ $product->getTranslation('name') }}</a>
                           </h3>
                           <div class="rating">
                              <!--{{ renderStarRating($product->rating) }}-->
                              @php
                              $flash_deal_search = \App\FlashDeal::where('flash_deals.status', 1)->where('flash_deals.featured', 1)->where('flash_deal_products.product_id', $product->id)->leftJoin('flash_deal_products', 'flash_deals.id', '=', 'flash_deal_products.flash_deal_id')->first();
                              @endphp
                           </div>
                           <div class="new-label new-top">
                              @if($flash_deal_search['wholesale_discount'])
                              <p>@if($flash_deal_search['wholesale_discount_type']=='percent') {{ $flash_deal_search['wholesale_discount'] }}% Flash @endif</p>
                              <p>@if($flash_deal_search['wholesale_discount_type']=='amount') {{ $flash_deal_search['wholesale_discount'] }}Rs Flash @endif</p>
                              @else
                              <p>@if($product->wholesale_discount_type=='percent' && $product->wholesale_discount!=0) {{ $product->wholesale_discount }}% Off @endif</p>
                              <p>@if($product->wholesale_discount_type=='amount' && $product->wholesale_discount!=0) {{ $product->wholesale_discount }}Rs Off @endif</p>
                              @endif
                           </div>
                           <div class="info">
                              <span>{{ home_discounted_base_price_wholesale($product->id) }}</span>&nbsp;
                              @if(home_base_price_wholesale($product->id) != home_discounted_base_price_wholesale($product->id))
                              <del class="text-primary mr-1">{{ home_base_price_wholesale($product->id) }}</del>
                              @endif
                           </div>
                           @if (\App\Addon::where('unique_identifier', 'club_point')->first() != null && \App\Addon::where('unique_identifier', 'club_point')->first()->activated)
                           <div class="rounded px-2 mt-2 bg-soft-primary border-soft-primary border">
                              {{ translate('Club Point') }}:
                              <span class="float-right">{{ $product->earn_point }}</span>
                           </div>
                           @endif
                           @else
                           <h3 class="text-truncate-2 lh-1-4 mb-0 text-left">
                              <a href="{{ route('product', $product->slug) }}" class="d-block text-reset">{{ $product->getTranslation('name') }}</a>
                           </h3>
                           <div class="rating">
                              <!--{{ renderStarRating($product->rating) }}-->
                              @php
                              $flash_deal_search = \App\FlashDeal::where('flash_deals.status', 1)->where('flash_deals.featured', 1)->where('flash_deal_products.product_id', $product->id)->leftJoin('flash_deal_products', 'flash_deals.id', '=', 'flash_deal_products.flash_deal_id')->first();
                              @endphp
                           </div>$flash_deal_search
                          @if($flash_deal_search)
                           @if($flash_deal_search['discount'])
                           @if($flash_deal_search['discount_type']=='percent')
                           <div class="new-label new-top">
                              <p> {{ $flash_deal_search['discount'] }}% Flash</p>
                           </div>
                           @endif
                           @if($flash_deal_search['discount_type']=='amount')
                           <div class="new-label new-top">
                              <p> {{ $flash_deal_search['discount'] }}Rs Flash</p>
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
                              <span>{{ home_discounted_base_price($product->id) }}</span>
                              @if(home_base_price($product->id) != home_discounted_base_price($product->id))
                              <del class="text-primary mr-1">{{ home_base_price($product->id) }}</del>
                              @endif
                           </div>
                           @if (\App\Addon::where('unique_identifier', 'club_point')->first() != null && \App\Addon::where('unique_identifier', 'club_point')->first()->activated)
                           <div class="rounded px-2 mt-2 bg-soft-primary border-soft-primary border">
                              {{ translate('Club Point') }}:
                              <span class="float-right">{{ $product->earn_point }}</span>
                           </div>
                           @endif
                           @endif
                          @endif
                           @else
                          
                          
                           <h3 class="text-truncate-2 lh-1-4 mb-0 text-left">
                              <a href="{{ route('product', $product->slug) }}" class="d-block text-reset">{{ $product->getTranslation('name') }}</a>
                           </h3>
                           <div class="rating">
                              <!--{{ renderStarRating($product->rating) }}-->
                              @php
                              $flash_deal_search = \App\FlashDeal::where('flash_deals.status', 1)->where('flash_deals.featured', 1)->where('flash_deal_products.product_id', $product->id)->leftJoin('flash_deal_products', 'flash_deals.id', '=', 'flash_deal_products.flash_deal_id')->first();
                              @endphp
                           </div>
                          	@if($flash_deal_search)
                           		@if($flash_deal_search['discount'])
                           			@if($flash_deal_search['discount_type']=='percent')
                           				<div class="new-label new-top">
                              				<p> {{ $flash_deal_search['discount'] }}% Flash</p>
                           				</div>
                           			@endif
                                   @if($flash_deal_search['discount_type']=='amount')
                                   <div class="new-label new-top">
                                      <p> {{ $flash_deal_search['discount'] }}Rs Flash</p>
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
                              <span>{{ home_discounted_base_price($product->id) }}</span>
                              @if(home_base_price($product->id) != home_discounted_base_price($product->id))
                              <del class="text-primary mr-1">{{ home_base_price($product->id) }}</del>
                              @endif
                           </div>
                           @if (\App\Addon::where('unique_identifier', 'club_point')->first() != null && \App\Addon::where('unique_identifier', 'club_point')->first()->activated)
                           <div class="rounded px-2 mt-2 bg-soft-primary border-soft-primary border">
                              {{ translate('Club Point') }}:
                              <span class="float-right">{{ $product->earn_point }}</span>
                           </div>
                           @endif
                           @endif
                        </div>
                     </div>
                  </div>
                  @endforeach
                     {{ $products->links() }}
                    </div>
               </div>
               
                 
              
            </div>
         </div>
      </form>
   </div>
</section>
@endsection
@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jscroll/2.4.1/jquery.jscroll.min.js"></script>
<script type="text/javascript">
    $('ul.pagination').hide();
    $(function() {
        $('.scrolling-pagination').jscroll({
            autoTrigger: true,
            padding: 0,
            nextSelector: '.pagination li.active + li a',
            contentSelector: 'div.scrolling-pagination',
            callback: function() {
                $('ul.pagination').remove();
            }
        });
    });
</script>
<script type="text/javascript">
   function filter(){
       $('#search-form').submit();
   }
   function rangefilter(arg){
       $('input[name=min_price]').val(arg[0]);
       $('input[name=max_price]').val(arg[1]);
       filter();
   }
</script>
@endsection