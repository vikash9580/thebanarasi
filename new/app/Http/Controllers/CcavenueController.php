<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Order;
use App\Seller;
use App\Http\Controllers\Controller;
use Mehedi\Paystack\Paystack;
use App\CustomerPackage;
use App\SellerPackage;
use App\Http\Controllers\CustomerPackageController;
use Auth;
use Session;
use Redirect;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CheckoutController;
use App\Product;
use App\Models\Cart;
use App\Address;

class CcavenueController extends Controller
{
    public function ccavenue(Request $request)
    {
               
                   $subtotal = 0;
                   $tax = 0;
                   $shipping = 0;
                    foreach (Cart::where('user_id',Auth::user()->id)->where('payment_status',0)->get() as $key => $cartItem){
                        
                    $product = Product::find($cartItem['product_id']);
                    $subtotal += $cartItem['price']*$cartItem['quantity'];
                    $tax += $cartItem['tax']*$cartItem['quantity'];
                    $shipping += getShippingCost($key);
                     }
                  
                    $grand_total =  $subtotal + $shipping; 
                    
                    $order_id= date('Ymd-His').rand(10,99);
                    
                  foreach(Cart::where('user_id',Auth::user()->id)->where('payment_status',0)->get() as $cart_list){
                      
                      $cart_data=Cart::findOrFail($cart_list->id);
                      $cart_data->payment_status=1;
                      $cart_data->order_id= $order_id;
                      $cart_data->save();
                      
                  }
                  
                    
                  
                    $post_data = array();
                    $_POST['tid'] = rand(11111111,99999999);
                    $_POST['amount'] =$grand_total; # You cant not pay less than 10
                    $_POST['currency'] = "INR";
                    // tran_id must be unique

                    $_POST['merchant_id'] = '402291' ;
                    $_POST['order_id'] =$order_id;
                    $_POST['language'] ="EN";

                    $_POST['redirect_url'] =route('ccavenue.success');
                    $_POST['cancel_url'] =route('ccavenue.cancel');


                    # CUSTOMER INFORMATION
                    $_POST['billing_name'] = $request->session()->get('shipping_info')['name'];
                    $_POST['billing_address'] = $request->session()->get('shipping_info')['address'];
                    $_POST['billing_city'] = $request->session()->get('shipping_info')['city'];
                    $_POST['billing_zip'] = $request->session()->get('shipping_info')['postal_code'];
                    $_POST['billing_state'] = $request->session()->get('shipping_info')['state'];
                    $_POST['billing_country'] = $request->session()->get('shipping_info')['country'];
                    $_POST['billing_tel'] = $request->session()->get('shipping_info')['phone'];
                    $_POST['billing_email'] = $request->session()->get('shipping_info')['email'];
                    
                    
                  
        
                   unset($_POST['payment_option']);
                   unset($_POST['_token']);
        
                   return view('frontend.payment.ccavenue');
    }
    
     public function success(Request $request) {
       
 
  	$workingKey='842F72308DFE6FC100F92AE8AE75A455';//Shared by CCAVENUES//Shared by CCAVENUES	//Working Key should be provided here.
	$encResponse=$_POST["encResp"];			//This is the response sent by the CCAvenue Server
	$rcvdString=$this->decrypts($encResponse,$workingKey);		//Crypto Decryption used as per the specified working key.
	$order_status="";
	$decryptValues=explode('&', $rcvdString);
	$dataSize=sizeof($decryptValues);
	echo "<center>";
	for($i = 0; $i < $dataSize; $i++)
	{
		$information=explode('=',$decryptValues[$i]);
		if($i==0)   $order_id=$information[1];
		if($i==3)	$order_status=$information[1];
		if($i==11)   $name=$information[1];
		if($i==12)   $address=$information[1];
		if($i==13)   $city=$information[1];
		if($i==14)   $state=$information[1];
		if($i==15)   $pincode=$information[1];
		if($i==16)   $country=$information[1];
		if($i==17)   $phone=$information[1];
		if($i==18)   $email=$information[1];
	}

	if($order_status==="Success")
	{
	       
                //return redirect()->route('ccavenue.payment_process'); 
                 $request->payment_option='ccavenue';
                 $request->order_id=$order_id;
                 
                 $cart_user_id=Cart::where('order_id',$order_id)->first();
                 $request->user_id=$cart_user_id->user_id;
                 $request->name=$name;
                 $request->address=$address;
                 $request->city=$city;
                 $request->state=$state;
                 $request->pincode=$pincode;
                 $request->country=$country;
                 $request->phone=$phone;
                 $request->email=$email;
                 $request->checkout_type='logged';
                 
                 $payment = ["status" => "Success"];
                 $orderController = new OrderController;
                 $orderController->store($request);
                
                
                $checkoutController = new CheckoutController;
                return $checkoutController->checkout_done(session()->get('order_id'), json_encode($payment));
                
	}
		if($order_status==="Failure")
	{
	      
             foreach(Cart::where('order_id',$order_id)->get() as $cart_list){
                      
                      $cart_data=Cart::findOrFail($cart_list['id']);
                      $cart_data->payment_status=0;
                      $cart_data->order_id=null;
                      $cart_data->save();
                      
                  }
                   flash(translate('Payment Failure'))->error();
              return redirect()->route('checkout.payment_info');
                
	}else{
	    
	     foreach(Cart::where('order_id',$order_id)->get() as $cart_list){
                      
                      $cart_data=Cart::findOrFail($cart_list['id']);
                      $cart_data->payment_status=0;
                      $cart_data->order_id=null;
                      $cart_data->save();
                      
                  }
                   flash(translate('Payment Not Completed'))->error();
              return redirect()->route('checkout.payment_info');
	}
          
    }

    public function cancel(Request $request){
        // flash(translate('Payment is cancelled'))->error();
        // return redirect()->route('home');
        
        $workingKey='842F72308DFE6FC100F92AE8AE75A455';//Shared by CCAVENUES//Shared by CCAVENUES	//Working Key should be provided here.
	$encResponse=$_POST["encResp"];			//This is the response sent by the CCAvenue Server
	$rcvdString=$this->decrypts($encResponse,$workingKey);		//Crypto Decryption used as per the specified working key.
	$order_status="";
	$decryptValues=explode('&', $rcvdString);
	$dataSize=sizeof($decryptValues);
	echo "<center>";
	for($i = 0; $i < $dataSize; $i++)
	{
		$information=explode('=',$decryptValues[$i]);
		if($i==0)   $order_id=$information[1];
		if($i==3)	$order_status=$information[1];
	}	
		if($order_status==="Aborted")
	{
	      foreach(Cart::where('order_id',$order_id)->get() as $cart_list){
                      
                      $cart_data=Cart::findOrFail($cart_list['id']);
                      $cart_data->payment_status=0;
                      $cart_data->order_id=null;
                      $cart_data->save();
                      
                  }
                  flash(translate('Payment Aborted'))->error();
              return redirect()->route('checkout.payment_info');   
                
	}
	else{
	    
	      foreach(Cart::where('order_id',$order_id)->get() as $cart_list){
                      
                      $cart_data=Cart::findOrFail($cart_list['id']);
                      $cart_data->payment_status=0;
                      $cart_data->order_id=null;
                      $cart_data->save();
                      
                  }
                  flash(translate('Payment Cancel'))->error();
              return redirect()->route('checkout.payment_info'); 
	    
	}
		
	
	
    }
    
    public function payment_status(Request $request){
        if($request->order_code){
             return view('frontend.payment.ccavenue_payment_status',['data'=>$request->order_code]);
        }else{
         return view('frontend.payment.ccavenue_payment_status');
         
       }
    }
    	function encrypts($plainText,$key)
	{
		$key = $this->hextobins(md5($key));
		$initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
		$openMode = openssl_encrypt($plainText, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $initVector);
		$encryptedText = bin2hex($openMode);
		return $encryptedText;
	}

	function decrypts($encryptedText,$key)
	{
		$key = $this->hextobins(md5($key));
		$initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
		$encryptedText = $this->hextobins($encryptedText);
		$decryptedText = openssl_decrypt($encryptedText, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $initVector);
		return $decryptedText;
	}
	//*********** Padding Function *********************

	 function pkcs5_pads ($plainText, $blockSize)
	{
	    $pad = $blockSize - (strlen($plainText) % $blockSize);
	    return $plainText . str_repeat(chr($pad), $pad);
	}

	//********** Hexadecimal to Binary function for php 4.0 version ********

	function hextobins($hexString) 
   	 { 
        	$length = strlen($hexString); 
        	$binString="";   
        	$count=0; 
        	while($count<$length) 
        	{       
        	    $subString =substr($hexString,$count,2);           
        	    $packedString = pack("H*",$subString); 
        	    if ($count==0)
		    {
				$binString=$packedString;
		    } 
        	    
		    else 
		    {
				$binString.=$packedString;
		    } 
        	    
		    $count+=2; 
        	} 
  	        return $binString; 
    	  } 
    
    public function payment_process(Request $request){
        
        
                 $request->payment_option='ccavenue';
       
                 $payment = ["status" => "Success"];
                 $orderController = new OrderController;
                 $orderController->store($request);
                
                
                $checkoutController = new CheckoutController;
                return $checkoutController->checkout_done(session()->get('order_id'), json_encode($payment));
        
    }
}
