<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pincode extends Model
{
    protected $fillable = ['pincode','city_id','state_id', 'countries_name', 'status'];
}
