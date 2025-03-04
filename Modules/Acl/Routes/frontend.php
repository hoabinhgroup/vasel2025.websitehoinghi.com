<?php

Route::get("/login", "UserController@getLogin")->name("backend.login");

Route::get("/" . BACKEND . "/login", "UserController@getLogin")->name(
    "access.login"
)->middleware(['guest.previous.url']);

Route::group(["prefix" => BACKEND], function () {
    Route::get("/", ["as" => "getLogin", "uses" => "UserController@getLogin"]);

    Route::get("auth/logout", "UserController@logout");

    Route::post("auth/login", "UserController@postLogin");

    Route::get("dashboard", "\Modules\Base\Http\Controllers\DashboardController@index")->middleware("auth");
});
