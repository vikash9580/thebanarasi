<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Citie extends Model
{
     protected $fillable = ['city_name','state_id', 'countries_name', 'status'];
}
