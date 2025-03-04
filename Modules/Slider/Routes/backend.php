<?php

Route::group(["prefix" => "slider", "as" => "slider."], function () {
  Route::resource("", "SliderController")->parameters(["" => "slider"]);

  Route::get("restore/{id}", "SliderController@restore")->name("restore");

  Route::post("delete/{id}", "SliderController@destroy")->name("delete");
});

Route::group(["prefix" => "slider-item", "as" => "slider-item."], function () {
  Route::resource("", "SliderItemController")->parameters([
    "" => "slider-item",
  ]);

  Route::get("/{id}", "SliderItemController@index")->name("list");

  Route::get("restore/{id}", "SliderItemController@restore")->name("restore");

  Route::post("delete/{id}", "SliderItemController@destroy")->name("delete");
});
