<?php

namespace Modules\Analytics\Entities;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;

class Analytics extends Model
{
    //use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'analytics';

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'status',
    ];

}
