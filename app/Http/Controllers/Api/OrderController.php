<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Cart;
use App\Models\Product;
use App\Models\OrderDetail;
use App\Models\Coupon;
use App\Models\CouponUsage;
use App\Models\BusinessSetting;
use Razorpay\Api\Api;
use App\User;
use DB;
use Auth;
use App\RefundPaymentDetail;
use App\RefundRequest;
use Craftsys\Msg91\Facade\Msg91;
use App\Mail\InvoiceEmailManager;
use Mail;

class OrderController extends Controller
{
    public function processOrder(Request $request)
    {
        $shippingAddress = json_decode($request->shipping_address);

        $cartItems = Cart::where('user_id', $request->user_id)->get();

        $shipping = 0;
        $admin_products = array();
        $seller_products = array();
        //

        if (\App\BusinessSetting::where('type', 'shipping_type')->first()->value == 'flat_rate') {
            $shipping = \App\BusinessSetting::where('type', 'flat_rate_shipping_cost')->first()->value;
        }
        elseif (\App\BusinessSetting::where('type', 'shipping_type')->first()->value == 'seller_wise_shipping') {
            foreach ($cartItems as $cartItem) {
                $product = \App\Product::find($cartItem->product_id);
                if($product->added_by == 'admin'){
                    array_push($admin_products, $cartItem->product_id);
                }
                else{
                    $product_ids = array();
                    if(array_key_exists($product->user_id, $seller_products)){
                        $product_ids = $seller_products[$product->user_id];
                    }
                    array_push($product_ids, $cartItem->product_id);
                    $seller_products[$product->user_id] = $product_ids;
                }
            }
                if(!empty($admin_products)){
                    $shipping = \App\BusinessSetting::where('type', 'shipping_cost_admin')->first()->value;
                }
                if(!empty($seller_products)){
                    foreach ($seller_products as $key => $seller_product) {
                        $shipping += \App\Shop::where('user_id', $key)->first()->shipping_cost;
                    }
                }
        }

        // create an order
        $order = Order::create([
            'user_id' => $request->user_id,
            'shipping_address' => json_encode($shippingAddress),
            'payment_type' => $request->payment_type,
            'payment_status' => $request->payment_status,
            'grand_total' => $request->grand_total + $shipping,    //// 'grand_total' => $request->grand_total + $shipping,
            'coupon_discount' => $request->coupon_discount,
            'code' => date('Ymd-his'),
            'date' => strtotime('now')
        ]);

        foreach ($cartItems as $cartItem) {
            $product = Product::findOrFail($cartItem->product_id);
            if ($cartItem->variation) {
                $cartItemVariation = $cartItem->variation;
                $product_stocks = $product->stocks->where('variant', $cartItem->variation)->first();
                $product_stocks->qty -= $cartItem->quantity;
                $product_stocks->save();
            } else {
                $product->update([
                    'current_stock' => DB::raw('current_stock - ' . $cartItem->quantity)
                ]);
            }

            $order_detail_shipping_cost= 0;

            if (\App\BusinessSetting::where('type', 'shipping_type')->first()->value == 'flat_rate') {
                $order_detail_shipping_cost = $shipping/count($cartItems);
            }
            elseif (\App\BusinessSetting::where('type', 'shipping_type')->first()->value == 'seller_wise_shipping') {
                if($product->added_by == 'admin'){
                    $order_detail_shipping_cost = \App\BusinessSetting::where('type', 'shipping_cost_admin')->first()->value/count($admin_products);
                }
                else {
                    $order_detail_shipping_cost = \App\Shop::where('user_id', $product->user_id)->first()->shipping_cost/count($seller_products[$product->user_id]);
                }
            }
            else{
                $order_detail_shipping_cost = $product->shipping_cost;
            }

            // save order details
            OrderDetail::create([
                'order_id' => $order->id,
                'seller_id' => $product->user_id,
                'product_id' => $product->id,
                'variation' => $cartItem->variation,
                'price' => $cartItem->price * $cartItem->quantity,
                'mrp_price' => $cartItem->mrp_price,
                'tax' => $cartItem->tax * $cartItem->quantity,
                'shipping_cost' => $order_detail_shipping_cost,
                'quantity' => $cartItem->quantity,
                'payment_status' => $request->payment_status
            ]);
            $product->update([
                'num_of_sale' => DB::raw('num_of_sale + ' . $cartItem->quantity)
            ]);
        }
        // apply coupon usage
        if ($request->coupon_code != '') {
            CouponUsage::create([
                'user_id' => $request->user_id,
                'coupon_id' => Coupon::where('code', $request->coupon_code)->first()->id
            ]);
        }
        // calculate commission
        $commission_percentage = BusinessSetting::where('type', 'vendor_commission')->first()->value;
        foreach ($order->orderDetails as $orderDetail) {
            if ($orderDetail->product->user->user_type == 'seller') {
                $seller = $orderDetail->product->user->seller;
                $price = $orderDetail->price + $orderDetail->tax + $orderDetail->shipping_cost;
                $seller->admin_to_pay = ($request->payment_type == 'cash_on_delivery') ? $seller->admin_to_pay - ($price * $commission_percentage) / 100 : $seller->admin_to_pay + ($price * (100 - $commission_percentage)) / 100;
                $seller->save();
            }
        }
        // clear user's cart
        $user = User::findOrFail($request->user_id);
        $user->carts()->delete();
        $list=OrderDetail::where('order_id', $order->id)->get();
        $list_data=Order::where('id',$order->id)->with('orderDetails.product.category')->first();
        $list_data['mrp_total']= $list->sum('mrp_price');
        $list_data['discounted_total']=$list->sum('price');
        $list_data['shipping_total']= $list->sum('shipping_cost');
        
        
        $phone = $shippingAddress->phone;
        if(empty($phone)){
            $phone = $user->phone;
        }
        $user_name = $shippingAddress->name;
        if(empty($user_name)){
            $user_name = $user->name;
        }
        $user_email = $shippingAddress->email;
        if(empty($user_email)){
            $user_email = $user->email;
        }
        
         Msg91::sms()->to('91'.$phone)->flow('6348ff7c5e139624812fe894')->variable('user', $user_name)->variable('status', 'placed')->variable('orderid', $order->code)->variable('link', 'https://thebanarasisaree.com')->send();
        
        
            $array['view'] = 'emails.invoice';
            $array['subject'] = 'Your order has been placed - '.$order->code;
            $array['from'] = env('MAIL_USERNAME');
            $array['order'] = $order;
            
                    Mail::to($user_email)->queue(new InvoiceEmailManager($array));
                    Mail::to('techuptechnologies1@gmail.com')->queue(new InvoiceEmailManager($array));
                    
                    sendWebNotification('Order Placed','New Order is Placed.Order Code Is:'.$order->code);
        
        $recipients=User::where('id',$request->user_id)->pluck('device_key')->toArray();
        fcm()->to($recipients)->priority('high')->timeToLive(0)->notification([
            'title'=>"Order Confirmation",
            'body'=>"Thank You,Your order has been placed successfully.Order Code Is:".$order->code,
             //'image'=>$news_img_url,
            ])->send();
        
        return response()->json([
            'data'=>$list_data,
            'success' => true,
            'message' => 'Your order has been placed successfully'
        ]);
    }

    public function store(Request $request)
    {
        return $this->processOrder($request);
    }
    
    public function paymentInitialization(Request $request)
    {
        $api = new Api(env('RAZOR_KEY'), env('RAZOR_SECRET'));
        $response = $api->order->create(array('receipt' => rand(11111,99999), 'amount' => $request->amount*100, 'currency' => 'INR', 'notes'=> array('user_id'=> $request->user_id,'key'=> env('RAZOR_KEY'))));
            
        return ['order_id'=>$response->id,'entity'=>$response->entity,'amount'=>round($response->amount/100),'amount_paid'=>$response->amount_paid,'currnecy'=>$response->currency,'receipt'=>$response->receipt,'status'=>$response->status,'attempts'=>$response->attempts,'user_id'=>$response->notes->user_id,'key'=>$response->notes->key];
     
    }
    
    public function verify_payment_signature(Request $request)
    {
        $api = new Api(env('RAZOR_KEY'), env('RAZOR_SECRET'));
        $response = $api->utility->verifyPaymentSignature(array('razorpay_order_id' => $request->razorpay_order_id, 'razorpay_payment_id' => $request->razorpay_payment_id, 'razorpay_signature' => $request->razorpay_signature));
         
        if($response == 1)
        {
            return response()->json(['message'=>'Payment Success']);
        }
        else
        {
            return response()->json(['message'=>'Payment Fail'],401);
        }
        
    }
    
     public function order_cancel(Request $request)
    {
        
        $order_detail = OrderDetail::findOrFail($request->id);
        $order_detail->product_status = $request->status;
        $order_detail->delivery_status = $request->status;
        
        
        if($request->status=='return'){
            $order_detail->return_reason = $request->return_reason;
            $order_detail->return_date=strtotime('now');
        }
         if($request->status=='cancel'){
          $order_detail->cancel_reason = $request->cancel_reason;
          $order_detail->cancel_date =strtotime('now');
     
        }
           $order_detail->save();
            if ($order_detail->product != null && $order_detail->product->refundable == 1 &&  $order_detail->payment_status=='paid') {
            
        $refund = new RefundRequest;
        $refund->user_id =$request->user_id ;
        $refund->order_id = $order_detail->order_id;
        $refund->order_detail_id = $order_detail->id;
        $refund->refundable_type=$request->refundable_type;
        $refund->seller_id = $order_detail->seller_id;
        $refund->seller_approval = 0;
        $refund->reason = $request->cancel_reason !=null ? $request->cancel_reason : $request->return_reason ;
        $refund->admin_approval = 0;
        $refund->admin_seen = 0;
        $refund->refund_amount = $request->refund_amount;
        $refund->refund_status = 0;
        $refund->save();
        
        
        $refund_payment_details=new RefundPaymentDetail;
        $refund_payment_details->request_id=$refund->id;
        $refund_payment_details->user_id=$request->user_id ;
        $refund_payment_details->order_id=$order_detail->order_id;
        $refund_payment_details->order_detail_id=$order_detail->id;
        $refund_payment_details->product_id=$request->product_id ;
        $refund_payment_details->is_bank='1' ;
        $refund_payment_details->bank_name=$request->bank_name;
        $refund_payment_details->account_name=$request->account_name;
        $refund_payment_details->account_number=$request->account_number;
        $refund_payment_details->ifsc_code=$request->ifsc_code;
        $refund_payment_details->save();
        
        return response()->json([
            'status'=>200,
            'success' => true,
            'message' => 'Your Return Request Have been Placed Successfully and The Amount will be reflected within 3 Working Days after Successful Pickup.',
         ]);
       
        
        }else{
        
        return response()->json([
            'status'=>200,
            'success' => true,
            'message' => 'Your order has been cancled successfully',
         ]);
       }
        
    }
    
}
