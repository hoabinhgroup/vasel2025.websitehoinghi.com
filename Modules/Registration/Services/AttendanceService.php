<?php

namespace Modules\Registration\Services;

use Modules\Registration\Entities\Registration;

class AttendanceService
{

	public function create($data)
	{
		$registration =	Registration::create($data);
		return $registration;
	}
}
