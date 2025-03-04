<?php

Route::group(["prefix" => "analytics"], function () {
  Route::get("/", "AnalyticsController@index")->name("analytics.index");

  Route::get(
    "/top-referrer-widget",
    "AnalyticsController@topRererrerWidgetTable"
  )->name("analytics.top.referrer");

  Route::get(
    "/top-visit-page-widget",
    "AnalyticsController@topVisitPageWidgetTable"
  )->name("analytics.top.visit.page");

  Route::post("delete/{id}", "AnalyticsController@destroy")->name(
    "analytics.delete"
  );
});
