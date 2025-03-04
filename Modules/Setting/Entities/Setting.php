<?php

namespace Modules\Setting\Entities;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    
    protected $table = 'setting';

    /**
     * @var array
     */
    protected $fillable = [
	    'key',
        'value'
    ];

    /**
     * @var bool
     */
    public $timestamps = false;
}
