<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\SubSubCategory;
use App\Category;
use Session;
use App\Color;
use Cookie;
use Auth;
use App\Models\Cart;
use App\Coupon;
use App\CouponUsage;

class CartController extends Controller
{
    public function index(Request $request)
    {
        //dd($cart->all());
        if(Auth::check())
        {
            $categories = Category::all();


         if (Cart::where('user_id',Auth::user()->id)->get()->count() > 0) {
            $categories = Category::all();

             if (Auth::check()) {


            if(Auth::user()->phone == null){
                flash(translate("Please Verify Phone"))->warning();
                return back();

            }



             $subtotal = 0;
             $tax = 0;
             $shipping = 0;
         foreach (Cart::where('user_id',Auth::user()->id)->get() as $key => $cartItem) {
            $subtotal += $cartItem['price'] * $cartItem['quantity'];
            $tax += $cartItem['tax'] * $cartItem['quantity'];
            $shipping += $cartItem['shipping'] * $cartItem['quantity'];
            }

        $total = $subtotal + $tax + $shipping;

        if (Session::has('coupon_discount')) {
            $total -= Session::get('coupon_discount');
        }


            return view('frontend.view_cart', compact('categories','total'));
        }
         }
        else{
        flash(translate('Your cart is empty'))->success();
        return back();

        }
        }
        else
        {
            flash(translate('Your are not login'))->success();
        return back();
        }
    }

    public function showCartModal(Request $request)
    {
        $product = Product::find($request->id);
        return view('frontend.partials.addToCart', compact('product'));
    }

    public function updateNavCart(Request $request)
    {
        return view('frontend.partials.cart');
    }

    public function addToCart(Request $request)
    {
        $product = Product::find($request->id);

        $data = array();
        $data['id'] = $product->id;
        $data['owner_id'] = $product->user_id;
        $str = '';
        $tax = 0;
        $varinat_id=0;



        //check the color enabled or disabled for the product
        if($request->has('color')){
            $data['color'] = $request['color'];
            $str = Color::where('code', $request['color'])->first()->name;
        }

        if ($product->digital != 1) {
            //Gets all the choice values of customer choice option and generate a string like Black-S-Cotton
            foreach (json_decode(Product::find($request->id)->choice_options) as $key => $choice) {
                if($str != null){
                    $str .= '-'.str_replace(' ', '', $request['attribute_id_'.$choice->attribute_id]);
                }
                else{
                    $str .= str_replace(' ', '', $request['attribute_id_'.$choice->attribute_id]);
                }
            }
        }

        $data['variant'] = $str;

        if($str != null && $product->variant_product){
            $product_stock = $product->stocks->where('variant', $str)->first();
            $varinat_id=$product_stock->id;
            if(Auth::check()){
                   if(Auth::user()->is_wholesale_customer==1 && Auth::user()->validate_wholesale_customer==1){
                        $price = $product_stock->wholesale_price;
                        $quantity = $product_stock->qty;
                   }else{
                        $price = $product_stock->price;
                        $quantity = $product_stock->qty;
                   }


            }else{

            $price = $product_stock->price;
            $quantity = $product_stock->qty;

            }

            if($quantity >= $request['quantity']){
                // $variations->$str->qty -= $request['quantity'];
                // $product->variations = json_encode($variations);
                // $product->save();
            }
            else{
                return view('frontend.partials.outOfStockCart');
            }
        }
        else{
            if(Auth::check()){
                if(Auth::user()->is_wholesale_customer==1 && Auth::user()->validate_wholesale_customer==1){
                    $price = $product->wholesale_unit_price;
                }else{
                    $price = $product->unit_price;
                }

            }else{

            $price = $product->unit_price;
            }
        }


        if(Auth::check()){
            if(Auth::user()->is_wholesale_customer==1 && Auth::user()->validate_wholesale_customer==1){
                 if($product->digital != 1 && $request->quantity < $product_stock->wholesale_min_qty) {
              return view('frontend.partials.minQtyNotSatisfied', [
                  'min_qty' => $product_stock->wholesale_min
              ]);
            }
          if($product->digital != 1 && $request->quantity > $product_stock->wholesale_max_qty) {
              return view('frontend.partials.maxQtyNotSatisfied', [
                  'max_qty' => $product_stock->wholesale_max
              ]);
           }
            }else{
                  if($product->digital != 1 && $request->quantity < $product_stock->variant_min) {
                     return view('frontend.partials.minQtyNotSatisfied', [
                       'min_qty' => $product_stock->variant_min
                      ]);
              }
          if($product->digital != 1 && $request->quantity > $product_stock->variant_max) {
                 return view('frontend.partials.maxQtyNotSatisfied', [
                       'max_qty' => $product_stock->variant_max
                  ]);
             }
            }
          }else{
          if($product->digital != 1 && $request->quantity < $product_stock->variant_min) {
              return view('frontend.partials.minQtyNotSatisfied', [
                  'min_qty' => $product_stock->variant_min
              ]);
          }
          if($product->digital != 1 && $request->quantity > $product_stock->variant_max) {
              return view('frontend.partials.maxQtyNotSatisfied', [
                  'max_qty' => $product_stock->variant_max
              ]);
          }
        }




        //discount calculation based on flash deal and regular discount
        //calculation of taxes
        $flash_deals = \App\FlashDeal::where('status', 1)->get();
        $inFlashDeal = false;
        foreach ($flash_deals as $flash_deal) {
            if ($flash_deal != null && $flash_deal->status == 1  && strtotime(date('d-m-Y')) >= $flash_deal->start_date && strtotime(date('d-m-Y')) <= $flash_deal->end_date && \App\FlashDealProduct::where('flash_deal_id', $flash_deal->id)->where('product_id', $product->id)->first() != null) {
                $flash_deal_product = \App\FlashDealProduct::where('flash_deal_id', $flash_deal->id)->where('product_id', $product->id)->first();

                   if(Auth::check()){

                       if(Auth::user()->is_wholesale_customer==1 && Auth::user()->validate_wholesale_customer==1){
                            if($flash_deal_product->wholesale_discount_type == 'percent'){
                                     $price -= ($price*$flash_deal_product->wholesale_discount)/100;
                                 }
                            elseif($flash_deal_product->wholesale_discount_type == 'amount'){
                                       $price -= $flash_deal_product->wholesale_discount;
                               }
                         $inFlashDeal = true;
                         break;

                      }
                      else{
                            if($flash_deal_product->discount_type == 'percent'){
                                 $price -= ($price*$flash_deal_product->discount)/100;
                                  }
                           elseif($flash_deal_product->discount_type == 'amount'){
                                  $price -= $flash_deal_product->discount;
                                }
                               $inFlashDeal = true;
                              break;
                       }

                   }
                   else{

                if($flash_deal_product->discount_type == 'percent'){
                    $price -= ($price*$flash_deal_product->discount)/100;
                }
                elseif($flash_deal_product->discount_type == 'amount'){
                    $price -= $flash_deal_product->discount;
                }
                $inFlashDeal = true;
                break;
              }
            }
        }
        if (!$inFlashDeal) {

             if(Auth::check()){

                  if(Auth::user()->is_wholesale_customer==1 && Auth::user()->validate_wholesale_customer==1){
                       if($product->wholesale_discount_type == 'percent'){
                        $price -= ($price*$product->wholesale_discount)/100;
                    }
                elseif($product->wholesale_discount_type == 'amount'){
                $price -= $product->wholesale_discount;
            }
                  }else{
                       if($product->discount_type == 'percent'){
                $price -= ($price*$product->discount)/100;
            }
            elseif($product->discount_type == 'amount'){
                $price -= $product->discount;
            }
                  }

             }else{

            if($product->discount_type == 'percent'){
                $price -= ($price*$product->discount)/100;
            }
            elseif($product->discount_type == 'amount'){
                $price -= $product->discount;
            }

         }
        }

      if(Auth::check()){
           if(Auth::user()->is_wholesale_customer==1 && Auth::user()->validate_wholesale_customer==1){
               if($product->wholesale_tax_type == 'percent'){
               $tax = ($price*$product->wholesale_tax)/100;
             }
             elseif($product->wholesale_tax_type == 'amount'){
             $tax = $product->wholesale_tax;
            }
           }
           else{
               if($product->tax_type == 'percent'){
            $tax = ($price*$product->tax)/100;
        }
        elseif($product->tax_type == 'amount'){
            $tax = $product->tax;
        }

           }
      }
      else{


        if($product->tax_type == 'percent'){
            $tax = ($price*$product->tax)/100;
        }
        elseif($product->tax_type == 'amount'){
            $tax = $product->tax;
        }
   }
        $data['variant_id'] = $varinat_id;
        $data['quantity'] = $request['quantity'];
        $data['price'] = $price;
        $data['tax'] = $tax;
        $data['shipping'] = 0;
        $data['product_referral_code'] = null;
        $data['digital'] = $product->digital;

        if ($request['quantity'] == null){
            $data['quantity'] = 1;
        }
         if ($request['quantity_max'] == null){
              if(Auth::check()){

                   if(Auth::user()->is_wholesale_customer==1 && Auth::user()->validate_wholesale_customer==1){

                       $data['quantity_max'] = $product->wholesale_max_qty;

                   }
                   else{
                       $data['quantity_max'] = $product->max_qty;

                   }


              }else{

            $data['quantity_max'] = $product->max_qty;
              }

        }

        if(Cookie::has('referred_product_id') && Cookie::get('referred_product_id') == $product->id) {
            $data['product_referral_code'] = Cookie::get('product_referral_code');
        }
         $cart_data=Cart::where('user_id',Auth::user()->id)->where('product_id',$request->id)->where('payment_status',0)->first();
        if(!empty($cart_data)){


                 $cart_data->quantity=$request['quantity'];
                 $cart_data->save();

        }
        else{

            $cart = collect([$data]);
            $cart_data=new Cart;
            $cart_data->user_id=Auth::user()->id;
            $cart_data->product_id=$cart[0]['id'];
            $cart_data->variant_id=$cart[0]['variant_id'];
            $cart_data->variation=$cart[0]['variant'];
            $cart_data->price=$cart[0]['price'];
            $cart_data->tax=$cart[0]['tax'];
            $cart_data->shipping_cost=$cart[0]['shipping'];
            $cart_data->quantity=$cart[0]['quantity'];
            $cart_data->save();

           // $request->session()->put('cart', $cart);
        }

        return view('frontend.partials.addedToCart', compact('product', 'data'));
    }

    //removes from Cart
    public function removeFromCart(Request $request)
    {
        if(Cart::where('id',$request->key)->get()){

          Cart::where('id',$request->key)->delete();

        }

        return view('frontend.partials.cart_details');
    }

    //updated the quantity for a cart item
    public function updateQuantity(Request $request)
    {
         $cart = Cart::where('id',$request->key)->first();
                $product = \App\Product::find($cart->product_id);
                if($product->variant != null && $product->variant_product){
                    $product_stock = $product->stocks->where('variant', $cart->variant)->first();
                    $quantity = $product_stock->qty;
                    if($quantity >= $request->quantity){
                        if($request->quantity >= $product->min_qty){
                            $cart->quantity = $request->quantity;
                        }

                    }
                }
                elseif ($product->current_stock >= $request->quantity) {
                    if($request->quantity >= $product->min_qty){
                        $cart->quantity = $request->quantity;
                    }

                }

          $cart->save();


        return view('frontend.partials.cart_details');
    }

    public function updateCartSummary(Request $request)
    {
                if(Session::has('coupon_discount')){
                                 $coupon = Coupon::where('id', Session::get('coupon_id'))->first();
                        if ($coupon != null) {
                            if (strtotime(date('d-m-Y')) >= $coupon->start_date && strtotime(date('d-m-Y')) <= $coupon->end_date) {
                                if (CouponUsage::where('user_id', Auth::user()->id)->where('coupon_id', $coupon->id)->count()  <= $coupon->no_of_usage) {
                                    $coupon_details = json_decode($coupon->details);

                                    if ($coupon->type == 'cart_base') {
                                        $subtotal = 0;
                                        $tax = 0;
                                        $shipping = 0;
                                        foreach (Cart::where('user_id',Auth::user()->id)->get() as $key => $cartItem) {
                                            $subtotal += $cartItem['price'] * $cartItem['quantity'];
                                            $tax += $cartItem['tax'] * $cartItem['quantity'];
                                            $shipping += $cartItem['shipping'] * $cartItem['quantity'];
                                        }
                                        $sum = $subtotal + $tax + $shipping;

                                        if ($sum >= $coupon_details->min_buy) {
                                            if ($coupon->discount_type == 'percent') {
                                                $coupon_discount = ($sum * $coupon->discount) / 100;
                                                if ($coupon_discount > $coupon_details->max_discount) {
                                                    $coupon_discount = $coupon_details->max_discount;
                                                }
                                            } elseif ($coupon->discount_type == 'amount') {
                                                $coupon_discount = $coupon->discount;
                                            }
                                            $request->session()->put('coupon_id', $coupon->id);
                                            $request->session()->put('coupon_discount', $coupon_discount);

                                        }
                                    } elseif ($coupon->type == 'product_base') {
                                        $coupon_discount = 0;
                                        foreach (Cart::where('user_id',Auth::user()->id)->get() as $key => $cartItem) {
                                            foreach ($coupon_details as $key => $coupon_detail) {
                                                if ($coupon_detail->product_id == $cartItem['product_id']) {
                                                    if ($coupon->discount_type == 'percent') {
                                                        $coupon_discount += $cartItem['price'] * $coupon->discount / 100;
                                                    } elseif ($coupon->discount_type == 'amount') {
                                                        $coupon_discount += $coupon->discount;
                                                    }
                                                }
                                            }
                                        }
                                        $request->session()->put('coupon_id', $coupon->id);
                                        $request->session()->put('coupon_discount', $coupon_discount);

                                    }
                                } else {

                                }
                            } else {

                            }
                        }

                      }
        return view('frontend.partials.cart_summary');
    }

}
