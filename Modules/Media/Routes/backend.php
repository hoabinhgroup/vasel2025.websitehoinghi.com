<?php

Route::group(['prefix' => 'media', 'as' => 'media.'], function(){

    Route::resource("", "MediaController")->parameters(["" => "media"]);

    Route::get('', 'MediaController@getMedia')
      ->name('index');
      
    Route::get('list', 'MediaController@getList')
       ->name('list');  
       
   Route::get('popup', 'MediaController@getPopup')
       ->name('popup'); 
      
   Route::get('breadcrumbs', 'MediaController@getBreadcrumbs')
       ->name('breadcrumbs'); 
   
   Route::post('global-actions', 'MediaController@postGlobalActions')
       ->name('global_actions'); 
       
   Route::get('download', 'MediaController@download')
    ->name('download'); 
    
    
    Route::group(['prefix' => 'files', 'as' => 'files.'], function () {
        Route::post('upload', 'MediaFileController@postUpload')
            ->name('upload'); 
            
        Route::post('upload-from-editor', 'MediaFileController@postUploadFromEditor')
            ->name('upload.from.editor'); 
          
    });
    
    Route::group(['prefix' => 'folders', 'as' => 'folders.'], function () {
       
       Route::resource("", "MediaFolderController")->parameters(["" => "folders"]);
       
       // Route::get('create', 'MediaFolderController@create')
       //   ->name('create'); 
        
        // Route::post('create', 'MediaFolderController@store')
        //     ->name('create'); 
    });
    
   Route::get('restore/{id}', 'MediaController@restore')
   		->name('restore');

   Route::post('delete/{id}', 'MediaController@destroy')
   		->name('delete');

   Route::post('deletes', 'MediaController@deletes')
      ->name('deletes');

});
