<?php

namespace Modules\Base\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MetaBox extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'meta_boxes';

    /**
     * @var array
     */
   /* protected $casts = [
        'meta_value' => 'json',
    ];
    */
    
    protected $fillable = [
	    'reference_id',
	    'meta_key',
	    'meta_value',
	    'reference_type'
    ];

    /**
     * @return BelongsTo
     */
    public function reference(): BelongsTo
    {
        return $this->morphTo();
    }
}
