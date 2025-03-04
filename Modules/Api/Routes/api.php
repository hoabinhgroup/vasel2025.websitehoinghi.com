<?php

 Route::get('enable-ads', 'ApiController@enableAds');

   Route::get('billinfo', 'BillInfoController@index');

    Route::post('receive-api', 'ApiController@receiveApi');
    Route::get('receive-api-test', 'ApiController@receiveApiTest');
