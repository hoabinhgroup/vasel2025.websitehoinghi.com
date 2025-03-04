<?php
if (!function_exists("getRoleBySlug")) {
  function getRoleBySlug($slug, $id_group)
  {
    if ($id_group != 1) {
      $role = DB::table("roles as r")
        ->join("user_group_roles as ur", "ur.role_id", "=", "r.id")
        ->join("users as u", "u.id_group", "=", "ur.group_id")
        ->where("r.slug", $slug)
        ->where("u.id_group", $id_group)
        ->first();

      if ($role) {
        return true;
      } else {
        return false;
      }
    }
    return true;
  }
}

if (!function_exists("getPermissionsBySlug")) {
  function getPermissionsBySlug($slug, $id_group)
  {
    if ($id_group != 1) {
      $role = DB::table("roles as r")
        ->select("permissions")
        ->join("user_group_roles as ur", "ur.role_id", "=", "r.id")
        ->join("user_group as g", "g.id", "=", "ur.group_id")
        ->where("r.slug", $slug)
        ->where("g.id", $id_group)
        ->get()
        ->toArray();

      if ($role) {

        $role = $role[0];
        return get_array_value((array) json_decode($role->permissions), $slug);
      } else {
        return false;
      }
    }

    return true;
  }

  if (!function_exists("setValueStored")) {
    function setValueStored($key, $value, $lifetime = 0)
    {
      if (!$lifetime) {
        \Cookie::queue($key, $value);
      } else {
        \Cookie::queue($key, $value, $lifetime);
      }
      return true;
    }
  }

  if (!function_exists("getValueStored")) {
    function getValueStored($key)
    {
      return \Cookie::get($key);
    }
  }

  if (!function_exists("deleteValueStored")) {
    function deleteValueStored($key)
    {
      if (request()->hasCookie($key)) {
        \Cookie::queue(\Cookie::forget($key));
      }
      return true;
    }
  }
}
