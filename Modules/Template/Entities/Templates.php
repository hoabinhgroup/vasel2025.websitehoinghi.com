<?php

namespace Modules\Template\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Templates extends Model
{
	use SoftDeletes;
	
    protected $fillable = [
	    'name',
	    'user_id',
	    'data',
	    'image',
	    'color',
	    'sort'
    ];
}
