<?php
use Modules\Appstore\Http\Controllers\AppstoreController;
Route::group(
    [
        "prefix" => "appstore",
         'as' => 'appstore.'
    ],
    function () {
        Route::get("/", [AppstoreController::class, "index"])
            ->name("index");

        Route::post("plugins-change-status", "AppstoreController@changestatus")->name('changeStatus');

        Route::delete("module-delete/{module}", [
            AppstoreController::class,
            "destroy",
        ]);
    }
);
