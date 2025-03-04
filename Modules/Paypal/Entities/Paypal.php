<?php

namespace Modules\Paypal\Entities;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;

class Paypal extends Model
{
    //use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'paypals';

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'status',
    ];

}
