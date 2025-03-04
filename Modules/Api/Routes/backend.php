<?php

Route::group(['prefix' => 'api', 'as' => 'api.'], function(){

    Route::resource("", "ApiController")->parameters(["" => "api"]);

   Route::get('restore/{id}', 'ApiController@restore')
   		->name('restore');

   Route::post('delete/{id}', 'ApiController@destroy')
   		->name('delete');

   Route::post('deletes', 'ApiController@deletes')
      ->name('deletes');

});
