<?php

namespace App\Http\Resources;
use App\Models\Coupon;


use Illuminate\Http\Resources\Json\ResourceCollection;

class CartCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function($data) {
                if(!empty($data->product)){
                    return [
                        'id' => $data->id,
                        'product' => [
                            'name' => $data->product->name,
                            'image' => api_asset($data->product->thumbnail_img)
                        ],
                        'category'=>$data->product->category,
                        'sub_category'=>$data->product->subcategory,
                        'details'=>"https://thebanarasisaree.com/api/v1/products/".$data->product->id,
                        'variation' => $data->variation,
                        'discounted_price' => (double) $data->price,
                        'discount_type'=>$data->product->discount_type,
                        'discount'=>$data->product->discount,
                        'tax' => number_format((float)$data->tax, 2, '.', ''),
                        'shipping_cost' => (double) $data->shipping_cost,
                        'quantity' => (integer) $data->quantity,
                        'price' => (integer) $data->product->unit_price,
                        'min_qty' => $data->product->min_qty,
                        'max_qty' => $data->product->max_qty,
                        'date' => $data->created_at->diffForHumans(),
                       
                    ];
                }
            })
        ];
    }

    public function with($request)
    {
        $result=Coupon::all();
       $total=count($result);
       for($i=0;$i<$total;$i++)
       {
           $result[$i]['start_date']=\Carbon\Carbon::parse($result[$i]['start_date'])->format('Y-m-d H:i');
            $result[$i]['end_date']=\Carbon\Carbon::parse($result[$i]['end_date'])->format('Y-m-d H:i');
       }
        return [
            'coupons'=>$result,
            'success' => true,
            'status' => 200
        ];
    }
}
