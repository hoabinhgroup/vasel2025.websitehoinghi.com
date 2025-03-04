<?php
namespace Modules\Registration\Exports;

use Modules\Registration\Entities\InviteeRegistration;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class InviteeRegistrationExport implements FromView
{
	public function view(): View
	{

		$view = view('registration::exports.invitee-registration', [
			'registrations' => InviteeRegistration::all()
		]);


		return $view;

	}

}