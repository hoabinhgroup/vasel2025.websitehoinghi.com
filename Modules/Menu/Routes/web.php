<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::prefix('menu')->group(function() {
    Route::get('/', 'MenuController@index');
});
*/

// Route::group(['prefix' => 'menu'], function(){
//    Route::get('/', 'MenuController@index')
// 		 ->name('menu.index')
// 		 ->middleware('can:menu.create');
//
//
//    Route::get('/publish', 'MenuController@show')
// 		 ->name('publish_menu')
// 		 ->middleware('can:menu.publish');
//
//    Route::get('/index', 'MenuController@data')
//    		 ->name('datatables.data');
//    Route::post('/index', 'MenuController@data')
//    		 ->name('datatables.data');
//
//    /*Route::post('/', function(){
// 	   return View::make('menu::modal.menu-add');
//    })->name('menu.modal'); 	 */
//
//     Route::get('/create', 'MenuController@create')
//     	->name('menu.create');
//
//    Route::get('/edit/{id}', 'MenuController@edit')
//    		->name('menu.edit');
//
//    Route::post('/update/{id}', 'MenuController@update')
//    		->name('menu.update');
//
//    Route::post('/delete', 'MenuController@destroy')
//    		->name('menu.delete');
//
//    Route::post('/store', 'MenuController@store')
//    	    ->name('menu.save');
//
// });
//
//   	/* Menus */
//    Route::group(['prefix' => 'menus'], function(){
//    		Route::get('/', 'MenusController@index')
// 		 ->name('menu.index');
//
// 		Route::get('/index', 'MenusController@data')
//    		 ->name('backend.menus.data');
//    		Route::post('/index', 'MenusController@data')
//    		 ->name('backend.menus.data');
//
//    		Route::get('/create', 'MenusController@create')
//     	->name('backend.menus.create');
//
//     	 Route::get('/edit/{id}', 'MenusController@edit')
//    		->name('backend.menus.edit');
//
//    		Route::post('/update/{id}', 'MenusController@update')
//    		->name('backend.menus.update');
//
//    		Route::post('/delete', 'MenusController@destroy')
//    		->name('backend.menus.delete');
//
//    		Route::post('/store', 'MenusController@store')
//    	    ->name('backend.menus.save');
//
//    });
//
//       /* Menu Node */
//     	Route::group(['prefix' => 'menunode'], function(){
// 	    	Route::get('/', 'MenuNodeController@index')
// 			->name('backend.menunode.index');
//
// 			Route::post('/updatesort', 'MenuNodeController@updateSort')
// 			->name('backend.menunode.sort');
//
// 			Route::post('/import', 'MenuNodeController@import')
// 			->name('backend.menunode.import');
//
// 			Route::post('/modal', 'MenuNodeController@modal')
// 			->name('backend.menunode.modal');
//
// 			Route::post('/update/{id}', 'MenuNodeController@update')
// 			->name('backend.menunode.update');
//
// 			Route::post('/delete/{id}', 'MenuNodeController@destroy')
// 			->name('backend.menunode.delete');
//
// 			Route::get('/test', 'MenuNodeController@test');
//
// 		});
