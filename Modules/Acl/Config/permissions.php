<?php

return [
  [
    "name" => "Users",
    "flag" => "user.index",
  ],
  [
    "name" => "Create",
    "flag" => "user.create",
    "parent_flag" => "user.index",
  ],
  [
    "name" => "Edit",
    "flag" => "user.edit",
    "parent_flag" => "user.index",
  ],
  [
    "name" => "Change Password",
    "flag" => "user.changePassword",
    "parent_flag" => "user.index",
  ],
  [
    "name" => "Thay đổi mật khẩu cá nhân",
    "flag" => "user.changePasswordProfile",
    "parent_flag" => "user.index",
  ],
  [
    "name" => "Thay đổi thông tin cá nhân",
    "flag" => "user.edit.own.profile",
    "parent_flag" => "user.index",
  ],
  [
    "name" => "Thay đổi ảnh đại diện",
    "flag" => "user.profile.image",
    "parent_flag" => "user.index",
  ], 
  [
    "name" => "Xóa ảnh đại diện",
    "flag" => "user.avatar.delete",
    "parent_flag" => "user.index",
  ], 
  [
    "name" => "Cập nhật thông tin cá nhân",
    "flag" => "user.update.own.profile",
    "parent_flag" => "user.index",
  ],
  [
    "name" => "Delete",
    "flag" => "user.delete",
    "parent_flag" => "user.index",
  ],
  [
    "name" => "User Group",
    "flag" => "user-group.index",
  ],
  [
    "name" => "Create",
    "flag" => "user-group.create",
    "parent_flag" => "user-group.index",
  ],
  [
    "name" => "Edit",
    "flag" => "user-group.edit",
    "parent_flag" => "user-group.index",
  ],
  [
    "name" => "Delete",
    "flag" => "user-group.delete",
    "parent_flag" => "user-group.index",
  ],
  [
    "name" => "Permission",
    "flag" => "user-group.permission",
    "parent_flag" => "user-group.index",
  ],
  [
    "name" => "Phân quyền",
    "flag" => "user-group.setRole",
    "parent_flag" => "user-group.index",
  ],
];
