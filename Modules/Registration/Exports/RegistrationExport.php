<?php
namespace Modules\Registration\Exports;

use Modules\Registration\Entities\Registration;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use PhpOffice\PhpSpreadsheet\Reader\Exception;

class RegistrationExport implements FromView
{
	public function view(): View
	{
	
		$view = view('registration::exports.registration', [
			'registrations' => Registration::all()
		]);
		
		
		return $view;

	}
	
}