<?php

namespace Modules\Registration\Entities;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;

class Subscribe extends Model
{
    //use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'subscribe';

    /**
     * @var array
     */
    protected $fillable = [
        'email_subscribe',
        'status'
    ];
  

}
