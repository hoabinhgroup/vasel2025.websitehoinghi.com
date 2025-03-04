<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class PhotoboothCheckIn extends Model
{

    protected $table = "photoboothCheckIn";

    protected $fillable = [
        "customer_code",
        "photobooth_id"
    ];

    
}
