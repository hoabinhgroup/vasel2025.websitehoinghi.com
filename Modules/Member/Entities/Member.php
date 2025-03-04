<?php

namespace Modules\Member\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Registration\Entities\Invited;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Modules\Registration\Entities\Registration;
//use Illuminate\Database\Eloquent\SoftDeletes;

class Member extends Authenticatable
{
    //use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'members';

    protected $hidden = [
        'password', 'remember_token',
    ];
    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'fullname',
        'email',
        'password',
        'email_verified_at',
        'address',
        'phone',
        'website',
        'skype',
        'facebook',
        'remember_token',
        'status',
        'pw'
    ];
    
   public function reference()
   {
       return $this->morphOne(Invited::class, 'reference');
   }
   
  
}
