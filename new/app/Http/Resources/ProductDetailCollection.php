<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Models\Review;
use App\Models\Attribute;
use App\Models\ProductStock;
use App\Models\Color;
class ProductDetailCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function($data) {
                return [
                    'id' => (integer) $data->id,
                    'name' => $data->name,
                    'added_by' => $data->added_by,
                    'user' => [
                        'name' => $data->user->name,
                        'email' => $data->user->email,
                        'avatar' => $data->user->avatar,
                        'avatar_original' => api_asset($data->user->avatar_original),
                        'shop_name' => $data->added_by == 'admin' ? '' : $data->user->shop->name,
                        'shop_logo' => $data->added_by == 'admin' ? '' : uploaded_asset($data->user->shop->logo),
                        'shop_link' => $data->added_by == 'admin' ? '' : route('shops.info', $data->user->shop->id)
                    ],
                    'category' => [
                        'name' => $data->category->name,
                        'banner' => api_asset($data->category->banner),
                        'icon' => $data->category->icon,
                        'links' => [
                            'products' => route('api.products.category', $data->category_id),
                            'sub_categories' => route('subCategories.index', $data->category_id)
                        ]
                    ],
                    'sub_category' => [
                        'name' => $data->subCategory != null ? $data->subCategory->name : null,
                        'links' => [
                            'products' => $data->subCategory != null ? route('products.subCategory', $data->subcategory_id) : null
                        ]
                    ],
                    'brand' => [
                        'name' => $data->brand != null ? $data->brand->name : null,
                        'logo' => $data->brand != null ? api_asset($data->brand->logo) : null,
                        'links' => [
                            'products' => $data->brand != null ? route('api.products.brand', $data->brand_id) : null
                        ]
                    ],
                    'photos' => $this->convertPhotos(explode(',', $data->photos)),
                    'thumbnail_image' => api_asset($data->thumbnail_img),
                    'tags' => explode(',', $data->tags),
                    'price_lower' => (double) explode('-', homeDiscountedPrice($data->id))[0],
                    'price_higher' => (double) explode('-', homeDiscountedPrice($data->id))[1],
                    'choice_options' => $this->convertToChoiceOptions(json_decode($data->choice_options)),
                    'colors' => $this->convertToColor(json_decode($data->colors)),
                    'todays_deal' => (integer) $data->todays_deal,
                    'featured' => (integer) $data->featured,
                    'current_stock' => (integer) $data->current_stock,
                    'unit' => $data->unit,
                    'discount' => (double) $data->discount,
                    'discount_type' => $data->discount_type,
                    'tax' => (double) $data->tax,
                    'tax_type' => $data->tax_type,
                    'shipping_type' => $data->shipping_type,
                    'shipping_cost' => (double) $data->shipping_cost,
                    'number_of_sales' => (integer) $data->num_of_sale,
                    'rating' => (double) $data->rating,
                    'rating_count' => (integer) Review::where(['product_id' => $data->id])->count(),
                    'ratings'=>$this->ratings($data->id),
                    'description' => $data->description,
                    'min_qty' => $data->min_qty,
                    'max_qty' => $data->max_qty,
                    'varient'=>$this->convertToVarient($data->id,$data->discount_type,$data->discount),
                    'links' => [
                        'reviews' => route('api.reviews.index', $data->id),
                        'related' => route('products.related', $data->id)
                    ]
                ];
            })
        ];
    }

    public function with($request)
    {
        return [
            'success' => true,
            'status' => 200
        ];
    }
    
    

    protected function convertToChoiceOptions($data){
        $result = array();
        foreach ($data as $key => $choice) {
            $item['name'] = $choice->attribute_id;
            $item['title'] = Attribute::find($choice->attribute_id)->name;
            $item['options'] = $choice->values;
            array_push($result, $item);
        }
        return $result;
    }
    
    protected function convertToColor($data){
        $colors=array();
        foreach ($data as $color) {
            array_push($colors, Color::where('code',$color)->first(['name','code']));
        }
        return $colors;
        
    }
    
    protected function convertToVarient($data,$discount_type,$discount)
    {
        $list=ProductStock::where('product_id',$data)->get();
        $total=count($list);
        for($i=0;$i<$total;$i++)
        {   
            if($discount_type=='percent')
            {
            $list[$i]['discount_price']=$list[$i]['price']-($list[$i]['price']*$discount/100);
            }
            else
            {
                $list[$i]['discount_price']=$list[$i]['price']-$discount;
            }
            $list[$i]['photos']=[];
        } 
        return $list;
    }
    
    protected function ratings($data)
    {
       $one=count(Review::where('product_id',$data)->where('rating',1)->get());
       $two=count(Review::where('product_id',$data)->where('rating',2)->get());
       $three=count(Review::where('product_id',$data)->where('rating',3)->get());
       $four=count(Review::where('product_id',$data)->where('rating',4)->get());
       $five=count(Review::where('product_id',$data)->where('rating',5)->get());
       
       return ['one'=>$one,'two'=>$two,'three'=>$three,'four'=>$four,'five'=>$five];
        
    }

    protected function convertPhotos($data){
        $result = array();
        foreach ($data as $key => $item) {
            array_push($result, api_asset($item));
        }
        return $result;
    }
}
