<?php
use Modules\Setting\Http\Controllers\SettingController;

Route::group(["prefix" => "setting"], function () {
    Route::get("general", [SettingController::class, "general"])->name(
        "setting.general"
    );

    Route::get("cache", [SettingController::class, "cache"])->name(
        "setting.cache"
    );

    Route::get("email", [SettingController::class, "email"])->name(
        "setting.email"
    );
    
    Route::get("media", [SettingController::class, "getMediaSetting"])->name(
        "setting.media"
    );
    
    Route::post("media/edit", [SettingController::class, "postMediaSetting"])->name(
        "setting.media.edit"
    );

    Route::get("backup", [SettingController::class, "backup"])->name(
        "setting.backup"
    );

    Route::get("backup/generation/{type}", [
        SettingController::class,
        "backupGeneration",
    ])->name("backup.generation");

    Route::post("backup/delete/{id}", [
        SettingController::class,
        "backupDelete",
    ])->name("backup.delete");

    Route::get("backup/download/{id}", [
        SettingController::class,
        "backupDownload",
    ])->name("backup.download");

    Route::post("clear", [SettingController::class, "postClearCache"])->name(
        "system.cache.clear"
    );

    Route::post("general/edit", [SettingController::class, "edit"])->name(
        "setting.edit"
    );
});
