<?php

Route::group(["prefix" => "theme", "as" => "theme."], function () {
  Route::resource("", "ThemeController")->parameters(["" => "theme"]);

  Route::get("active/{theme}", "ThemeController@getActiveTheme")->name(
    "active"
  );

  Route::get("options", "ThemeController@getOptions")->name("options");

  Route::post("options", "ThemeController@postUpdate")->name("options.update");
});
