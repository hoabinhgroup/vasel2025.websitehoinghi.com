<?php

Route::group(['prefix' => 'member', 'as' => 'member.'], function(){

    Route::resource("", "MemberController")->parameters(["" => "member"]);

   Route::get('restore/{id}', 'MemberController@restore')
   		->name('restore');

   Route::post('delete/{id}', 'MemberController@destroy')
   		->name('delete');

   Route::post('deletes', 'MemberController@deletes')
      ->name('deletes');

});
