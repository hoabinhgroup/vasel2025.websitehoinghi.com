<?php

Route::group(["prefix" => "block", "as" => "block."], function () {
  Route::resource("", "BlockController")->parameters(["" => "block"]);

  Route::get("restore/{id}", "BlockController@restore")->name("restore");

  Route::post("delete/{id}", "BlockController@destroy")->name("delete");
});
