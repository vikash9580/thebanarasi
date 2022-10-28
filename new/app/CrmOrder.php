<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CrmOrder extends Model
{
    public function orderDetails()
    {
        return $this->hasMany(CrmOrderDetail::class,'order_id');
    }

    public function refund_requests()
    {
        return $this->hasMany(RefundRequest::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pickup_point()
    {
        return $this->belongsTo(PickupPoint::class);
    }
}
