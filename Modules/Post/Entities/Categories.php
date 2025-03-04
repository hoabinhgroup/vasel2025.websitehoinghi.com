<?php

namespace Modules\Post\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
//use Modules\Slug\Traits\SlugTrait;
use Modules\Slug\Entities\Slug;

class Categories extends Model
{
  //use SlugTrait;
  use SoftDeletes;
  /**
   * @var string
   */
  protected $table = "categories";
  /**
   * @var array
   */
  protected $fillable = [
    "name",
    "parent",
    "description",
    "status",
    "user_id",
    "image",
  ];

  public function owner()
  {
    return $this->belongsTo(Users::class);
  }

  public function slug()
  {
    return $this->morphOne(Slug::class, "reference");
  }

  public function posts()
  {
    return $this->belongsToMany(Post::class, 'post_categories','category_id', 'post_id');
  }

  protected static function boot()
  {
    parent::boot();

    static::deleting(function (Categories $categories) {
      if ($categories->isForceDeleting()) {
        $categories->languageMeta()->forceDelete();
        $categories->slug()->forceDelete();
      }
    });
  }
}
