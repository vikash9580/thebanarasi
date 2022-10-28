<?php

namespace App\Http\Resources;
use App\Product;
use App\OrderDetail;
use Carbon\Carbon;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PurchaseHistoryDetailCollection extends ResourceCollection
{
    
     private $ids;

        public function __construct($resource, $ids = false) {
            // Ensure we call the parent constructor
            parent::__construct($resource);
            $this->resource = $resource;
            $this->ids = $ids; // $apple param passed
        }
    
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function($data) {
                return [
                    'product' => $this->product($data->product->id),
                    'order_id' => $data->order_id,
                    'variation' => $data->variation,
                    'price' =>  number_format((float)$data->price, 2, '.', ''),
                    'mrp_price' => $data->mrp_price, 
                    'tax' => number_format((float)$data->tax, 2, '.', ''),
                    'shipping_cost' => $data->shipping_cost,
                    'coupon_discount' => $data->coupon_discount,
                    'quantity' => $data->quantity,
                    'payment_status' => $data->payment_status,
                    'delivery_status' => $data->delivery_status,
                    
                ];
            })
        ];
    }
    
    public function with($request)
    {
        return [
            'invoice'=>"https://www.thebanarasisaree.com/invoice/customer/$this->ids",
            'track_order'=>[
                'order_placed'=>[
                                    'status'=>'Pending',
                                    'message'=>'',
                                    'date'=>'',
                                    'active'=>$this->order_placed($this->ids) == 'pending' ? 1 : 0,
                                ],
                'order_confirmed'=>[
                                        'status'=>'Confirmed',
                                        'message'=>'',
                                        'date'=>'',
                                        'active'=>$this->order_placed($this->ids) == 'confirmed' ? 1 : 0,                         
                                    ],
                'order_shipped'=>[
                                        'status'=>'On Delivery',
                                        'message'=>'',
                                        'date'=>'',
                                        'active'=>$this->order_placed($this->ids) == 'on_delivery' ? 1 : 0,
                                    ],
                'order_delivered'=>[
                                        'status'=>'Delivered',
                                        'message'=>'',
                                        'date'=>'',
                                        'active'=>$this->order_placed($this->ids) == 'delivered' ? 1 : 0,
                                    ],
                'order_cancel'=>[
                                        'status'=>'Cancled',
                                        'message'=>'',
                                        'date'=>'',
                                        'active'=>$this->order_placed($this->ids) == 'cancel' ? 1 : 0,
                                    ],
                'order_return'=>[
                                        'status'=>'Return',
                                        'message'=>'',
                                        'date'=>'',
                                        'active'=>$this->order_placed($this->ids) == 'return' ? 1 : 0,
                                    ],
                'order_refund'=>[
                                        'status'=>'Refunded',
                                        'message'=>'',
                                        'date'=>'',
                                        'active'=>$this->order_placed($this->ids) == 'refund' ? 1 : 0,
                                    ],
                
                ],
            'success' => true,
            'status' => 200
        ];
    }
    
     protected function order_placed($id) 
    {
       $delivery_stat =\App\OrderDetail::where('order_id',$id )->get();
                  $no_of_products=count($delivery_stat);
                  $no_of_cancel=0;
                   $no_of_return=0;
                   $total_cancel_amount=0;
                   $total_tax_cancel=0;
                    $no_of_pending=0;
                    $no_of_confirmed=0;
                    $no_of_on_delivery=0;
                    $no_of_delivered=0;
                 foreach($delivery_stat as $delivery){
                  if($delivery->delivery_status =='pending'){
                  $delivery_status='pending';
                    $no_of_pending=$no_of_pending+1;
                  }
                  if($delivery->delivery_status=='confirmed'){
                  
                    $delivery_status='confirmed';
                      $no_of_confirmed=$no_of_confirmed+1;
                         
                  }
                  if($delivery->delivery_status=='on_delivery'){
                  
                    $delivery_status='on_delivery';
                      $no_of_on_delivery=$no_of_on_delivery+1;
                       
                  }
                   if($delivery->delivery_status=='delivered'){
                     
                    $delivery_status='delivered';
                      $no_of_delivered=$no_of_delivered+1;
                          }
                     if($delivery->delivery_status=='cancel'){
                        $total_cancel_amount=$total_cancel_amount+ $delivery->price;
                        $total_tax_cancel=$total_tax_cancel+$delivery->tax;
                        $no_of_cancel=$no_of_cancel+1;
                   
                          }
                          if($delivery->delivery_status=='return'){
                     
                        $no_of_return=$no_of_return+1;
                   
                          }
                  }
                  if($no_of_products==$no_of_cancel){
                   $delivery_status='cancel';
                  }
                  
                     if($no_of_pending<$no_of_return){
                   $delivery_status='return';
                  }
                  
                   if($no_of_confirmed<$no_of_return){
                   $delivery_status='return';
                  }
                   if($no_of_on_delivery<$no_of_return){
                   $delivery_status='return';
                  }
                   if($no_of_delivered<$no_of_return){
                   $delivery_status='return';
                  }
                  return $delivery_status;
    }
    
    protected function order_date($id) 
    {
        $list=OrderDetail::where('order_id',$id)->pluck('created_at');
         return $list;
    }
    
    protected function product($id) 
    {
         $list=Product::where('id',$id)->with('category')->first(['name','thumbnail_img','category_id','discount_type','discount']);
         $list->thumbnail_img=api_asset($list->thumbnail_img);
         return $list;
    }
    
    protected function trackOrder($id) 
    {
        return OrderDetail::where('order_id',$id)->first();
    }
    
    
}
