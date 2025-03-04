<?php

namespace Modules\Acl\Entities;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    protected $fillable = [
	     'name', 'slug', 'permissions',
    ];
    
    protected $casts = [
        'permissions' => 'array',
    ];
    
     public function userGroup()
    {
        return $this->belongsToMany(
        \Modules\Acl\Entities\UserGroup::class, 'user_group_roles', 'role_id', 'group_id'
        );
      /*  return $this->belongsTo(
       		 User::class
        );
        */
    }

    public function hasAccess(array $permissions) : bool
    {
        foreach ($permissions as $permission) {
            if ($this->hasPermission($permission))
                return true;
        }
        return false;
    }

    private function hasPermission(string $permission) : bool
    {
        return $this->permissions[$permission] ?? false;
    }
}
