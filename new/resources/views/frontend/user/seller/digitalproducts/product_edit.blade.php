@extends('frontend.layouts.app')

@section('content')

    <section class="py-5">
        <div class="container">
            <div class="d-flex align-items-start">
                @include('frontend.inc.user_side_nav')

                <div class="aiz-user-panel">
                    <div class="aiz-titlebar mt-2 mb-4">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h1 class="h3">{{ translate('Products') }}</h1>
                            </div>
                        </div>
                    </div>
                    <form class="" action="{{route('digitalproducts.update', $product->id)}}" method="POST" enctype="multipart/form-data" id="choice_form">
                        <input name="_method" type="hidden" value="PATCH">
                        <input type="hidden" name="id" value="{{ $product->id }}">
                        <input type="hidden" name="lang" value="{{ $lang }}">
                        @csrf
                		<input type="hidden" name="added_by" value="seller">


                        <div class="card mb-0 border-bottom-0">
                            <div class="card-body p-0">
                                <ul class="nav nav-tabs nav-fill border-light">
                                    @foreach (\App\Language::all() as $key => $language)
                                        <li class="nav-item">
                                            <a class="nav-link text-reset @if ($language->code == $lang) active @else bg-soft-dark border-light border-left-0 @endif py-3" href="{{ route('seller.digitalproducts.edit', ['id'=>$product->id, 'lang'=> $language->code] ) }}">
                                                <img src="{{ static_asset('assets/img/flags/'.$language->code.'.png') }}" height="11" class="mr-1">
                                                <span>{{$language->name}}</span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0 h6">{{translate('General')}}</h5>
                            </div>
                            <div class="card-body">
                                <div class="form-group row">
                                    <label class="col-lg-2 col-from-label">{{translate('Product Name')}}</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" name="name" placeholder="{{translate('Product Name')}}" value="{{$product->getTranslation('name', $lang)}}" required>
                                    </div>
                                </div>
                                <div class="form-group row" id="category">
                                    <label class="col-lg-2 col-from-label">{{translate('Category')}}</label>
                                    <div class="col-lg-8">
                                        <select class="form-control aiz-selectpicker" name="category_id" id="category_id" required>
                                            <option>{{translate('Select an option') }}</option>
                                            @foreach(\App\Category::where('digital', 1)->get() as $category)
                                                <option value="{{ $category->id }}" <?php if($product->category_id == $category->id) echo "selected"; ?> >{{ $category->getTranslation('name') }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row" id="subcategory">
                                    <label class="col-lg-2 col-from-label">{{translate('Subcategory')}}</label>
                                    <div class="col-lg-8">
                                        <select class="form-control aiz-selectpicker" name="subcategory_id" id="subcategory_id" required>

                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row" id="subsubcategory">
                                    <label class="col-lg-2 col-from-label">{{translate('Sub Subcategory')}}</label>
                                    <div class="col-lg-8">
                                        <select class="form-control aiz-selectpicker" name="subsubcategory_id" id="subsubcategory_id">

                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-2 col-from-label">{{translate('Product File')}}</label>
                                    <div class="col-lg-8">
                                        <div class="custom-file">
                                            <label class="custom-file-label">
                                                <input type="file" name="file" class="custom-file-input">
                                                <span class="custom-file-name">{{ translate('Choose file') }}</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-2 col-from-label">{{translate('Tags')}}</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control aiz-tag-input" name="tags[]" id="tags" value="{{ $product->tags }}" placeholder="{{ translate('Type to add a tag') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0 h6">{{translate('Images')}}</h5>
                            </div>
                            <div class="card-body">
                                <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="signinSrEmail">{{translate('Main Images')}}</label>
                                    <div class="col-md-8">
                                        <div class="input-group" data-toggle="aizuploader" data-type="image" data-multiple="true">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
                                            </div>
                                            <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                            <input type="hidden" name="photos" value="{{ $product->photos }}" class="selected-files" required>
                                        </div>
                                        <div class="file-preview box sm">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="signinSrEmail">{{translate('Thumbnail Image')}} <small>(290x300)</small></label>
                                    <div class="col-md-8">
                                        <div class="input-group" data-toggle="aizuploader" data-type="image" data-multiple="false">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
                                            </div>
                                            <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                            <input type="hidden" name="thumbnail_img" value="{{ $product->thumbnail_img }}" class="selected-files" required>
                                        </div>
                                        <div class="file-preview box sm">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0 h6">{{translate('Meta Tags')}}</h5>
                            </div>
                            <div class="card-body">
                                <div class="form-group row">
                                    <label class="col-lg-2 col-from-label">{{translate('Slug')}}</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" name="slug" value="{{ $product->slug }}" placeholder="{{translate('Slug')}}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-2 col-from-label">{{translate('Meta Title')}}</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" name="meta_title" value="{{ $product->meta_title }}" placeholder="{{translate('Meta Title')}}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-2 col-from-label">{{translate('Description')}}</label>
                                    <div class="col-lg-8">
                                        <textarea name="meta_description" rows="8" class="form-control">{{ $product->meta_description }}</textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="signinSrEmail">{{ translate('Meta Image') }}</label>
                                    <div class="col-md-8">
                                        <div class="input-group" data-toggle="aizuploader" data-type="image" data-multiple="false">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
                                            </div>
                                            <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                            <input type="hidden" name="meta_img" value="{{ $product->meta_img }}" class="selected-files">
                                        </div>
                                        <div class="file-preview box sm">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0 h6">{{translate('Price')}}</h5>
                            </div>
                            <div class="card-body">
                                <div class="form-group row">
                                    <label class="col-lg-2 col-from-label">{{translate('Unit price')}}</label>
                                    <div class="col-lg-8">
                                        <input type="text" placeholder="{{translate('Unit price')}}" name="unit_price" class="form-control" value="{{$product->unit_price}}" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-2 col-from-label">{{translate('Purchase price')}}</label>
                                    <div class="col-lg-8">
                                        <input type="number" min="0" step="0.01" placeholder="{{translate('Purchase price')}}" name="purchase_price" class="form-control" value="{{$product->purchase_price}}" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-2 col-from-label">{{translate('Tax')}}</label>
                                    <div class="col-lg-6">
                                        <input type="number" min="0" step="0.01" placeholder="{{translate('tax')}}" name="tax" class="form-control" value="{{$product->tax}}" required>
                                    </div>
                                    <div class="col-md-2">
                                        <select class="form-control aiz-selectpicker" name="tax_type" required>
                                            <option value="amount" <?php if($product->tax_type == 'amount') echo "selected";?> >{{translate('Flat')}}</option>
                                            <option value="percent" <?php if($product->tax_type == 'percent') echo "selected";?> >{{translate('Percent')}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-2 col-from-label">{{translate('Discount')}}</label>
                                    <div class="col-lg-6">
                                        <input type="number" min="0" step="0.01" placeholder="{{translate('Discount')}}" name="discount" class="form-control" value="{{ $product->discount }}" required>
                                    </div>
                                    <div class="col-lg-2">
                                        <select class="form-control aiz-selectpicker" name="discount_type" required>
                                            <option value="amount" <?php if($product->discount_type == 'amount') echo "selected";?> >{{translate('Flat')}}</option>
                                            <option value="percent" <?php if($product->discount_type == 'percent') echo "selected";?> >{{translate('Percent')}}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0 h6">{{translate('Description')}}</h5>
                            </div>
                            <div class="card-body">
                                <div class="form-group row">
                                    <label class="col-lg-2 col-from-label">{{translate('Description')}}</label>
                                    <div class="col-lg-9">
                                        <textarea class="aiz-text-editor" name="description">{{ $product->getTranslation('description', $lang) }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-0 text-right">
                            <button type="submit" class="btn btn-primary">{{translate('Save')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal -->
    <div class="modal fade" id="categorySelectModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="exampleModalLabel">{{translate('Select Category')}}</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="target-category heading-6">
                        <span class="mr-3">{{translate('Target Category')}}:</span>
                        <span>{{translate('Category')}} > {{translate('Subcategory')}} > {{translate('Sub Subcategory')}}</span>
                    </div>
                    <div class="row no-gutters modal-categories mt-4 mb-2">
                        <div class="col-4">
                            <div class="modal-category-box c-scrollbar">
                                <div class="sort-by-box">
                                    <form role="form" class="search-widget">
                                        <input class="form-control input-lg" type="text" placeholder="{{ translate('Search Category') }}" onkeyup="filterListItems(this, 'categories')">
                                        <button type="button" class="btn-inner">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </form>
                                </div>
                                <div class="modal-category-list has-right-arrow">
                                    <ul id="categories">
                                        @foreach ($categories as $key => $category)
                                            <li onclick="get_subcategories_by_category(this, {{ $category->id }})">{{ $category->getTranslation('name') }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="modal-category-box c-scrollbar" id="subcategory_list">
                                <div class="sort-by-box">
                                    <form role="form" class="search-widget">
                                        <input class="form-control input-lg" type="text" placeholder="{{ translate('Search SubCategory') }}" onkeyup="filterListItems(this, 'subcategories')">
                                        <button type="button" class="btn-inner">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </form>
                                </div>
                                <div class="modal-category-list has-right-arrow">
                                    <ul id="subcategories">

                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="modal-category-box c-scrollbar" id="subsubcategory_list">
                                <div class="sort-by-box">
                                    <form role="form" class="search-widget">
                                        <input class="form-control input-lg" type="text" placeholder="{{ translate('Search SubSubCategory') }}" onkeyup="filterListItems(this, 'subsubcategories')">
                                        <button type="button" class="btn-inner">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </form>
                                </div>
                                <div class="modal-category-list">
                                    <ul id="subsubcategories">

                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{translate('Cancel')}}</button>
                    <button type="button" class="btn btn-primary" onclick="closeModal()">{{translate('Confirm')}}</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script type="text/javascript">

        function get_subcategories_by_category(){
            var category_id = $('#category_id').val();
            $.post('{{ route('subcategories.get_subcategories_by_category') }}',{_token:'{{ csrf_token() }}', category_id:category_id}, function(data){
                $('#subcategory_id').html(null);
                for (var i = 0; i < data.length; i++) {
                    $('#subcategory_id').append($('<option>', {
                        value: data[i].id,
                        text: data[i].name
                    }));
                }
                $("#subcategory_id > option").each(function() {
                    if(this.value == '{{$product->subcategory_id}}'){
                        $("#subcategory_id").val(this.value).change();
                    }
                });

                AIZ.plugins.bootstrapSelect('refresh');

                get_subsubcategories_by_subcategory();
            });
        }

        function get_subsubcategories_by_subcategory(){
            var subcategory_id = $('#subcategory_id').val();
            $.post('{{ route('subsubcategories.get_subsubcategories_by_subcategory') }}',{_token:'{{ csrf_token() }}', subcategory_id:subcategory_id}, function(data){
                $('#subsubcategory_id').html(null);
                for (var i = 0; i < data.length; i++) {
                    $('#subsubcategory_id').append($('<option>', {
                        value: data[i].id,
                        text: data[i].name
                    }));
                }
                $("#subsubcategory_id > option").each(function() {
                    if(this.value == '{{$product->subsubcategory_id}}'){
                        $("#subsubcategory_id").val(this.value).change();
                    }
                });

                AIZ.plugins.bootstrapSelect('refresh');
            });
        }


        function list_item_highlight(el){
            $(el).parent().children().each(function(){
                $(this).removeClass('selected');
            });
            $(el).addClass('selected');
        }



        function filterListItems(el, list){
            filter = el.value.toUpperCase();
            li = $('#'+list).children();
            for (i = 0; i < li.length; i++) {
                if ($(li[i]).html().toUpperCase().indexOf(filter) > -1) {
                    $(li[i]).show();
                } else {
                    $(li[i]).hide();
                }
            }
        }

        function closeModal(){
            if(category_id > 0 && subcategory_id > 0 && subsubcategory_id > 0){
                $('#category_id').val(category_id);
                $('#subcategory_id').val(subcategory_id);
                $('#subsubcategory_id').val(subsubcategory_id);
                $('#product_category').html(category_name+'>'+subcategory_name+'>'+subsubcategory_name);
                $('#categorySelectModal').modal('hide');
            }
            else{
                alert('Please choose categories...');
                console.log(category_id);
                console.log(subcategory_id);
                console.log(subsubcategory_id);
            }
        }


    	function delete_row(em){
    		$(em).closest('.row').remove();
    		update_sku();
    	}


        $(document).ready(function(){
            $('#container').removeClass('mainnav-lg').addClass('mainnav-sm');
            get_subcategories_by_category();
        });

        $('#category_id').on('change', function() {
            get_subcategories_by_category();
        });

        $('#subcategory_id').on('change', function() {
            get_subsubcategories_by_subcategory();
        });
    </script>
@endsection
