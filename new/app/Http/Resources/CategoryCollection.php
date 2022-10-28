<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Product;
use App\Http\Resources\ProductCollection;

class CategoryCollection extends ResourceCollection
{
    public function product($id)
    {
      $list =  Product::where('category_id', $id)->inRandomOrder()->get()->take(10);
      foreach($list as $data){
          $data->thumbnail_img=api_asset($data->thumbnail_img);
          $data->base_price = (double) homeBasePrice($data->id);
          $data->base_discounted_price = (double) homeDiscountedBasePrice($data->id);
      }
        return $list;
        
       // return new ProductCollection(Product::where('category_id', $id)->get());
    }
    
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function($data) {
                return [
                    'name' => $data->name,
                    'banner' => api_asset($data->banner),
                    'icon' => api_asset($data->icon),
                    // 'brands' => brandsOfCategory($data->id),
                    'product'=>$this->product($data->id),
                    'links' => [
                        'products' => route('api.products.category', $data->id),
                        'sub_categories' => route('subCategories.index', $data->id)
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
}
