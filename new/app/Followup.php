<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Followup extends Model
{
    protected $fillable = 
    [
        'user_id', 
        'reseller_id', 
        'quotation_number', 
        'follow_up_status',
        'remark',
        'last_date',
        'next_date',
        'next_time',
        'status_of_lead',
        'source_of_lead',
        'for_other',
        'other_phone',
        'other_name',
        'other_email',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function reseller()
    {
        return $this->belongsTo(User::class);
    }
}
