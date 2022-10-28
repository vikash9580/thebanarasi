<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SellerDetails extends Model
{
    protected $fillable = [
        'user_id', 'phone1', 'phone2', 'whatsapp_number', 'gender', 'dob', 'profession', 'contact_position', 'website', 'city', 'state','country','pincode','delivery_address','facebook', 'instagram', 'twitter', 'anniversary', 'business_name', 'tax_id_type', 'tax_id'
    ];

    public function user()
    {
    return $this->belongsTo(User::class);
    }
}
