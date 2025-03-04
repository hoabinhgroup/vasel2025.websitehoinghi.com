<?php

namespace Modules\Post\Entities;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
     /**
     * @var string 
     */
    protected $table = 'tags';
    /**
     * @var array 
     */
    protected $fillable = [
    	'name',
    	'author_id',
    	'parent',
    	'description',
    	'status'];
    
    /**
     * @return BelongsToMany
     */
    public function posts()
    {
        return $this->belongsToMany(Post::class, 'post_tags');
    }

  
}
