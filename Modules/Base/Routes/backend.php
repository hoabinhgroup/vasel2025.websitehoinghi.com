<?php

use Modules\Base\Http\Controllers\TableController;

Route::group(
  [
    "prefix" => "tables",
    "permission" => false,
  ],
  function () {
    Route::get("bulk-change/data", [
      TableController::class,
      "getDataForBulkChanges",
    ])->name("tables.bulk-change.data");
    Route::post("bulk-change/save", [
      TableController::class,
      "postSaveBulkChange",
    ])->name("tables.bulk-change.save");
    Route::get("get-filter-input", [
      TableController::class,
      "getFilterInput",
    ])->name("tables.get-filter-input");
  }
);
