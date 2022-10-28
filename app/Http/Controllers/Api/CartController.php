<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\CartCollection;
use App\Models\Cart;
use App\Models\Color;
use App\Models\FlashDeal;
use App\Models\FlashDealProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index($id)
    {
        return new CartCollection(Cart::where('user_id', $id)->latest()->get());
    }

    public function add(Request $request)
    {
        $product = Product::findOrFail($request->product_id);

        $variant = $request->variant;
        $color = $request->color;
        $tax = 0;

        if ($variant == '' && $color == '')
            $price = $product->unit_price;
        else {
            //$variations = json_decode($product->variations);
            $product_stock = $product->stocks->where('variant', $variant)->first();
            $price = $product_stock->price;
            $quantity=$product_stock->qty;
            $varinat_min_qty=$product_stock->variant_min;
             if($quantity <= $varinat_min_qty){
                 return response()->json([
                     'message' => 'Product Out Of Stock'
               ],400);
             }
            
        }

        //discount calculation based on flash deal and regular discount
        //calculation of taxes
        $flash_deals = FlashDeal::where('status', 1)->get();
        $inFlashDeal = false;
        foreach ($flash_deals as $flash_deal) {
            if ($flash_deal != null && $flash_deal->status == 1  && strtotime(date('d-m-Y')) >= $flash_deal->start_date && strtotime(date('d-m-Y')) <= $flash_deal->end_date && FlashDealProduct::where('flash_deal_id', $flash_deal->id)->where('product_id', $product->id)->first() != null) {
                $flash_deal_product = FlashDealProduct::where('flash_deal_id', $flash_deal->id)->where('product_id', $product->id)->first();
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
        if (!$inFlashDeal) {
            if($product_stock->discounts_type == 'percent'){
                $price -= ($price*$product_stock->discounts)/100;
            }
            elseif($product_stock->discounts_type == 'amount'){
                $price -= $product_stock->discounts;
            }
        }

        if ($product->tax_type == 'percent') {
            $tax = ($price * $product->tax) / 100;
        }
        elseif ($product->tax_type == 'amount') {
            $tax = $product->tax;
        }

        Cart::updateOrCreate([
            'user_id' => $request->user_id,
            'product_id' => $request->product_id,
             'variant_id' => $product_stock->id,
            'variation' => $variant
        ], [
            'price' => $price,
            'mrp_price' => $product_stock->price,
            'tax' => $tax,
            'shipping_cost' => 0,
            'quantity' =>$varinat_min_qty 
        ]);

        return response()->json([
            'message' => 'Product added to cart successfully'
        ]);
    }

    public function changeQuantity(Request $request)
    {
        $cart = Cart::findOrFail($request->id);
        $cart->update([
            'quantity' => $request->quantity
        ]);
        return response()->json(['message' => 'Cart updated'], 200);
    }

    public function cartDelete($id)
    {
     
       $cart= Cart::find($id);
       $cart->delete();
        return response()->json(['message' => 'Product is successfully removed from your cart'], 200);
    }
}
