<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use App\OrderDetail;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PurchaseHistoryCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function($data) {
                return [
                    'code' => $data->code,
                    'user' => [
                        'name' => $data->user->name,
                        'email' => $data->user->email,
                        'avatar' => $data->user->avatar,
                        'avatar_original' => api_asset($data->user->avatar_original)
                    ],
                    'shipping_address' => json_decode($data->shipping_address),
                    'payment_type' => str_replace('_', ' ', $data->payment_type),
                    'payment_status' => $data->payment_status,
                    'grand_total' => $data->grand_total -  $data->orderDetails->where('product_status','cancel')->sum('price'),
                    'coupon_discount' => $data->coupon_discount,
                    'shipping_cost' => (double) $data->orderDetails->sum('shipping_cost') - $data->orderDetails->where('product_status','cancel')->sum('shipping_cost'),
                    'subtotal' => $data->orderDetails->sum('price') - $data->orderDetails->where('product_status','cancel')->sum('price'),
                    'mrptotal'=>$data->orderDetails->sum('mrp_price') - $data->orderDetails->where('product_status','cancel')->sum('mrp_price'),
                    'tax' => $data->orderDetails->sum('tax') - $data->orderDetails->where('product_status','cancel')->sum('tax'),
                    'date' => Carbon::createFromTimestamp($data->date)->format('d-m-Y'),
                    'product_count'=>$this->productCount($data->id),
                    'order_status'=>$this->orderStatus($data->id),
                    'links' => [
                        'details' => route('purchaseHistory.details', $data->id)
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
    
    protected function productCount($order_id)
    {
       $list= OrderDetail::where('order_id',$order_id)->count();
       return $list;
        
    }
     protected function orderStatus($order_id)
    {
        $delivery_stat =\App\OrderDetail::where('order_id',$order_id )->get();
        $no_of_products=count($delivery_stat);
        $no_of_cancel=0;
        $no_of_return=0;
        $total_cancel_amount=0;
        $total_tax_cancel=0;
        foreach($delivery_stat as $delivery)
        {
            if($delivery->delivery_status =='pending')
            {
                $delivery_status='pending';
            }
            if($delivery->delivery_status=='confirmed')
            {
                $delivery_status='confirmed';
            }
            if($delivery->delivery_status=='on_delivery')
            {
                $delivery_status='on_delivery';
            }
            if($delivery->delivery_status=='delivered')
            {
                $delivery_status='delivered';
            }
            if($delivery->delivery_status=='cancel')
            {
                $total_cancel_amount=$total_cancel_amount+ $delivery->price;
                $total_tax_cancel=$total_tax_cancel+$delivery->tax;
                $no_of_cancel=$no_of_cancel+1;
                $delivery_status='cancel';
            }
            if($delivery->delivery_status=='return')
            {
                $no_of_return=$no_of_return+1;
                $delivery_status='return';
            }
        }
        if($no_of_products==$no_of_cancel)
        {
            $delivery_status='cancel';
        }
        if($no_of_products==$no_of_return)
        {
            $delivery_status='return';
        }
        return $delivery_status;
    }
}
