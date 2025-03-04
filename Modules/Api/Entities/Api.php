<?php

namespace Modules\Api\Entities;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;

class Api extends Model
{
    //use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'bill_infos_tables';

    /**
     * @var array
     */
    protected $fillable = [
        'brand_name',
        'brand_logo',
        'due',
        'due_info',
        'brand_id',
        'due_date'
    ];

}
