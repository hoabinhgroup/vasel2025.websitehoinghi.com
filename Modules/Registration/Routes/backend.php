<?php

Route::group(['prefix' => 'speaker-registration', 'as' => 'speaker.registration.'], function () {

  Route::resource("", "SpeakerRegistrationController")->parameters(["" => "registration"]);

  Route::get('export', 'SpeakerRegistrationController@export')
    ->name('export');

  Route::post('delete/{id}', 'SpeakerRegistrationController@destroy')
    ->name('delete');
});


Route::group(['prefix' => 'speaker-registration-vn', 'as' => 'speakervn.registration.'], function () {

  Route::resource("", "SpeakerRegistrationVnController")->parameters(["" => "registration"]);

  Route::get('export', 'SpeakerRegistrationVnController@export')
    ->name('export');

  Route::post('delete/{id}', 'SpeakerRegistrationVnController@destroy')
    ->name('delete');
});

Route::group(['prefix' => 'invitee-registration', 'as' => 'invitee.registration.'], function () {

  Route::resource("", "InviteeRegistrationController")->parameters(["" => "registration"]);

  Route::get('export', 'InviteeRegistrationController@export')
    ->name('export');

  Route::post('delete/{id}', 'InviteeRegistrationController@destroy')
    ->name('delete');
});


Route::group(['prefix' => 'invitee-registration-vn', 'as' => 'inviteevn.registration.'], function () {

  Route::resource("", "InviteeRegistrationVnController")->parameters(["" => "registration"]);

  Route::get('export', 'InviteeRegistrationVnController@export')
    ->name('export');

  Route::post('delete/{id}', 'InviteeRegistrationVnController@destroy')
    ->name('delete');
});

Route::group(['prefix' => 'registration', 'as' => 'registration.'], function () {

  Route::resource("", "RegistrationController")->parameters(["" => "registration"]);




  Route::get('export', 'RegistrationController@export')
    ->name('export');


  Route::get('restore/{id}', 'RegistrationController@restore')
    ->name('restore');

  Route::post('delete/{id}', 'RegistrationController@destroy')
    ->name('delete');

  Route::post('deletes', 'RegistrationController@deletes')
    ->name('deletes');

  Route::group(['prefix' => 'faculty', 'as' => 'faculty.'], function () {
    Route::resource("", "FacultyController")->parameters(["" => "faculty"]);
    Route::post('delete/{id}', 'FacultyController@destroy')
      ->name('delete');
  });

  Route::group(['prefix' => 'fullpaper', 'as' => 'fullpaper.'], function () {
    Route::post('delete/{id}', 'FullpaperSubmissionController@destroy')
      ->name('delete');
    Route::post('deletes', 'FullpaperSubmissionController@deletes')
      ->name('deletes');
    Route::get('export', 'FullpaperSubmissionController@export')
      ->name('export');
  });


});
