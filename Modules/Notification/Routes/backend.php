<?php

Route::group(['prefix' => 'notification'], function(){

   Route::get('/', 'NotificationController@index')
		 ->name('notification.index');

//     Route::get('create', 'NotificationController@create')
//     	->name('notification.create');
//
//    Route::post('create', 'NotificationController@store')
//    	    ->name('notification.create');
//
//    Route::get('edit/{id}', 'NotificationController@edit')
//    		->name('notification.edit');
//
//    Route::post('edit/{id}', 'NotificationController@update')
//    		->name('notification.edit');
//
//    Route::get('restore/{id}', 'NotificationController@restore')
//    		->name('notification.restore');
//
//    Route::post('delete/{id}', 'NotificationController@destroy')
//    		->name('notification.delete');

});
