<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\PurchaseHistoryCollection;
use App\Http\Resources\PurchaseHistoryDetailsSingleCollection;
use App\Models\Order;

class PurchaseHistoryController extends Controller
{
    public function index($id)
    {
        return new PurchaseHistoryCollection(Order::where('user_id', $id)->latest()->paginate(10));
    }
    public function user_order_product_detail(Request $request)
    {
        return new PurchaseHistoryDetailsSingleCollection(OrderDetail::where('order_id', $request->order_id)->where('product_id', $request->product_id)->get(),$request->order_id,$request->product_id);
    }
}
