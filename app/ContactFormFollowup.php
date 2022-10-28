<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactFormFollowup extends Model
{
    protected $fillable = 
    [
        'contact_enquiry_id',
        'added_by',
        'last_date_of_contact',
        'last_time_of_contact',
        'next_date_of_contact',
        'next_time_of_contact',
        'lead_status',
        'lead_source',
        'remark',
        'date'
    ];
     public function contact_form(){
    return $this->belongsTo(ContactForm::class,'contact_enquiry_id','id');
    }
}
