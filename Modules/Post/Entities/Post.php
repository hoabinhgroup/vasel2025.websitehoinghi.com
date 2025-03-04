<?php

namespace Modules\Post\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Slug\Entities\Slug;

class Post extends Model
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'posts';

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
       // 'slug',
        'content',
        'status',
        'author_id',
        'is_featured',
        'image',
        'format_type'
    ];


     public function owner()
    {
	        return $this->belongsTo(\Modules\Acl\Entities\Users::class, 'author_id');
    }


     public function categories()
    {

	     return $this->belongsToMany(Categories::class, 'post_categories','post_id', 'category_id');


    }
    
    public function slug()
      {
        return $this->morphOne(Slug::class, "reference");
      }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'post_tags');
    }


	public function comments()
    {
        return $this->morphMany(\Modules\Comment\Entities\Comment::class,'reference');
    }


    protected static function boot()
    {
        parent::boot();

        static::deleting(function (Post $post) {
	        if ($post->isForceDeleting()) {
		     	$post->categories()->detach();
			 	$post->tags()->detach();
            }
        });

    }

}
