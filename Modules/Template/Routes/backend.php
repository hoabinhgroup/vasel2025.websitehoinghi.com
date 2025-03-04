<?php
use Modules\Template\Http\Controllers\TemplateController;
Route::group(
  [
    "prefix" => "template",
    "as" => "template.",
  ],
  function () {
    Route::resource("", "TemplateController")->parameters(["" => "template"]);

    Route::post("delete/{id}", [TemplateController::class, "destroy"])->name(
      "delete"
    );

    Route::post("widget/config", [WidgetController::class, "config"])->name(
      "config_widget"
    );
  }
);
