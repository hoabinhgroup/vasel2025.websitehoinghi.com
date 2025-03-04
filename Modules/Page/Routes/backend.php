<?php

Route::group(["prefix" => "page", "as" => "page."], function () {
  Route::resource("", "PageController")->parameters(["" => "page"]);

  Route::get("restore/{id}", "PageController@restore")->name("restore");

  Route::post("delete/{id}", "PageController@destroy")->name("delete");

  Route::delete("deletes", "PageController@deletes")->name("deletes");

  Route::get("test", "PageController@test");
});
