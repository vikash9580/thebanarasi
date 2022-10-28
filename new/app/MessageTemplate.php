<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MessageTemplate extends Model
{
     protected $fillable = ['flow_id', 'title','variable', 'body'];

}
