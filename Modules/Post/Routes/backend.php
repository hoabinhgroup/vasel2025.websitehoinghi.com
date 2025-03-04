<?php

Route::group(['prefix' => 'post', 'as' => "post."], function(){

   Route::resource("", "PostController")->parameters(["" => "post"]);

   Route::get('restore/{id}', 'PostController@restore')
   		->name('restore');

   Route::post('delete/{id}', 'PostController@destroy')
   		->name('delete');

});


Route::group(['prefix' => 'categories', 'as' => "categories."], function(){

    Route::resource("", "CategoriesController")->parameters(["" => "categories"]);

   	Route::get('restore/{id}', 'CategoriesController@restore')
   		->name('restore');

    Route::post('delete', 'CategoriesController@destroy')
   		->name('delete');

});


Route::group(['prefix' => 'tags', 'as' => "tag."], function(){

    Route::resource("", "TagController")->parameters(["" => "tag"]);


   	Route::get('all', 'TagController@getAllTags')
   		->name('getAllTags');

    Route::post('delete/{id}', 'TagController@destroy')
   		->name('delete');

});
