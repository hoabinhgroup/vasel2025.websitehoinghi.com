<?php
	Route::get('/markAsRead', 'NotificationController@markAsRead');
   
   Route::post('/notification/get-slug-thread/{id}', 'NotificationController@getSlug');
   
  