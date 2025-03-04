<?php

Route::prefix("slug")->group(function () {
    Route::get("/", "SlugController@index");

    Route::post("create", "SlugController@store")->name("slug.create");
});
