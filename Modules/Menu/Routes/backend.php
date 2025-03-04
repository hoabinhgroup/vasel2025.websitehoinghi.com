<?php
use Modules\Menu\Http\Controllers\MenuController;
use Modules\Menu\Http\Controllers\MenusController;
use Modules\Menu\Http\Controllers\MenuNodeController;

Route::group(["prefix" => "menu", "as" => "menu."], function () {
  Route::resource("", "MenuController")->parameters(["" => "menu"]);

  Route::get("publish", [MenuController::class, "show"])->name("publish_menu");

  Route::post("delete", [MenuController::class, "destroy"])->name("delete");
});

/* Menus */
Route::group(["prefix" => "menus", "as" => "menus."], function () {
  Route::resource("", "MenusController")->parameters(["" => "menus"]);

  Route::post("delete", [MenusController::class, "destroy"])->name("delete");

  Route::delete("deletes", [MenusController::class, "deletes"])->name(
    "deletes"
  );
});

/* Menu Node */
Route::group(["prefix" => "menunode", "as" => "menunode."], function () {
  Route::resource("", "MenuNodeController")->parameters(["" => "menunode"]);

  Route::post("updatesort", [MenuNodeController::class, "updateSort"])->name(
    "sort"
  );

  Route::post("import", [MenuNodeController::class, "import"])->name(
    "import"
  );

  Route::post("add-external-url", [MenuNodeController::class, "addExternalUrl"])->name(
      "addExternalUrl"
    );

  Route::post("modal", [MenuNodeController::class, "modal"])->name(
    "modal"
  );

  Route::post("update/{id}", [MenuNodeController::class, "update"])->name(
    "update"
  );

  Route::post("delete/{id}", [MenuNodeController::class, "destroy"])->name(
    "delete"
  );

  Route::get("/test", [MenuNodeController::class, "test"]);
});
