<?php

namespace Modules\Acl\Entities;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth as FacadesAuth;

class Users extends Authenticatable
{
  use Notifiable;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    "name",
    "code",
    "first_name",
    "last_name",
    "jobtitle",
    "email",
    "password",
    "address",
    "phone",
    "gender",
    "website",
    "skype",
    "facebook",
    "interest",
    "token",
    "profile_image",
    "is_admin",
    "id_group",
    "id_office",
    "status",
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = ["password", "remember_token"];

  /**
   * The attributes that should be cast to native types.
   *
   * @var array
   */
  protected $casts = [
    "email_verified_at" => "datetime",
  ];

  public function group()
  {
    return $this->belongsTo(UserGroup::class, 'id_group', 'id');
  }

  /**
   * Checks if User has access to $permissions.
   */
  public function hasAccess(array $permissions): bool
  {

    if (FacadesAuth::user()->is_admin == 1) {
      return true;
    }

    // dd(request()->user()->group->hasAccess($permissions));
    if ($this->checkRole($permissions)) {
      return true;
    }


    return false;
  }

  public function checkRole($permissions)
  {
    return  request()->user()->group->hasAccess($permissions);
  }

  /**
   * Checks if the user belongs to role.
   */
  public function inRole(string $roleSlug)
  {
    return $this->roles()
      ->where("slug", $roleSlug)
      ->count() == 1;
  }
}
