<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NotificationTemplet extends Model
{
     protected $fillable = [
        'notification_type', 'title', 'body', 'image'];

}
