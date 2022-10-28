<?php

namespace App\Http\Controllers\Api;

use App\Models\Cart;
use App\Models\Coupon;
use App\Models\CouponUsage;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function apply(Request $request)
    {
        $coupon = Coupon::where('code', $request->code)->first();

        if ($coupon != null && strtotime(date('d-m-Y')) >= $coupon->start_date && strtotime(date('d-m-Y')) <= $coupon->end_date) {
            $couponDetails = json_decode($coupon->details);
            if ($coupon->type == 'cart_base') {
                $sum = Cart::where('user_id', $request->user_id)->sum('price');
                if ($sum > $couponDetails->min_buy) {
                    if ($coupon->discount_type == 'percent') {
                        $couponDiscount =  ($sum * $coupon->discount) / 100;
                        if ($couponDiscount > $couponDetails->max_discount) {
                            $couponDiscount = $couponDetails->max_discount;
                        }
                    } elseif ($coupon->discount_type == 'amount') {
                        $couponDiscount = $coupon->discount;
                    }
                    if ($this->isCouponAlreadyApplied($request->user_id, $coupon->id)) {
                        return response()->json([
                            'success' => false,
                            'message' => 'The coupon is already applied. Please try another coupon'
                        ]);
                    } else {
                        return response()->json([
                            'success' => true,
                            'discount' => (double) $couponDiscount,
                            'code' =>$request->code ,
                            'message' => 'Coupon code applied successfully'
                        ]);
                    }
                }
                if ($sum < $couponDetails->min_buy) {
                     return response()->json([
                            'success' => false,
                            'message' => 'Total Cart Amount is less than apply coupan required amount',
                            'status' =>'400'
                        ],400);
                 }
            } elseif ($coupon->type == 'product_base') {
                $couponDiscount = 0;
                $cartItems = Cart::where('user_id', $request->user_id)->get();
                foreach ($cartItems as $key => $cartItem) {
                    foreach ($couponDetails as $key => $couponDetail) {
                        if ($couponDetail->product_id == $cartItem->product_id) {
                            if ($coupon->discount_type == 'percent') {
                                $couponDiscount += $cartItem->price * $coupon->discount / 100;
                            } elseif ($coupon->discount_type == 'amount') {
                                $couponDiscount += $coupon->discount;
                            }
                        }
                    }
                }
                if ($this->isCouponAlreadyApplied($request->user_id, $coupon->id)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'The coupon is already applied. Please try another coupon'
                    ]);
                } else {
                    
                     if($couponDiscount>0){
                    
                    return response()->json([
                        'success' => true,
                        'discount' => (double) $couponDiscount,
                        'code' =>$request->code ,
                        'message' => 'Coupon code applied successfully'
                    ]);
                     }else{
                      return response()->json([
                          'success' => false,
                          'message' => 'The coupon is not valid for your cart items',
                          'status' =>'400'
                       ],400);
                     }
                }
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'The coupon is invalid',
                'status' =>'400'
            ],400);
        }
    }

    protected function isCouponAlreadyApplied($userId, $couponId) {
        return CouponUsage::where(['user_id' => $userId, 'coupon_id' => $couponId])->count() > 0;
    }
}
