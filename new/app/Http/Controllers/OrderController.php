<?php



namespace App\Http\Controllers;



use Illuminate\Http\Request;

use App\Http\Controllers\OTPVerificationController;

use App\Http\Controllers\ClubPointController;

use App\Http\Controllers\AffiliateController;

use App\Order;

use App\Product;

use App\ProductStock;

use App\Color;

use App\OrderDetail;

use App\CouponUsage;

use App\OtpConfiguration;

use App\User;

use App\BusinessSetting;

use Auth;

use Session;

use DB;

use PDF;

use Mail;

use App\Mail\InvoiceEmailManager;

use App\Models\Cart;

use App\Address;

//use CoreComponentRepository;

use Seshac\Shiprocket\Shiprocket;

use App\Wallet;

use App\Coupon;



class OrderController extends Controller

{

    /**

     * Display a listing of the resource to seller.

     *

     * @return \Illuminate\Http\Response

     */

    public function index(Request $request)

    {

        $payment_status = null;

        $delivery_status = null;

        $sort_search = null;

        $orders = DB::table('orders')

                    ->orderBy('code', 'desc')

                    ->join('order_details', 'orders.id', '=', 'order_details.order_id')

                    ->where('order_details.seller_id', Auth::user()->id)

                    ->select('orders.id')

                    ->distinct();



        if ($request->payment_status != null){

            $orders = $orders->where('order_details.payment_status', $request->payment_status);

            $payment_status = $request->payment_status;

        }

        if ($request->delivery_status != null) {

            $orders = $orders->where('order_details.delivery_status', $request->delivery_status);

            $delivery_status = $request->delivery_status;

        }

        if ($request->has('search')){

            $sort_search = $request->search;

            $orders = $orders->where('code', 'like', '%'.$sort_search.'%');

        }



        $orders = $orders->paginate(15);



        foreach ($orders as $key => $value) {

            $order = \App\Order::find($value->id);

            $order->viewed = 1;

            $order->save();

        }



        return view('frontend.user.seller.orders', compact('orders','payment_status','delivery_status', 'sort_search'));

    }



    // All Orders

    public function all_orders(Request $request)

    {

         //CoreComponentRepository::instantiateShopRepository();



         $sort_search = null;

         if(auth()->user()->user_type=="admin"){

            $orders = Order::orderBy('code', 'desc');

         }else{

            $orders = Order::where('staff_id',auth()->user()->id)->orderBy('code', 'desc');

         }

         if ($request->has('search')){

             $sort_search = $request->search;

             $orders = $orders->where('code', 'like', '%'.$sort_search.'%');

         }

         $orders = $orders->paginate(15);

         return view('backend.sales.all_orders.index', compact('orders', 'sort_search'));

    }



    public function all_orders_show($id)

    {

         $order = Order::findOrFail(decrypt($id));

         $order->viewed = 1;

         $order->save();

         return view('backend.sales.all_orders.show', compact('order'));

    }



    // Inhouse Orders

    public function admin_orders(Request $request)

    {

        //CoreComponentRepository::instantiateShopRepository();



        $payment_status = null;

        $delivery_status = null;

        $sort_search = null;

        $admin_user_id = User::where('user_type', 'admin')->first()->id;

        $orders = DB::table('orders')

                    ->orderBy('code', 'desc')

                    ->join('order_details', 'orders.id', '=', 'order_details.order_id')

                    ->where('order_details.seller_id', $admin_user_id)

                    ->select('orders.id')

                    ->distinct();



        if ($request->payment_type != null){

            $orders = $orders->where('order_details.payment_status', $request->payment_type);

            $payment_status = $request->payment_type;

        }

        if ($request->delivery_status != null) {

            $orders = $orders->where('order_details.delivery_status', $request->delivery_status);

            $delivery_status = $request->delivery_status;

        }

        if ($request->has('search')){

            $sort_search = $request->search;

            $orders = $orders->where('code', 'like', '%'.$sort_search.'%');

        }

        $orders = $orders->paginate(15);

        return view('backend.sales.inhouse_orders.index', compact('orders','payment_status','delivery_status', 'sort_search', 'admin_user_id'));

    }



    public function show($id)

    {

        $order = Order::findOrFail(decrypt($id));

        $order->viewed = 1;

        $order->save();

        return view('backend.sales.inhouse_orders.show', compact('order'));

    }



    // Seller Orders

    public function seller_orders(Request $request)

    {

        //CoreComponentRepository::instantiateShopRepository();



        $payment_status = null;

        $delivery_status = null;

        $sort_search = null;

        $admin_user_id = User::where('user_type', 'admin')->first()->id;

        $orders = DB::table('orders')

                    ->orderBy('code', 'desc')

                    ->join('order_details', 'orders.id', '=', 'order_details.order_id')

                    ->where('order_details.seller_id', '!=' ,$admin_user_id)

                    ->select('orders.id')

                    ->distinct();



        if ($request->payment_type != null){

            $orders = $orders->where('order_details.payment_status', $request->payment_type);

            $payment_status = $request->payment_type;

        }

        if ($request->delivery_status != null) {

            $orders = $orders->where('order_details.delivery_status', $request->delivery_status);

            $delivery_status = $request->delivery_status;

        }

        if ($request->has('search')){

            $sort_search = $request->search;

            $orders = $orders->where('code', 'like', '%'.$sort_search.'%');

        }

        $orders = $orders->paginate(15);

        return view('backend.sales.seller_orders.index', compact('orders','payment_status','delivery_status', 'sort_search', 'admin_user_id'));

    }



    public function seller_orders_show($id)

    {

        $order = Order::findOrFail(decrypt($id));

        $order->viewed = 1;

        $order->save();

        return view('backend.sales.seller_orders.show', compact('order'));

    }





    // Pickup point orders

    public function pickup_point_order_index(Request $request)

    {

        if (Auth::user()->user_type == 'staff' && Auth::user()->staff->pick_up_point != null) {

            //$orders = Order::where('pickup_point_id', Auth::user()->staff->pick_up_point->id)->get();

            $orders = DB::table('orders')

                        ->orderBy('code', 'desc')

                        ->join('order_details', 'orders.id', '=', 'order_details.order_id')

                        ->where('order_details.pickup_point_id', Auth::user()->staff->pick_up_point->id)

                        ->select('orders.id')

                        ->distinct()

                        ->paginate(15);



            return view('backend.sales.pickup_point_orders.index', compact('orders'));

        }

        else{

            //$orders = Order::where('shipping_type', 'Pick-up Point')->get();

            $orders = DB::table('orders')

                        ->orderBy('code', 'desc')

                        ->join('order_details', 'orders.id', '=', 'order_details.order_id')

                        ->where('order_details.shipping_type', 'pickup_point')

                        ->select('orders.id')

                        ->distinct()

                        ->paginate(15);



            return view('backend.sales.pickup_point_orders.index', compact('orders'));

        }

    }



    public function pickup_point_order_sales_show($id)

    {

        if (Auth::user()->user_type == 'staff') {

            $order = Order::findOrFail(decrypt($id));

            return view('backend.sales.pickup_point_orders.show', compact('order'));

        }

        else{

            $order = Order::findOrFail(decrypt($id));

            return view('backend.sales.pickup_point_orders.show', compact('order'));

        }

    }



    /**

     * Display a single sale to admin.

     *

     * @return \Illuminate\Http\Response

     */





    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function create()

    {

        //

    }



    /**

     * Store a newly created resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */

    public function store(Request $request)

    {

      

        $order = new Order;
        $order->user_id = $request->user_id;
        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['address'] =$request->address;
        $data['country'] = $request->country;
        $data['state'] = $request->state;
        $data['city'] = $request->city;
        $data['postal_code'] = $request->pincode;
        $data['phone'] = $request->phone;
        $data['land_mark'] = $request->land_mark;
        $data['checkout_type'] = $request->checkout_type;
        $shipping_info = $data;

        

   if(!empty($request->name)){

        $order->shipping_address= json_encode($shipping_info);

   }else{
         $order->shipping_address= json_encode($request->session()->get('shipping_info'));

   }


        $order->payment_type = $request->payment_option;

        $order->delivery_viewed = '0';

        $order->payment_status_viewed = '0';

        if(!empty($request->order_id)){

        $order->code = $request->order_id;

        }

        else{

             $order->code = date('Ymd-His').rand(10,99);

        }

        $order->date = strtotime('now');



        if($order->save()){

            $subtotal = 0;

            $tax = 0;

            $shipping = 0;



            //calculate shipping is to get shipping costs of different types

            $admin_products = array();

            $seller_products = array();



            //Order Details Storing

            foreach (Cart::where('order_id',$request->order_id)->where('payment_status',1)->get() as $key => $cartItem){

                $product = Product::find($cartItem['product_id']);



                if($product->added_by == 'admin'){

                    array_push($admin_products, $cartItem['product_id']);

                }

                else{

                    $product_ids = array();

                    if(array_key_exists($product->user_id, $seller_products)){

                        $product_ids = $seller_products[$product->user_id];

                    }

                    array_push($product_ids, $cartItem['product_id']);

                    $seller_products[$product->user_id] = $product_ids;

                }



                $subtotal += $cartItem['price']*$cartItem['quantity'];

                $tax += $cartItem['tax']*$cartItem['quantity'];



                $product_variation = $cartItem['variant'];



               



                $order_detail = new OrderDetail;

                $order_detail->order_id  =$order->id;

                $order_detail->seller_id = $product->user_id;

                $order_detail->product_id = $product->id;

                $order_detail->variation = $product_variation;

                $order_detail->price = $cartItem['price'] * $cartItem['quantity'];

                $order_detail->tax = $cartItem['tax'] * $cartItem['quantity'];

                $order_detail->shipping_type = $cartItem['shipping_type'];

                $order_detail->product_referral_code = $cartItem['product_referral_code'];



                //Dividing Shipping Costs

                if ($cartItem['shipping_type'] == 'home_delivery') {

                    $order_detail->shipping_cost = getShippingCost($key);

                    $shipping += $order_detail->shipping_cost;

                }

                else{

                    $order_detail->shipping_cost = 0;

                    $order_detail->pickup_point_id = $cartItem['pickup_point'];

                }

                //End of storing shipping cost



                $order_detail->quantity = $cartItem['quantity'];

                $order_detail->save();



                $product->num_of_sale++;

                $product->save();

            }



            // $order->grand_total = $subtotal + $tax + $shipping;

            $order->grand_total = $subtotal +  $shipping;



       if(Session::has('wallet_discount'))

            {

             if($order->grand_total > Session::get('wallet_discount')){

                   $order->wallet_discount = Session::get('wallet_discount');



                          $wallet = new Wallet;

                          $wallet->user_id =  $order->user_id;

                          $wallet->amount =  $order->wallet_discount;

                          $wallet->payment_method = 'Wallet';

                          $wallet->payment_details = 'Pay For Order';

                          $wallet->payment_type='debited';

                          $wallet->save();



                           $user = Auth::user();

                           $user->balance -= $order->wallet_discount;

                           $user->save();



               }

               if($order->grand_total < Session::get('wallet_discount')){

                   $order->wallet_discount = $order->grand_total;



                          $wallet = new Wallet;

                          $wallet->user_id =  $order->user_id;

                          $wallet->amount =  $order->wallet_discount;

                          $wallet->payment_method = 'Wallet';

                          $wallet->payment_details = 'Pay For Order';

                          $wallet->payment_type='debited';

                          $wallet->save();



                           $user = Auth::user();

                           $user->balance -= $order->wallet_discount;

                           $user->save();



               }

            }



            if(Session::has('coupon_discount')){

                $order->grand_total -= Session::get('coupon_discount');

                $order->coupon_discount = Session::get('coupon_discount');



                $coupon_usage = new CouponUsage;

                $coupon_usage->user_id = $request->user_id;

                $coupon_usage->coupon_id = Session::get('coupon_id');

                $coupon_usage->save();

            }



            $order->save();



            $array['view'] = 'emails.invoice';

            $array['subject'] = 'Your order has been placed - '.$order->code;

            $array['from'] = env('MAIL_USERNAME');

            $array['order'] = $order;



            foreach($seller_products as $key => $seller_product){

                try {

                    Mail::to(\App\User::find($key)->email)->queue(new InvoiceEmailManager($array));

                } catch (\Exception $e) {



                }

            }



            if (\App\Addon::where('unique_identifier', 'otp_system')->first() != null && \App\Addon::where('unique_identifier', 'otp_system')->first()->activated && \App\OtpConfiguration::where('type', 'otp_for_order')->first()->value){

                try {

                    $otpController = new OTPVerificationController;

                    $otpController->send_order_code($order);

                } catch (\Exception $e) {



                }

            }



            //sends email to customer with the invoice pdf attached

            if(env('MAIL_USERNAME') != null){

                try {

                    Mail::to($request->session()->get('shipping_info')['email'])->queue(new InvoiceEmailManager($array));

                    Mail::to(User::where('user_type', 'admin')->first()->email)->queue(new InvoiceEmailManager($array));

                } catch (\Exception $e) {



                }

            }

             $cart_delete = Cart::where('order_id',$request->order_id)->where('payment_status',1)->delete();;

           

            $request->session()->put('order_id', $order->id);

            sendWebNotification('Order Placed','New Order is Placed');

        }

    }



    /**

     * Display the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */





    /**

     * Show the form for editing the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function edit($id)

    {

        //

    }



    /**

     * Update the specified resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function update(Request $request, $id)

    {

        //

    }



    /**

     * Remove the specified resource from storage.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function destroy($id)

    {

        $order = Order::findOrFail($id);

        if($order != null){

            foreach($order->orderDetails as $key => $orderDetail){

                if ($orderDetail->variantion != null) {

                    $product_stock = ProductStock::where('product_id', $orderDetail->product_id)->where('variant', $orderDetail->variantion)->first();

                    if($product_stock != null){

                        $product_stock->qty += $orderDetail->quantity;

                        $product_stock->save();

                    }

                }

                else {

                    $product = $orderDetail->product;

                    $product->current_stock += $orderDetail->quantity;

                    $product->save();

                }

                $orderDetail->delete();

            }

            $order->delete();

            flash(translate('Order has been deleted successfully'))->success();

        }

        else{

            flash(translate('Something went wrong'))->error();

        }

        return back();

    }

    

     public function order_cancel($id)

    {

        $order = Order::findOrFail($id);

        if($order != null){

            foreach($order->orderDetails as $key => $orderDetail){

                if ($orderDetail->variantion != null) {

                    $product_stock = ProductStock::where('product_id', $orderDetail->product_id)->where('variant', $orderDetail->variantion)->first();

                    if($product_stock != null){

                        $product_stock->qty += $orderDetail->quantity;

                        $product_stock->save();

                    }

                }

                else {

                    $product = $orderDetail->product;

                    $product->current_stock += $orderDetail->quantity;

                    $product->save();

                }

                      $orderDetail->delivery_status = 'cancel';

                      $orderDetail->cancel_date =strtotime('now');

                      $orderDetail->save();

            }

          

            flash(translate('Order has been cancel successfully'))->success();

        }

        else{

            flash(translate('Something went wrong'))->error();

        }

        return back();

    }

    



    public function order_details(Request $request)

    {

        $order = Order::findOrFail($request->order_id);

        //$order->viewed = 1;

        $order->save();

        return view('frontend.user.seller.order_details_seller', compact('order'));

    }



     public function update_delivery_status(Request $request)

    {

        $order = Order::findOrFail($request->order_id);

        $order->delivery_viewed = '0';

        $order->save();

        $user_details = User::findOrFail($order->user_id);

        $recipients=User::where('id', $order->user_id)->pluck('device_key')->toArray();

        fcm()->to($recipients)->priority('high')->timeToLive(0)->notification([

            'title'=>"Order Status",

            'body'=>"Your Order Staus Is Changed to ".$request->status,

             //'image'=>$news_img_url,

            ])->send();

        if(Auth::user()->user_type == 'seller'){

            foreach($order->orderDetails->where('seller_id', Auth::user()->id) as $key => $orderDetail){

                $orderDetail->delivery_status = $request->status;

                $orderDetail->save();

            }

        }

        else{

            foreach($order->orderDetails as $key => $orderDetail){

                if($orderDetail->product_status != 'cancel'){

                $orderDetail->delivery_status = $request->status;

                

                // if($request->status=='confirmed'){

                //     $orderDetail->product_status = $request->status;

                // }

                

                if($request->status=='cancel'){

                    $orderDetail->product_status = $request->status;

                      $orderDetail->cancel_date =strtotime('now');

                }

                if($request->status=='confirmed'){

                  

                      $orderDetail->confirmed_date =strtotime('now');

                }

                if($request->status=='on_delivery'){

                    $orderDetail->shipping_date = strtotime('now');

                    $orderDetail->expacted_delivery = strtotime($request->expacted_delivery);

                }

                if($request->status=='delivered'){

                    $orderDetail->delivered_date = strtotime('now');

                   

                }

                if($request->status=='pending'){

                  

                      $orderDetail->confirmed_date ='';

                      $orderDetail->shipping_date ='' ;

                       $orderDetail->delivered_date ='' ;

                        $orderDetail->expacted_delivery ='' ;

                }

                

                $orderDetail->save();

                }

            }

             

            

        }

        

        

        if($request->status=='on_delivery'){

                $data=array();

                 foreach ($order->orderDetails as $key => $orderDetail){

                     

                     array_push($data,['name'=>$orderDetail->product->name,'hsn'=>$orderDetail->product->hsn_code,'selling_price'=>$orderDetail->price,'units'=>$orderDetail->quantity,'discount'=>'','tax'=>'','sku'=>$orderDetail->product->name]); 

                 }

                



      $payment_type_shipping='COD';

           if($order->payment_type=='razorpay'){

            $payment_type_shipping='PREPAID';

           }



                  $orderDetails = [

                             "order_id"=>$order->code,

                             "order_date"=>$order->created_at,

                             "pickup_location"=>"THE BANARASI SAREE",

                             "channel_id"=>"",

                             "comment"=>"",

                             "billing_customer_name"=>json_decode($order->shipping_address)->name,

                             "billing_last_name"=>'',

                             "billing_address"=>json_decode($order->shipping_address)->address,

                             "billing_address_2"=>json_decode($order->shipping_address)->address,

                             "billing_city"=>json_decode($order->shipping_address)->city,

                             "billing_pincode"=>json_decode($order->shipping_address)->postal_code,

                             "billing_state"=>json_decode($order->shipping_address)->state,

                             "billing_country"=>json_decode($order->shipping_address)->country,

                             "billing_email"=>json_decode($order->shipping_address)->email,

                             "billing_phone"=>$user_details->phone,

                             "shipping_is_billing"=>true,

                            //  "shipping_customer_name"=>json_decode($order->shipping_address)->name,

                            //  "shipping_last_name"=>json_decode($order->shipping_address)->name,

                            //  "shipping_address"=>json_decode($order->shipping_address)->address,

                            //  "shipping_address_2"=>json_decode($order->shipping_address)->address,

                            //  "shipping_city"=>json_decode($order->shipping_address)->city,

                            //  "shipping_pincode"=>json_decode($order->shipping_address)->postal_code,

                            //  "shipping_country"=>json_decode($order->shipping_address)->country,

                            //  "shipping_state"=>json_decode($order->shipping_address)->state,

                            //  "shipping_phone"=>json_decode($order->shipping_address)->phone,

                             

                             "payment_method"=>$payment_type_shipping,

                             "shipping_charges"=>$order->orderDetails->sum('shipping_cost'),

                             "giftwrap_charges"=>'',

                             "transaction_charges"=>0,

                             "total_discount"=>0,

                             "sub_total"=>$order->grand_total-$order->orderDetails->sum('shipping_cost')-$order->coupon_discount-$order->wallet_discount,

                             "length"=>$request->length,

                             "breadth"=>$request->breadth,

                             "height"=>$request->height,

                             "weight"=>$request->weight,

                             "order_items"=>$data

                         ];

                  $token =  Shiprocket::getToken();

                  $response =  Shiprocket::order($token)->create($orderDetails);

               if(!empty($response['shipment_id'])){

                      $order->shipment_id=$response['shipment_id'];

                      $order->save();

                       return 1;

               }

            

        }

        

        



        if (\App\Addon::where('unique_identifier', 'otp_system')->first() != null && \App\Addon::where('unique_identifier', 'otp_system')->first()->activated && \App\OtpConfiguration::where('type', 'otp_for_delivery_status')->first()->value){

            try {

                $otpController = new OTPVerificationController;

                $otpController->send_delivery_status($order);

            } catch (\Exception $e) {

            }

        }

        

        

        



        return 1;

    }

     public function update_delivery_status_single(Request $request)

    {

        

        

        

        $order = Order::findOrFail($request->order_id);

        $order->delivery_viewed = '0';

        $order->save();

        

        $order_detail = OrderDetail::findOrFail($request->id);

        $order_detail->product_status = $request->status;

        $order_detail->delivery_status = $request->status;

        if(isset($request->cancel_reason)){

            $order_detail->cancel_reason = $request->cancel_reason;

            $order_detail->cancel_date =strtotime('now');

        }

        if(isset($request->return_reason)){

            $order_detail->return_reason = $request->return_reason;

            $order_detail->return_date =strtotime('now');

        }

         if($request->status=='confirmed'){

        $order_detail->confirmed_date =strtotime('now');

        $order_detail->cancel_reason = "";

        $order_detail->cancel_date ="";

        $order_detail->return_reason = "";

        $order_detail->return_date ="";

        }

        

        $order_detail->save();



        // if (\App\Addon::where('unique_identifier', 'otp_system')->first() != null && \App\Addon::where('unique_identifier', 'otp_system')->first()->activated && \App\OtpConfiguration::where('type', 'otp_for_delivery_status')->first()->value){

        //     try {

        //         $otpController = new OTPVerificationController;

        //         $otpController->send_delivery_status($order);

        //     } catch (\Exception $e) {

        //     }

        // }

        

       

        

        



        return 1;

    }



    public function update_payment_status(Request $request)

    {

        $order = Order::findOrFail($request->order_id);

        $order->payment_status_viewed = '0';

        $order->save();



        if(Auth::user()->user_type == 'seller'){

            foreach($order->orderDetails->where('seller_id', Auth::user()->id) as $key => $orderDetail){

                $orderDetail->payment_status = $request->status;

                $orderDetail->save();

            }

        }

        else{

            foreach($order->orderDetails as $key => $orderDetail){

                $orderDetail->payment_status = $request->status;

                $orderDetail->save();

            }

        }



        $status = 'paid';

        foreach($order->orderDetails as $key => $orderDetail){

            if($orderDetail->payment_status != 'paid'){

                $status = 'unpaid';

            }

        }

        $order->payment_status = $status;

        $order->save();





        if($order->payment_status == 'paid' && $order->commission_calculated == 0){

            if(\App\Addon::where('unique_identifier', 'seller_subscription')->first() == null || !\App\Addon::where('unique_identifier', 'seller_subscription')->first()->activated){

                if ($order->payment_type == 'cash_on_delivery') {

                    if (BusinessSetting::where('type', 'category_wise_commission')->first()->value != 1) {

                        $commission_percentage = BusinessSetting::where('type', 'vendor_commission')->first()->value;

                        foreach ($order->orderDetails as $key => $orderDetail) {

                            $orderDetail->payment_status = 'paid';

                            $orderDetail->save();

                            if($orderDetail->product->user->user_type == 'seller'){

                                $seller = $orderDetail->product->user->seller;

                                $seller->admin_to_pay = $seller->admin_to_pay - ($orderDetail->price*$commission_percentage)/100;

                                $seller->save();

                            }

                        }

                    }

                    else{

                        foreach ($order->orderDetails as $key => $orderDetail) {

                            $orderDetail->payment_status = 'paid';

                            $orderDetail->save();

                            if($orderDetail->product->user->user_type == 'seller'){

                                $commission_percentage = $orderDetail->product->category->commision_rate;

                                $seller = $orderDetail->product->user->seller;

                                $seller->admin_to_pay = $seller->admin_to_pay - ($orderDetail->price*$commission_percentage)/100;

                                $seller->save();

                            }

                        }

                    }

                }

                elseif($order->manual_payment) {

                    if (BusinessSetting::where('type', 'category_wise_commission')->first()->value != 1) {

                        $commission_percentage = BusinessSetting::where('type', 'vendor_commission')->first()->value;

                        foreach ($order->orderDetails as $key => $orderDetail) {

                            $orderDetail->payment_status = 'paid';

                            $orderDetail->save();

                            if($orderDetail->product->user->user_type == 'seller'){

                                $seller = $orderDetail->product->user->seller;

                                $seller->admin_to_pay = $seller->admin_to_pay + ($orderDetail->price*(100-$commission_percentage))/100 + $orderDetail->tax + $orderDetail->shipping_cost;

                                $seller->save();

                            }

                        }

                    }

                    else{

                        foreach ($order->orderDetails as $key => $orderDetail) {

                            $orderDetail->payment_status = 'paid';

                            $orderDetail->save();

                            if($orderDetail->product->user->user_type == 'seller'){

                                $commission_percentage = $orderDetail->product->category->commision_rate;

                                $seller = $orderDetail->product->user->seller;

                                $seller->admin_to_pay = $seller->admin_to_pay + ($orderDetail->price*(100-$commission_percentage))/100 + $orderDetail->tax + $orderDetail->shipping_cost;

                                $seller->save();

                            }

                        }

                    }

                }

            }



            if (\App\Addon::where('unique_identifier', 'affiliate_system')->first() != null && \App\Addon::where('unique_identifier', 'affiliate_system')->first()->activated) {

                $affiliateController = new AffiliateController;

                $affiliateController->processAffiliatePoints($order);

            }



            if (\App\Addon::where('unique_identifier', 'club_point')->first() != null && \App\Addon::where('unique_identifier', 'club_point')->first()->activated) {

                $clubpointController = new ClubPointController;

                $clubpointController->processClubPoints($order);

            }



            $order->commission_calculated = 1;

            $order->save();

        }



        if (\App\Addon::where('unique_identifier', 'otp_system')->first() != null && \App\Addon::where('unique_identifier', 'otp_system')->first()->activated && \App\OtpConfiguration::where('type', 'otp_for_paid_status')->first()->value){

            try {

                $otpController = new OTPVerificationController;

                $otpController->send_payment_status($order);

            } catch (\Exception $e) {

            }

        }

        return 1;

    }

     public function wholesale_order_store(Request $request)

    {

      $grand_total=0;

      $shipping_cost=$request->shipping_cost;

     

      foreach($request->product_id as $key=>$value){

                if($request->variation[$key]){

                     $order_detail = OrderDetail::where('order_id',$request->order_id)->where('product_id',$value)->where('variation',$request->variation[$key])->first();

                }else{

                $order_detail = OrderDetail::where('order_id',$request->order_id)->where('product_id',$value)->first();

                }

                

                 $order_detail->price = $request->order_price[$key]*$request->order_quantity[$key];

                

                 $grand_total=$grand_total+ $order_detail->price;

                 

                $order_detail->shipping_cost=$shipping_cost/count($request->product_id);

                 $order_detail->quantity = $request->order_quantity[$key];

                 

                

                 

                $order_detail->save();

              //return $order_detail;

         

      }

       $order =  Order::where('id',$request->order_id)->first();

     

        $order->grand_total = $grand_total+$shipping_cost;

        

        

   $order->save();

           flash(translate('Order has been updated successfully'))->success();

  return redirect()->route('all_orders.show', encrypt($order->id));

  

    }

}

