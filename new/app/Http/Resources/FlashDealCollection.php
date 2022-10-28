<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\ProductCollection;
use App\Models\FlashDeal;
use App\Models\Product;

class FlashDealCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if(!empty($this->collection->first()->id)){
            $flash_deal = FlashDeal::findOrFail($this->collection->first()->id);
            $products = collect();
            foreach ($flash_deal->flashDealProducts as $key => $flash_deal_product) {
                if(Product::find($flash_deal_product->product_id) != null){
                        $products->push(Product::find($flash_deal_product->product_id));
                }
            }
            return [
                'title' => $flash_deal->title, 
                'end_date' => \Carbon\Carbon::parse($flash_deal->end_date)->format('d/m/Y'),
                'products' => new ProductCollection($products)
            ];
        }
        return [
                'title' =>" ", 
                'end_date' =>" ",
                'products' => new ProductCollection([])
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
