<?php

namespace Modules\Post\Entities;

use Illuminate\Database\Eloquent\Model;

class PostCategories extends Model
{
	protected $table = "post_categories";
    protected $fillable = [
    	'category_id',
	    'post_id'
	    ];
}
