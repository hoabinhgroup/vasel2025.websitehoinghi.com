<?php

namespace Modules\Acl\Entities;

use Illuminate\Database\Eloquent\Model;

class UserGroupRoles extends Model
{
	protected $table = 'user_group_roles';
	
    protected $fillable = [
	    'group_id',
	    'role_id'
    ];
    
    
}
