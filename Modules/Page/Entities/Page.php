<?php

namespace Modules\Page\Entities;

use Modules\Acl\Entities\Users;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Page extends Model
{
    use SoftDeletes;
    use Notifiable;

    protected $table = "pages";

    protected $fillable = [
        "name",
        "slug",
        "content",
        "image",
        "template",
        "icon",
        "description",
        "featured",
        "order",
        "status",
        "user_id",
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function (Page $page) {
            if ($page->isForceDeleting()) {
                // $page->languageMeta()->forceDelete();
                //$page->slug()->forceDelete();
            }
        });
    }

    public function comments()
    {
        return $this->morphMany(\Modules\Comment\Entities\Comment::class,'reference');
    }

    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(Users::class)->withDefault();
    }
}
