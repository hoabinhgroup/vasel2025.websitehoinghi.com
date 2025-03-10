<?php

namespace Modules\Media\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use LouisMedia;

class MediaFile extends Model
{
    use SoftDeletes;


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'media_files';

    /**
     * The date fields for the model.clear
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'mime_type',
        'type',
        'size',
        'url',
        'options',
        'folder_id',
        'user_id',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'options' => 'json',
    ];

    protected static function boot()
    {
        parent::boot();
        static::deleting(function (MediaFile $file) {
            if ($file->isForceDeleting()) {
                LouisMedia::deleteFile($file);
            }
        });
    }

    /**
     * @return BelongsTo
     */
    public function folder(): BelongsTo
    {
        return $this->belongsTo(MediaFolder::class, 'id', 'folder_id');
    }

    /**
     * @return string
     */
    public function getTypeAttribute(): string
    {
        $type = 'document';

        foreach (config('media.mime_types', []) as $key => $value) {
            if (in_array($this->attributes['mime_type'], $value)) {
                $type = $key;
                break;
            }
        }

        return $type;
    }

    /**
     * @return string
     */
    public function getHumanSizeAttribute(): string
    {
        return human_file_size($this->attributes['size']);
    }

    /**
     * @return string
     */
    public function getIconAttribute(): string
    {
        switch ($this->type) {
            case 'image':
                $icon = 'far fa-file-image';
                break;
            case 'video':
                $icon = 'far fa-file-video';
                break;
            case 'pdf':
                $icon = 'far fa-file-pdf';
                break;
            case 'excel':
                $icon = 'far fa-file-excel';
                break;
            default:
                $icon = 'far fa-file-alt';
                break;
        }

        return $icon;
    }

    /**
     * @return bool
     */
    public function canGenerateThumbnails(): bool
    {
        return is_image($this->mime_type) &&
            !in_array($this->mime_type, ['image/svg+xml', 'image/x-icon', 'image/gif']) &&
            Storage::exists($this->url);
    }

}
