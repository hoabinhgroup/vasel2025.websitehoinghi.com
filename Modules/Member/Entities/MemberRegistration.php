<?php

namespace Modules\Member\Entities;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;

class MemberRegistration extends Model
{
    //use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'member_registrations';

    /**
     * @var array
     */
    protected $fillable = [
        'member_id',
        'reference_id',
        'reference_type',
        'status'
    ];
    
    
    public function reference()
    {
        return $this->morphTo();
    }
    
    public function member()
       {
           return $this->belongsTo(Member::class, 'member_id');
       }

}
