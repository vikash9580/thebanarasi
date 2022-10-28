<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Session;
use Redirect;
use App\Order;
use App\Seller;
use Razorpay\Api\Api;
use Illuminate\Support\Facades\Input;
use App\CustomerPackage;
use App\SellerPackage;
use App\Http\Controllers\CustomerPackageController;
use Auth;
use App\Models\Cart;
use App\Product;
use App\Address;

class RazorpayController extends Controller
{
    public function payWithRazorpays($request)
    {
        if(Session::has('payment_type')){
            if(Session::get('payment_type') == 'cart_payment'){
                $order = Order::findOrFail(Session::get('order_id'));
                return view('frontend.razor_wallet.order_payment_Razorpay', compact('order'));
            }
             if(Session::get('payment_type') == 'sample_payment'){
                   
                    $order=300;
                return view('frontend.razor_wallet.request_sample_payment_Razorpay', compact('order'));
            }
            elseif (Session::get('payment_type') == 'wallet_payment') {
                return view('frontend.razor_wallet.wallet_payment_Razorpay');
            }
            elseif (Session::get('payment_type') == 'customer_package_payment') {
                return view('frontend.razor_wallet.customer_package_payment_Razorpay');
            }
            elseif (Session::get('payment_type') == 'seller_package_payment') {
                return view('frontend.razor_wallet.seller_package_payment_Razorpay');
            }
        }

    }

    public function payment(Request $request)
    {
        //Input items of form
        $input = $request->all();
        //get API Configuration
        $api = new Api(env('RAZOR_KEY'), env('RAZOR_SECRET'));

        //Fetch payment information by razorpay_payment_id
        $payment = $api->payment->fetch($input['razorpay_payment_id']);

        if(count($input)  && !empty($input['razorpay_payment_id'])) {
            $payment_detalis = null;
            try {
                $response = $api->payment->fetch($input['razorpay_payment_id'])->capture(array('amount'=>$payment['amount']));
                $payment_detalis = json_encode(array('id' => $response['id'],'method' => $response['method'],'amount' => $response['amount'],'currency' => $response['currency']));
            } catch (\Exception $e) {
                return  $e->getMessage();
                \Session::put('error',$e->getMessage());
                return redirect()->back();
            }

            // Do something here for store payment details in database...
            if(Session::has('payment_type')){
                if(Session::get('payment_type') == 'cart_payment'){
                    
                    
                 $request->payment_option='razorpay';
                 $request->order_id= $request->session()->get('order_id');
                 
                 $cart_user_id=Cart::where('order_id',$request->order_id)->first();
                 
                 $request->user_id=$cart_user_id->user_id;
                 $request->name= $request->session()->get('shipping_info')['name'];
                 $request->email= $request->session()->get('shipping_info')['email'];
                 $request->address=$request->session()->get('shipping_info')['address'];
                 $request->city=$request->session()->get('shipping_info')['city'];
                 $request->state= $request->session()->get('shipping_info')['state'];
                 $request->pincode=$request->session()->get('shipping_info')['postal_code'];
                 $request->country=$request->session()->get('shipping_info')['country'];
                 $request->phone=$request->session()->get('shipping_info')['phone'];
                 $request->email=$request->session()->get('shipping_info')['email'];
                 
                 
                 
                 $request->checkout_type='logged';
                 
                 $payment = ["status" => "Success"];
                 
                 $orderController = new OrderController;
                 $orderController->store($request);
                    
                    
                    
                    $checkoutController = new CheckoutController;
                    return $checkoutController->checkout_done(Session::get('order_id'), $payment_detalis);
                    
                    
                    
                }
                elseif (Session::get('payment_type') == 'wallet_payment') {
                    $walletController = new WalletController;
                    return $walletController->wallet_payment_done(Session::get('payment_data'), $payment_detalis);
                }
                elseif (Session::get('payment_type') == 'customer_package_payment') {
                    $customer_package_controller = new CustomerPackageController;
                    return $customer_package_controller->purchase_payment_done(Session::get('payment_data'), $payment);
                }
                elseif (Session::get('payment_type') == 'seller_package_payment') {
                    $seller_package_controller = new SellerPackageController;
                    return $seller_package_controller->purchase_payment_done(Session::get('payment_data'), $payment);
                }
            }
        }
    }
    
     public function payWithRazorpay(Request $request)
    {
               
                if (Auth::check()) {
            if (($request->address_id == null)) {
                flash(translate("Please add shipping address"))->warning();
                return back();
            }
            
            if(Auth::user()->phone == null){
                flash(translate("Please Verify Phone"))->info();
                return back();
            }
            if(Auth::user()->email == null){
                flash(translate("Please Verify Email"))->info();
                return back();
            }
            
            $address = Address::findOrFail($request->address_id);
            $data['address_id'] =$request->address_id;
            $data['name'] = Auth::user()->name;
            $data['email'] = Auth::user()->email;
            $data['address'] = $address->address;
            $data['country'] = $address->country;
            $data['state'] = $address->state;
            $data['city'] = $address->city;
            $data['postal_code'] = $address->postal_code;
            $data['phone'] = $address->phone;
            $data['landmark'] = $address->landmark;
            $data['checkout_type'] = $request->checkout_type;
        } else {
            $data['name'] = $request->name;
            $data['email'] = $request->email;
            $data['address'] = $request->address;
            $data['country'] = $request->country;
            $data['state'] = $request->state;
            $data['city'] = $request->city;
            $data['postal_code'] = $request->postal_code;
            $data['phone'] = $request->phone;
            $data['landmark'] =$request->landmark;
            $data['checkout_type'] = $request->checkout_type;
        }

        $shipping_info = $data;
        $request->session()->put('shipping_info', $shipping_info);
               
               
               
                   $subtotal = 0;
                   $tax = 0;
                   $shipping = 0;
                    foreach (Cart::where('user_id',Auth::user()->id)->where('payment_status',0)->get() as $key => $cartItem){
                            
                    $product = Product::find($cartItem['product_id']);
                    $subtotal += $cartItem['price']*$cartItem['quantity'];
                    $tax += $cartItem['tax']*$cartItem['quantity'];
                    $shipping += getShippingCost($key);
                     }
                  
                    $grand_total =  $subtotal + $tax + $shipping; 
                    
                    $order_id= date('Ymd-His').rand(10,99);
                     session()->put('order_id', $order_id);
                    
                  foreach(Cart::where('user_id',Auth::user()->id)->where('payment_status',0)->get() as $cart_list){
                      
                      $cart_data=Cart::findOrFail($cart_list->id);
                      $cart_data->payment_status=1;
                      $cart_data->order_id= $order_id;
                      $cart_data->save();
                      
                  }
                  
                   return view('frontend.razor_wallet.order_payment_Razorpay', compact('grand_total','order_id'));   
                  
                  
        
    }
    
    
}
