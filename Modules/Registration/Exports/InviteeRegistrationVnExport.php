<?php
namespace Modules\Registration\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Modules\Registration\Entities\InviteeRegistrationVn;

class InviteeRegistrationVnExport implements FromView
{
	public function view(): View
	{

		$view = view('registration::exports.invitee-registration-vn', [
			'registrations' => InviteeRegistrationVn::all()
		]);


		return $view;

	}

}