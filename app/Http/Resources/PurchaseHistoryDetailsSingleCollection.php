<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\PurchaseHistoryDetailCollection;
use App\Models\OrderDetail;
use App\Models\Review;
use Carbon\Carbon;
use URL;

class PurchaseHistoryDetailsSingleCollection extends ResourceCollection
{
    
     private $ids,$idss;

        public function __construct($resource, $ids = false,$idss=false) {
            // Ensure we call the parent constructor
            parent::__construct($resource);
            $this->resource = $resource;
            $this->ids = $ids; // $apple param passed
            $this->idss = $idss; // $apple param passed
        }
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function($data) {
                return [
                    'id'=>$data->id,
                    'order_id'=>$data->order_id,
                    'order_code'=>$data->order->code,
                    'grand_total_amount'=>$data->order->grand_total-($this->grand_total_amount($data->order_id,$data->id,$data->payment_status)),
                    'total_shiping_cost'=>$this->total_shiping_cost($data->order_id),
                    'is_product_refundable'=>$data->product->refundable,
                    'refund'=>$this->can_refund($data->order_id,$data->product_id,$data->delivery_status,$data->product->refundable),
                    'product' =>[
                        'product_id' => $data->product_id,
                        'product_name'=> $data->product_name,
                        'thumbnail_img'=> api_asset($data->thumbnail_img),
                        'brand' => $data->product->brand->name,
                        'variation' => $data->variation,
                        'total_price' => $data->price,
                        'total_tax' => $data->tax,
                        'tax_type' => $data->tax_type,
                        'total_discount' => $data->discount,
                        'discount_type' => $data->discount_type,
                        'quantity' => $data->quantity,
                        'base_price'=>$this->base_price($data->price,$data->quantity),
                        'base_discount_price'=>$this->base_discount_price($data->price,$data->discount,$data->quantity,$data->discount_type),
                        'discount_amount'=>round($this->discount_amount($data->price,$data->discount,$data->quantity,$data->discount_type)),
                        'coupan_discount' => $data->coupan_discount,
                        'coupan_discount_type' => $data->coupan_discount_type,
                        'coupan_discount_amount'=>round($this->discount_amount($data->price,$data->coupan_discount,$data->quantity,$data->coupan_discount_type)),
                        ],
                
                   'track_order'=>[
                           
                           'order_placed'=>[
                               'status'=>'Pending',
                               'message'=> $data->created_at !=null ?'Your Order is placed on '.Carbon::createFromTimestamp(strtotime($data->created_at))->format('D,d M,y h:i:s A') : null ,
                               'date'=>$data->created_at !=null ? Carbon::createFromTimestamp(strtotime($data->created_at))->format('D,d M,y ') : null,
                               'active'=>$data->created_at !=null ? 1 : 0,
                                ],
                           'order_confirmed'=>[
                               'status'=>'Confirmed',
                               'message'=> $data->confirmed_date !=null ?'Your Order is confirmed on '.Carbon::createFromTimestamp($data->confirmed_date)->format('D,d M,y h:i:s A') : null ,
                               'date'=>$data->confirmed_date !=null ? Carbon::createFromTimestamp($data->confirmed_date)->format('D,d M,y') : null,
                               'active'=>$data->confirmed_date !=null ? 1: 0,
                                ],
                           'order_shipped'=>[
                               'status'=>'On Delivery',
                               'message'=> $data->shipping_date !=null ?'Your Order will expacted deliver on '.Carbon::createFromTimestamp( $data->expacted_delivery)->format('D,d M,y h:i:s A') : null ,
                               'date'=>$data->shipping_date !=null ? Carbon::createFromTimestamp($data->shipping_date)->format('D,d M,y ') : null,
                               'active'=>$data->shipping_date !=null ? 1 : 0,
                                ],
                           'order_delivered'=>[
                               'status'=>'Delivered',
                               'message'=>$data->delivered_date !=null ?'Your Order is delivered on '.Carbon::createFromTimestamp($data->delivered_date)->format('D,d M,y h:i:s A') : null ,
                               'date'=>$data->delivered_date !=null ? Carbon::createFromTimestamp($data->delivered_date)->format('D,d M,y ') : null,
                               'active'=>$data->delivered_date !=null ? 1 : 0,
                                ],
                           'order_cancel'=>[
                               'status'=>'Cancled',
                               'message'=>$data->cancel_date !=null ?'Your Order is cancled on '.Carbon::createFromTimestamp($data->cancel_date)->format('D,d M,y h:i:s A') : null ,
                               'date'=>$data->cancel_date !=null ? Carbon::createFromTimestamp($data->cancel_date)->format('D,d M,y ') : null,
                               'active'=>$data->cancel_date !=null ?1: 0,
                               
                                ],
                            'order_return'=>[
                               'status'=>'Return',
                               'message'=> $data->return_date !=null ?'Your Order is return on '.Carbon::createFromTimestamp($data->return_date)->format('D,d M,y h:i:s A') : null ,
                               'date'=>$data->return_date !=null ? Carbon::createFromTimestamp($data->return_date)->format('D,d M,y ') : null,
                               'active'=>$data->return_date !=null ?1: 0,
                               
                                ],
                            'order_refund'=>[
                               'status'=>'Refunded',
                                'message'=> $data->refund_date !=null ?'Your Order is refunded on '.Carbon::createFromTimestamp($data->refund_date)->format('D,d M,y h:i:s A') : null ,
                               'date'=>$data->refund_date !=null ? Carbon::createFromTimestamp($data->refund_date)->format('D,d M,y ') : null,
                               'active'=>$data->refund_date !=null ?1: 0,
                               
                                ]
                           
                       
                       ],
                       'can_review'=>$data->delivery_status=='delivered' ? 'Yes' : 'no',
                       'user_reviews'=>Review::where('product_id', $data->product_id)->where('user_id', $data->order->user_id)->where('order_id', $data->order_id)->first(),
                   
                    'payment_status' => $data->payment_status,
                    'delivery_status' => $data->delivery_status,
                    'cancel_reason' =>  $data->cancel_reason,
                    'return_reason' =>  $data->return_reason,
                    'product_status' => $data->product_status,
                    'shipping_address' => $data->order->shipping_address,
                    'invoice_url' =>$data->delivery_status=='delivered' ?  'https://apnidawaa.com/admin/app_invoice/customer/'.$data->order_id : null,
                    
                ];
            })
        ];
    }

    public function with($request)
    {
        return [
            'other_product'=>$this->other_products($this->ids,$this->idss),
            'success' => true,
            'status' => 200
        ];
    }
    
    protected function other_products($id,$product_id){
         return new PurchaseHistoryDetailCollection(OrderDetail::where('order_id', $id)->where('product_id','!=',$product_id)->get());
    }
    
     protected function base_price($price,$quantity){
        return ($price /$quantity);
    }
    
     protected function base_discount_price($price,$amount,$quantity,$type){
      if($type=='percent'){
          
          $pr=$price/$quantity;
          $per=$amount;
            
          return round((($pr-($pr*$per)/100)));
      }
      
      if($type=='amount'){
          $pr=$price/$quantity;
          return round(($pr- ($amount/$quantity)));
          
      }
      
    }
    
    protected function discount_amount($price,$amount,$quantity,$type){
      if($type=='percent'){
          
          $pr=$price/$quantity;
          $per=$amount;
            
          return (($pr*$per)/100);
      }
      
      if($type=='amount'){
          
          return $amount/$quantity;
          
      }
      
    }
    
     protected function can_refund($order_detail_id,$product_id,$delivery_status,$is_refundable){
         
         $no_of_max_day = \App\BusinessSetting::where('type', 'refund_request_time')->first()->value;
         $orderDetail=OrderDetail::where('order_id', $order_detail_id)->where('product_id',$product_id)->first();
         $last_refund_date = $orderDetail['created_at']->addDays($no_of_max_day);
         $today_date =Carbon::now();
         if($is_refundable != 0){
         if ($today_date <= $last_refund_date && $delivery_status== 'delivered'){
             
             return ['can_refund'=>1,'message'=>'Product can be refundable with in '.$last_refund_date];
             
          }else{
         
          return ['can_refund'=>0,'message'=>'Product can be refundable with in '.$last_refund_date];
        
          }
       }else{
           
             return null;
       }
    }
    
     protected function grand_total_amount($order_id,$order_detail_id,$payment_status){
         $amount=0;
         if($payment_status=='unpaid'){
         $orderDetail=OrderDetail::where('order_id', $order_id)->where('delivery_status','cancel')->where('payment_status','unpaid')->get();
         if(!empty($orderDetail[0]) && isset($orderDetail[0])){
         foreach($orderDetail as $product_detials){
             
            $product_price= $product_detials['price'];
            if($product_detials['discount_type']=='percent'){
            $product_dicount= ($product_price * $product_detials['discount'])/100;
            }
            if($product_detials['discount_type']=='amount'){
            $product_dicount=  $product_detials['discount'];
            }
            
            $amount=$amount+($product_price-$product_dicount);
             
         }
       }
    //   else{
           
    //         $orderDetail=OrderDetail::where('order_id', $order_id)->where('delivery_status','return')->where('payment_status','unpaid')->get();
    //      if(!empty($orderDetail) && isset($orderDetail)){
    //      foreach($orderDetail as $product_detials){
             
    //         $product_price= $product__detials['price'];
    //         if($product_detials['discount_type']=='percent'){
    //         $product_dicount= ($product_price * $product__detials['discount'])/100;
    //         }
    //         if($product_detials['discount_type']=='amount'){
    //         $product_dicount=  $product_detials['discount'];
    //         }
            
    //         $amount=$amount+($product_price-$product_dicount);
             
    //      }
    //   }
           
    //   }
       
    }
     if($payment_status=='paid')  {
          
           
           $orderDetail=OrderDetail::where('order_id', $order_id)->where('delivery_status','cancel')->where('payment_status','paid')->get();
            if(isset($orderDetail[0]) && !empty($orderDetail[0])){
                
          
           foreach($orderDetail as $product_detials){
             $status= \App\RefundRequest::where('order_id',$order_id)->where('order_detail_id',$product_detials['id'])->first();
             if($status['refund_status']==1){
            $product_price= $product__detials['price'];
            if($product__detials['discount_type']=='percent'){
            $product_dicount= ($product_price * $product_detials['discount'])/100;
            }
            if($product__detials['discount_type']=='amount'){
            $product_dicount=  $product_detials['discount'];
            }
            
            $amount=$amount+($product_price-$product_dicount);
             
         }
        }
        
       }
         
      else{
           
           $orderDetail=OrderDetail::where('order_id', $order_id)->where('delivery_status','return')->where('payment_status','paid')->get();
            
                
           foreach($orderDetail as $product_detials){
             $status= \App\RefundRequest::where('order_id',$order_id)->where('order_detail_id',$product_detials['id'])->first();
             if($status['refund_status']==1){
            $product_price= $product_detials['price'];
            if($product_detials['discount_type']=='percent'){
            $product_dicount= ($product_price * $product_detials['discount'])/100;
            }
            if($product_detials['discount_type']=='amount'){
            $product_dicount= $product_detials['discount'];
            }
            
            $amount=$amount+($product_price-$product_dicount);
             
         }
           }
           
       }  
         
       }
           
     
         
         return $amount;
        
    }
    
     protected function total_shiping_cost($order_id){
         $shiping_cost=0;
          $orderDetail=OrderDetail::where('order_id', $order_id)->get();
          foreach($orderDetail as $product_detials){
              $shiping_cost=$shiping_cost+$product_detials['shipping_cost'];
          }
        return $shiping_cost;
    }
    
}
