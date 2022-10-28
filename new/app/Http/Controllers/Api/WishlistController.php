<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\WishlistCollection;
use App\Models\Wishlist;
use App\Models\Cart;
use Illuminate\Http\Request;

class WishlistController extends Controller
{

    public function index($id)
    {
        return new WishlistCollection(Wishlist::where('user_id', $id)->latest()->get());
    }

    public function store(Request $request)
    {
        Wishlist::updateOrCreate(
            ['user_id' => $request->user_id, 'product_id' => $request->product_id]
        );
        return response()->json(['message' => 'Product is successfully added to your wishlist'], 201);
    }

    public function destroy(Request $request)
    {
        Wishlist::where('user_id',$request->user_id)->where('product_id',$request->product_id)->delete();
        return response()->json(['message' => 'Product is successfully removed from your wishlist'], 200);
    }

    public function isProductInWishlist(Request $request)
    {
        $product = Wishlist::where(['product_id' => $request->product_id, 'user_id' => $request->user_id])->count();
        if ($product > 0)
            return response()->json([
                'message' => 'Product present in wishlist',
                'is_in_wishlist' => true,
                'product_id' => (integer) $request->product_id,
                'wishlist_id' => (integer) Wishlist::where(['product_id' => $request->product_id, 'user_id' => $request->user_id])->first()->id
            ], 200);

        return response()->json([
            'message' => 'Product is not present in wishlist',
            'is_in_wishlist' => false,
            'product_id' => (integer) $request->product_id,
            'wishlist_id' => 0
        ], 200);
    }
    
    public function detailCheck($user_id,$product_id,$varient_name)
    {
        $wishlist=Wishlist::where('user_id',$user_id)->where('product_id',$product_id)->get();
        
        $cart=Cart::where('user_id',$user_id)->where('variation',$varient_name)->where('product_id',$product_id)->get();
        
        return response()->json(['wishlist'=>count($wishlist),'cart'=>count($cart)], 200);
    }
}
