<?php
Route::prefix("slideItem")->group(function () {
  Route::post("index", "SliderItemController@index")->name(
    "api.slide.item.modal"
  );
  Route::post("edit/{id}", "SliderItemController@edit")->name(
    "api.slide.edit.modal"
  );

  Route::post("sort", "SliderItemController@sort")->name("api.slide.item.sort");
});
