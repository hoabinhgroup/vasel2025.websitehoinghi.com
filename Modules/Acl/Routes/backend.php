<?php
Route::group(["prefix" => "user", "as" => "user."], function () {
  Route::resource("", "UserController")->parameters(["" => "user"]);

  Route::match(["GET","POST"],"change-password/{id}", "UserController@changePassword")->name("changePassword");

  Route::post("delete/{id}", "UserController@destroy")->name("delete");

  Route::get("profile/{id}", "UserController@getUserProfile")->name(
    "profile.view"
  );


  Route::post("change-password-profile/{id}", "UserController@changePasswordProfile")->name("changePasswordProfile");

  Route::post("change-avatar-profile/{id}", "UserController@changeAvatarProfile")->name("profile.image");

  Route::delete("delete-avatar-profile/{id}", "UserController@deleteAvatarProfile")->name("avatar.delete");
  
  Route::get("own-edit/profile", "UserController@editUserProfile")->name(
    "edit.own.profile"
  );

  Route::post("own-update/profile", "UserController@updateUserProfile")->name(
    "update.own.profile"
  );
});

Route::group(["prefix" => "user-group", "as" => "user-group."], function () {
  //   Route::get("/", "UserGroupController@index")->name(
  //     "backend.user-group.index"
  //   );
  //
  //
  //
  Route::resource("", "UserGroupController")->parameters(["" => "user-group"]);

  Route::get("permission/{id}", "UserGroupController@permission")->name(
    "permission"
  );

  Route::post("role", "UserGroupController@setRole")->name("setRole");

  Route::post("delete/{id}", "UserGroupController@destroy")->name("delete");
});
