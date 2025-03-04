<?php

Route::group(["prefix" => "sales"], function () {
  Route::get("/list", "SalesController@list");
});
