<?php
namespace Modules\Registration\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Modules\Registration\Entities\SpeakerRegistrationVn;
use PhpOffice\PhpSpreadsheet\Reader\Exception;

class SpeakerRegistrationVnExport implements FromView
{
	public function view(): View
	{

		$view = view('registration::exports.speaker-registration-vn', [
			'registrations' => SpeakerRegistrationVn::all()
		]);

		return $view;

	}

}