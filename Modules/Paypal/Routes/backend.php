<?php

Route::group(['prefix' => 'paypal', 'as' => 'paypal.'], function(){

    Route::resource("", "PaypalController")->parameters(["" => "paypal"]);

   Route::get('restore/{id}', 'PaypalController@restore')
   		->name('restore');

   Route::post('delete/{id}', 'PaypalController@destroy')
   		->name('delete');

   Route::post('deletes', 'PaypalController@deletes')
      ->name('deletes');

});
