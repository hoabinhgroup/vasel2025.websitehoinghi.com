<?php

namespace Modules\Slug\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Slug extends Model
{
	use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'slugs';

    /**
     * @var array
     */
    protected $fillable = [
        'key',
        'reference_type',
        'reference_id',
    ];

     /**
     * @return BelongsTo
     */
    public function reference()
    {
        return $this->morphTo();
    }
}
