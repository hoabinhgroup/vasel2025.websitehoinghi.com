<?php


Route::group(
	["namespace" => "Theme\Vasel2025\Http\Controllers", "middleware" => "web"],
	function () {
		Route::group(
			apply_filters(BASE_FILTER_GROUP_PUBLIC_ROUTE, []),
			function () {
				Route::get("/", "Vasel2025Controller@getIndex")->name("public.index");

				Route::get("registration.html", 'Vasel2025Controller@registration')->name('registration');

				Route::get("speaker-registration", 'SpeakerRegistrationController@form')->name('speaker.registration');
				Route::post("speaker-registration-submit", 'SpeakerRegistrationController@submit')->name('speaker.registration.submit');

				Route::get("speaker-registration-vn", 'SpeakerRegistrationVnController@form')->name('speaker.registration.vn');
				Route::post("speaker-registration-vn-submit", 'SpeakerRegistrationVnController@submit')->name('speaker.registration.vn.submit');

				Route::get("invitee-registration", 'InviteeRegistrationController@form')->name('invitee.registration');
				Route::post("invitee-registration-submit", 'InviteeRegistrationController@submit')->name('invitee.registration.submit');

				Route::get("invitee-registration-vn", 'InviteeRegistrationVnController@form')->name('invitee.registration.vn');
				Route::post("invitee-registration-vn-submit", 'InviteeRegistrationVnController@submit')->name('invitee.registration.vn.submit');

				Route::get("payment-registration-page", function () {
					return view("Vasel2025::payment-registration-page");
				});

				Route::get("register-here.html", function () {
					return view("Vasel2025::registration-page");
				});


				Route::post("payment-registration-submit", 'Vasel2025Controller@paymentRegistrationSubmit')
					->name("payment.registration.submit");

				Route::get("registration/dr", 'Vasel2025Controller@handleRegistrationResponse')
					->name("payment.registration.dr");

				Route::get("registration/success", function () {
					return view('Vasel2025::partials.successful');
				})
					->name("registration.successful");

				Route::get("registration/cancel", function () {
					return view('Vasel2025::partials.cancel');
				})
					->name("registration.cancel");


				Route::get("registration/error", function () {
					return view('Vasel2025::partials.error');
				})
					->name("registration.error");


				Route::match(
					['GET', 'POST'],
					'/attendance-table',
					'Vasel2025Controller@getAttendanceTable'
				)->name('public.attendance.table');

				Route::any("{uri}.html", [
					"uses" => "VaselController@getView",
					"as" => "public.single",
				])->where("getView", "^(?!" . BACKEND . ').*$');

				Route::get("registration", "Vasel2025Controller@registration");

				Route::post("get-fee-total", "Vasel2025Controller@getFeeTotal");


			}
		);
	}
);
