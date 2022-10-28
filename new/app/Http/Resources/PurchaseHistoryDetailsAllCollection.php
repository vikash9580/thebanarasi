<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\PurchaseHistoryDetailCollection;
use App\Models\OrderDetail;
use App\Models\Review;
use Carbon\Carbon;
use URL;
use App\Http\Resources\PurchaseHistoryCollection;
use App\Models\Order;

class PurchaseHistoryDetailsAllCollection extends ResourceCollection
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
            'product_data' => $this->collection->map(function($data) {
                return [
                        'order_detail_id'=>$data->id,
                        'product_id' => $data->product_id,
                        'product_name'=> $data->product_name,
                        'variant_id' => $data->variant_id,
                        'variant_name'=> $data->variant_name,
                        'thumbnail_img'=> api_asset($data->thumbnail_img),
                        'category_name'=>$data->category_name,
                        'brand' => $data->brand_name,
                        'price' => $data->price,
                        'discounted_price' => $data->discounted_price,
                        'tax' => $data->tax,
                        'tax_type' => $data->tax_type,
                        'discount'=>$data->discount,
                        'discount_type' => $data->discount_type,
                        'delivery_status' => $data->delivery_status,
                        'delivery_status_details'=>$this->delivery_status_details($data->id),
                        'quantity' => $data->quantity,
                        'discount_amount'=>$data->price-$data->discounted_price,
                        'can_review'=>$data->delivery_status=='delivered' ? 'Yes' : 'no',
                        'user_reviews'=>Review::where('product_id', $data->product_id)->where('user_id', $data->order->user_id)->where('order_id', $data->order_id)->first(),
                        'is_product_refundable'=>$data->product->refundable,
                        'refund'=>$this->can_refund($data->order_id,$data->product_id,$data->delivery_status,$data->product->refundable),
                ];
            })
        ];
    }

    public function with($request)
    {
        return [
            'success' => true,
            'purchase_histroy'=>$this->purchase_distroy_details($this->ids),
            'order_calculation'=>$this->order_calculation($this->ids),
            'you_save'=>$this->you_save($this->ids),
            'track_order'=>$this->track_order($this->ids),
            'invoice_url' =>$this->delivery_status($this->ids)=='delivered' ?   'https:// grofers.techuptechnologies.com/admin/app_invoice/customer/'.$this->ids : null,
            'status' => 200,
        ];
    }
    
     protected function purchase_distroy_details($order_id){
         
          $orderDetail=Order::where('id', $order_id)->first();
        
        return [
            
                    'order_id'=>$orderDetail->id,
                    'code' => $orderDetail->code,
                    'shipping_address' => json_decode($orderDetail->shipping_address),
                    'payment_type' => str_replace('_', ' ', $orderDetail->payment_type),
                    'payment_status' => $orderDetail->payment_status,
                    'delivery_status' => $this->delivery_status($orderDetail->id),
                    'delivery_status_date' => $this->delivery_status_date($orderDetail->id,$this->delivery_status($orderDetail->id)),
                    'order_image'=>api_asset($this->order_image($orderDetail->id)),
                    'coupon_discount' => (double) $orderDetail->coupon_discount,
                    'wallet_discount' => (double) $orderDetail->wallet_discount,
                    'shipping_cost' => (double) $orderDetail->orderDetails->sum('shipping_cost'),
                    'subtotal' => (double) $orderDetail->orderDetails->sum('discounted_price'),
                    'grand_total' => (double) $orderDetail->grand_total,
                    // 'tax' => (double) $data->orderDetails->sum('tax'),
                    'date' => Carbon::createFromTimestamp($orderDetail->date)->format('D,d M,y'),
                    'no_of_products'=>$this->no_of_products($orderDetail->id),
            
            
            
            ];
    } 
    
    
       public function no_of_products($id)
    {
        return OrderDetail::where('order_id', $id)->count();
    }
    
     public function delivery_status($id)
    {
        
         $delivery_stat =\App\OrderDetail::where('order_id',$id )->get();
                  $no_of_products=count($delivery_stat);
                  $no_of_cancel=0;
                   $no_of_return=0;
                 foreach($delivery_stat as $delivery){
                  if($delivery->delivery_status =='pending'){
                  $delivery_status='pending';
                  }
                  if($delivery->delivery_status=='confirmed'){
                  
                    $delivery_status='confirmed';
                         
                  }
                  if($delivery->delivery_status=='on_delivery'){
                  
                    $delivery_status='on_delivery';
                       
                  }
                   if($delivery->delivery_status=='delivered'){
                  
                    $delivery_status='delivered';
                          }
                     if($delivery->delivery_status=='cancel'){
                     
                        $no_of_cancel=$no_of_cancel+1;
                   
                          }
                          if($delivery->delivery_status=='return'){
                     
                        $no_of_return=$no_of_return+1;
                   
                          }
                  }
                  if($no_of_products==$no_of_cancel){
                   $delivery_status='cancel';
                  }
                  
                     if($no_of_products==$no_of_return){
                   $delivery_status='return';
                  }
        
        
        return $delivery_status;
    }
    public function delivery_status_date($id,$type)
    {
        if($type=='pending'){
        $delivery_status=Order::where('id', $id)->first('date');
        return  Carbon::createFromTimestamp($delivery_status['date'])->format('D,d M,y');
        }
         if($type=='confirmed'){
        $delivery_status=OrderDetail::where('order_id', $id)->first('confirmed_date');
        return  Carbon::createFromTimestamp($delivery_status['confirmed_date'])->format('D,d M,y');
        }
         if($type=='on_delivery'){
        $delivery_status=OrderDetail::where('order_id', $id)->first('shipping_date');
        return  Carbon::createFromTimestamp($delivery_status['shipping_date'])->format('D,d M,y');
        }
         if($type=='delivered'){
        $delivery_status=OrderDetail::where('order_id', $id)->first('delivered_date');
        return  Carbon::createFromTimestamp($delivery_status['delivered_date'])->format('D,d M,y');
        }
        if($type=='cancel'){
        $delivery_status=OrderDetail::where('order_id', $id)->first('cancel_date');
        return  Carbon::createFromTimestamp($delivery_status['cancel_date'])->format('D,d M,y');
        }
        if($type=='return'){
        $delivery_status=OrderDetail::where('order_id', $id)->first('return_date');
        return  Carbon::createFromTimestamp($delivery_status['return_date'])->format('D,d M,y');
        }
    }
    
    public function delivery_status_details($id){
        
        $order_detail=OrderDetail::where('id', $id)->first();
        
        if($order_detail->payment_status=='paid' && $order_detail->delivery_status=='cancel'){
            
            return [
                        'product_status_detail'=>'paid_cancel',
                         'product_order_cancel'=>[
                               
                               'message'=>$order_detail->cancel_date !=null ?'Your Order is cancled on '.Carbon::createFromTimestamp($order_detail->cancel_date)->format('D,d M,y h:i:s A') : null ,
                               'date'=>$order_detail->cancel_date !=null ? Carbon::createFromTimestamp($order_detail->cancel_date)->format('d M,Y') : null,
                               'cancel_reason'=>$order_detail->cancel_reason,
                               
                                ],
                         'product_order_return'=>[
                              
                               'message'=> $order_detail->return_date !=null ?'Your Order is return on '.Carbon::createFromTimestamp($order_detail->return_date)->format('D,d M,y h:i:s A') : null ,
                               'date'=>$order_detail->return_date !=null ? Carbon::createFromTimestamp($order_detail->return_date)->format('d M,Y') : null,
                               'return_reason'=>$order_detail->return_reason,
                              
                               
                                ],
                         'product_order_refund'=>[
                               
                                'message'=> $order_detail->refund_date !=null ?'Your Order is refunded on '.Carbon::createFromTimestamp($order_detail->refund_date)->format('D,d M,y h:i:s A') : null ,
                                'date'=>$order_detail->refund_date !=null ? Carbon::createFromTimestamp($order_detail->refund_date)->format('d M,Y') : null,
                                'refund_type'=>  \App\RefundRequest::where('order_detail_id',$id )->first()->admin_approval == 1 ?\App\RefundRequest::where('order_detail_id',$id )->first()->refundable_type : null,
                                'refund_amount'=>  \App\RefundRequest::where('order_detail_id',$id )->first()->admin_approval == 1 ?\App\RefundRequest::where('order_detail_id',$id )->first()->refund_amount : null ,
                                'transaction_id'=>  \App\RefundPaymentDetail::where('order_detail_id',$id )->first()->transaction_id !=null ?\App\RefundPaymentDetail::where('order_detail_id',$id )->first()->transaction_id : null ,
                                'bank_name'=>  \App\RefundPaymentDetail::where('order_detail_id',$id )->first()->bank_name !=null ?\App\RefundPaymentDetail::where('order_detail_id',$id )->first()->bank_name : null ,
                                'account_name'=>  \App\RefundPaymentDetail::where('order_detail_id',$id )->first()->account_name !=null ?\App\RefundPaymentDetail::where('order_detail_id',$id )->first()->account_name : null ,
                                'account_number'=>  \App\RefundPaymentDetail::where('order_detail_id',$id )->first()->account_number !=null ?\App\RefundPaymentDetail::where('order_detail_id',$id )->first()->account_number : null ,
                                'ifsc_code'=>  \App\RefundPaymentDetail::where('order_detail_id',$id )->first()->ifsc_code !=null ?\App\RefundPaymentDetail::where('order_detail_id',$id )->first()->ifsc_code : null ,
                               
                               
                                ]
                
                
                
                ];
        }
        
         if($order_detail->payment_status=='unpaid' && $order_detail->delivery_status=='cancel'){
            
            return [
                        'product_status_detail'=>'unpaid_cancel',
                         'product_order_cancel'=>[
                               
                               'message'=>$order_detail->cancel_date !=null ?'Your Order is cancled on '.Carbon::createFromTimestamp($order_detail->cancel_date)->format('D,d M,y h:i:s A') : null ,
                               'date'=>$order_detail->cancel_date !=null ? Carbon::createFromTimestamp($order_detail->cancel_date)->format('d M,Y') : null,
                                'cancel_reason'=>$order_detail->cancel_reason,
                               
                                ],
                         'product_order_return'=>[
                               
                               'message'=> $order_detail->return_date !=null ?'Your Order is return on '.Carbon::createFromTimestamp($order_detail->return_date)->format('D,d M,y h:i:s A') : null ,
                               'date'=>$order_detail->return_date !=null ? Carbon::createFromTimestamp($order_detail->return_date)->format('d M,Y') : null,
                                'return_reason'=>$order_detail->return_reason,
                              
                               
                                ],
                         'product_order_refund'=>[
                               
                                'message'=> $order_detail->refund_date !=null ?'Your Order is refunded on '.Carbon::createFromTimestamp($order_detail->refund_date)->format('D,d M,y h:i:s A') : null ,
                                'date'=>$order_detail->refund_date !=null ? Carbon::createFromTimestamp($order_detail->refund_date)->format('d M,Y') : null,
                                'transaction_id'=>'null',
                                'bank_name'=>'null',
                                'account_name'=>'null',
                                'account_number'=>'null',
                                'ifsc_code'=>'null',
                                
                               
                               
                                ]
                
                
                
                ];
        }
        
        
         if($order_detail->delivery_status=='return'){
            
            return [
                        'product_status_detail'=>'return',
                         'product_order_cancel'=>[
                               
                               'message'=>$order_detail->cancel_date !=null ?'Your Order is cancled on '.Carbon::createFromTimestamp($order_detail->cancel_date)->format('D,d M,y h:i:s A') : null ,
                               'date'=>$order_detail->cancel_date !=null ? Carbon::createFromTimestamp($order_detail->cancel_date)->format('d M,Y') : null,
                               'cancel_reason'=>$order_detail->cancel_reason,
                               
                                ],
                         'product_order_return'=>[
                               
                               'message'=> $order_detail->return_date !=null ?'Your Order is return on '.Carbon::createFromTimestamp($order_detail->return_date)->format('D,d M,y h:i:s A') : null ,
                               'date'=>$order_detail->return_date !=null ? Carbon::createFromTimestamp($order_detail->return_date)->format('d M,Y') : null,
                                'return_reason'=>$order_detail->return_reason,
                              
                               
                                ],
                         'product_order_refund'=>[
                               
                                'message'=> $order_detail->refund_date !=null ?'Your Order is refunded on '.Carbon::createFromTimestamp($order_detail->refund_date)->format('D,d M,y h:i:s A') : null ,
                                'date'=>$order_detail->refund_date !=null ? Carbon::createFromTimestamp($order_detail->refund_date)->format('d M,Y') : null,
                                'refund_type'=>  \App\RefundRequest::where('order_detail_id',$id )->first()->admin_approval == 1 ?\App\RefundRequest::where('order_detail_id',$id )->first()->refundable_type : null,
                                'refund_amount'=>  \App\RefundRequest::where('order_detail_id',$id )->first()->admin_approval == 1 ?\App\RefundRequest::where('order_detail_id',$id )->first()->refund_amount : null ,
                                'transaction_id'=>  \App\RefundPaymentDetail::where('order_detail_id',$id )->first()->transaction_id !=null ?\App\RefundPaymentDetail::where('order_detail_id',$id )->first()->transaction_id : null ,
                                'bank_name'=>  \App\RefundPaymentDetail::where('order_detail_id',$id )->first()->bank_name !=null ?\App\RefundPaymentDetail::where('order_detail_id',$id )->first()->bank_name : null ,
                                'account_name'=>  \App\RefundPaymentDetail::where('order_detail_id',$id )->first()->account_name !=null ?\App\RefundPaymentDetail::where('order_detail_id',$id )->first()->account_name : null ,
                                'account_number'=>  \App\RefundPaymentDetail::where('order_detail_id',$id )->first()->account_number !=null ?\App\RefundPaymentDetail::where('order_detail_id',$id )->first()->account_number : null ,
                                'ifsc_code'=>  \App\RefundPaymentDetail::where('order_detail_id',$id )->first()->ifsc_code !=null ?\App\RefundPaymentDetail::where('order_detail_id',$id )->first()->ifsc_code : null ,
                               
                               
                                ]
                
                
                
                ];
        }
        
            
        
        
        
    }
    
    
     public function order_image($id)
    {
        $order_image=OrderDetail::where('order_id', $id)->first('thumbnail_img');
        return $order_image['thumbnail_img'];
    }
    
    
    public function order_calculation($order_id){
        
         $order=Order::where('id', $order_id)->first();
         $order_details=OrderDetail::where('order_id', $order_id)->where('delivery_status','!=','cancel')->Where('delivery_status','!=','return')->get();
         $shipping_cost=OrderDetail::where('order_id', $order_id)->sum('shipping_cost');
         $total_product__price=0;
         $totaldiscount_product__price=0;
         $total_shipping_cost= 0;
         $total_cancel_order=0;
         $total_return_order=0;
         
         foreach($order_details as $order_detail){
             
             $total_product__price=$total_product__price+($order_detail->price*$order_detail->quantity);
             $totaldiscount_product__price=$totaldiscount_product__price+($order_detail->discounted_price*$order_detail->quantity);
             $total_shipping_cost=$total_shipping_cost+$order_detail->shipping_cost;
             
         }
         if($total_shipping_cost==0){
             $shipping_cost=0;
         }
         
          return [
           
           'base_price_total'=>$total_product__price,
           'base_discount_total'=>$totaldiscount_product__price,
           'delivery_charge'=>$shipping_cost,
           'coupon_discount'=>$order->coupon_discount,
           'wallet_discount'=>$order->wallet_discount
           
           ];
        
    }
    
    public function you_save($order_id){
        
        $order=Order::where('id', $order_id)->first();
         $total_product__price=OrderDetail::where('order_id', $order_id)->sum('price');
         $total_shipping_cost= OrderDetail::where('order_id', $order_id)->sum('shipping_cost');
         return round($total_product__price-($order->grand_total-$total_shipping_cost));
    }
    
    
    public function track_order($order_id){
        
        
        $delivery_stat =\App\OrderDetail::where('order_id',$order_id )->get();
                  $no_of_products=count($delivery_stat);
                  $no_of_cancel=0;
                   $no_of_return=0;
                 foreach($delivery_stat as $delivery){
                  if($delivery->delivery_status =='pending'){
                  $delivery_status='pending';
                  }
                  if($delivery->delivery_status=='confirmed'){
                  
                    $delivery_status='confirmed';
                         
                  }
                  if($delivery->delivery_status=='on_delivery'){
                  
                    $delivery_status='on_delivery';
                       
                  }
                   if($delivery->delivery_status=='delivered'){
                  
                    $delivery_status='delivered';
                          }
                     if($delivery->delivery_status=='cancel'){
                     
                        $no_of_cancel=$no_of_cancel+1;
                   
                          }
                          if($delivery->delivery_status=='return'){
                     
                        $no_of_return=$no_of_return+1;
                   
                          }
                  }
                  if($no_of_products==$no_of_cancel){
                      $data=OrderDetail::where('order_id', $order_id)->first();
                  }
                  
                     elseif($no_of_products==$no_of_return){
                    $data=OrderDetail::where('order_id', $order_id)->first();
                  }
        
        
             else{
                  $data=OrderDetail::where('order_id', $order_id)->where('delivery_status','!=','cancel')->where('delivery_status','!=','return')->first();
                }
        
       return [
                           
                           'order_placed'=>[
                               'status'=>'Pending',
                               'message'=> $data->created_at !=null ?'Your Order is placed on '.Carbon::createFromTimestamp(strtotime($data->created_at))->format('D,d M,y h:i:s A') : null ,
                               'date'=>$data->created_at !=null ? Carbon::createFromTimestamp(strtotime($data->created_at))->format('d M,Y ') : null,
                               'active'=>$data->created_at !=null ? 1 : 0,
                                ],
                           'order_confirmed'=>[
                               'status'=>'Confirmed',
                               'message'=> $data->confirmed_date !=null ?'Your Order is confirmed on '.Carbon::createFromTimestamp($data->confirmed_date)->format('D,d M,y h:i:s A') : null ,
                               'date'=>$data->confirmed_date !=null ? Carbon::createFromTimestamp($data->confirmed_date)->format('d M,Y') : null,
                               'active'=>$data->confirmed_date !=null ? 1: 0,
                                ],
                           'order_shipped'=>[
                               'status'=>'On Delivery',
                               'message'=> $data->shipping_date !=null ?'Your Order will expacted deliver on '.Carbon::createFromTimestamp( $data->expacted_delivery)->format('D,d M,y h:i:s A') : null ,
                               'date'=>$data->shipping_date !=null ? Carbon::createFromTimestamp($data->shipping_date)->format('d M,Y') : null,
                               'active'=>$data->shipping_date !=null ? 1 : 0,
                                ],
                           'order_delivered'=>[
                               'status'=>'Delivered',
                               'message'=>$data->delivered_date !=null ?'Your Order is delivered on '.Carbon::createFromTimestamp($data->delivered_date)->format('D,d M,y h:i:s A') : null ,
                               'date'=>$data->delivered_date !=null ? Carbon::createFromTimestamp($data->delivered_date)->format('d M,Y') : null,
                               'active'=>$data->delivered_date !=null ? 1 : 0,
                                ],
                           'order_cancel'=>[
                               'status'=>'Cancled',
                               'message'=>$data->cancel_date !=null ?'Your Order is cancled on '.Carbon::createFromTimestamp($data->cancel_date)->format('D,d M,y h:i:s A') : null ,
                               'date'=>$data->cancel_date !=null ? Carbon::createFromTimestamp($data->cancel_date)->format('d M,Y') : null,
                               'active'=>$data->cancel_date !=null ?1: 0,
                               
                                ],
                            'order_return'=>[
                               'status'=>'Return',
                               'message'=> $data->return_date !=null ?'Your Order is return on '.Carbon::createFromTimestamp($data->return_date)->format('D,d M,y h:i:s A') : null ,
                               'date'=>$data->return_date !=null ? Carbon::createFromTimestamp($data->return_date)->format('d M,Y') : null,
                               'active'=>$data->return_date !=null ?1: 0,
                               
                                ],
                            'order_refund'=>[
                               'status'=>'Refunded',
                                'message'=> $data->refund_date !=null ?'Your Order is refunded on '.Carbon::createFromTimestamp($data->refund_date)->format('D,d M,y h:i:s A') : null ,
                               'date'=>$data->refund_date !=null ? Carbon::createFromTimestamp($data->refund_date)->format('d M,Y') : null,
                               'active'=>$data->refund_date !=null ?1: 0,
                               
                                ]
                           
                       
                       ];
        
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
    
  
}
