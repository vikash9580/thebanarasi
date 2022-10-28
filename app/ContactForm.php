<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactForm extends Model
{
    protected $fillable = 
    [
        'business_id', 
        'company_name', 
        'contact_name', 
        'email',
        'phone', 
        'phone2',
        'whatsapp_number',
        'country',
        'state',
        'city',
        'pincode',
        'address',
        'profession',
        'contact_position',
        'website',
        'other_important_link',
        'remark',
        'facebook_link',
        'instagram_link',
        'twitter_link',
        'youtube_link',
        'last_date',
        'next_date',
        'status_of_lead',
        'source_of_lead',
        'next_action_to_take',
        'quote_amount',
        'approved_payment_amount',
        'number_of_installment',
        'installment_date',
        'amount_paid',
        'payment_date',
        'delete_status',
        'status'
    ];
}
