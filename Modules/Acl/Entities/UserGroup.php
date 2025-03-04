<?php

namespace Modules\Acl\Entities;

use Illuminate\Database\Eloquent\Model;

class UserGroup extends Model
{
	protected $table = 'user_group';

    protected $fillable = ['name'];

    public function roles()
    {
        return $this->belongsToMany(\Modules\Acl\Entities\Roles::class, 'user_group_roles', 'group_id', 'role_id');
    }

    public function user()
      {
          //return $this->belongsTo(Parent::class,'foreign_key','owner_key');
         return $this->hasOne(\App\User::class, 'id_group', 'id');
      }

    /**
     * Checks if User has access to $permissions.
     */
    public function hasAccess(array $permissions) : bool
    {
        // check if the permission is available in any role
        foreach ($this->roles as $role) {
            if($role->hasAccess($permissions)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Checks if the user belongs to role.
     */
    public function inRole(string $roleSlug)
    {
        return $this->roles()->where('slug', $roleSlug)->count() == 1;
    }

    public function delete()
    {
        $this->roles()->detach();
	    return parent::delete();
    }
}
