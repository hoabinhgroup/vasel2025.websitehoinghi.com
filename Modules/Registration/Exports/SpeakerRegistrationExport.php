<?php
namespace Modules\Registration\Exports;

use Modules\Registration\Entities\Registration;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Modules\Registration\Entities\SpeakerRegistration;
use PhpOffice\PhpSpreadsheet\Reader\Exception;

class SpeakerRegistrationExport implements FromView
{
	public function view(): View
	{

		$view = view('registration::exports.speaker-registration', [
			'registrations' => SpeakerRegistration::all()
		]);


		return $view;

	}

}