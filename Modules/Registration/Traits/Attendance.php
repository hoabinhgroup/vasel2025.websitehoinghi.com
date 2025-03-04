<?php

namespace Modules\Registration\Traits;

use Modules\Registration\Entities\Registration;

trait Attendance
{

    protected function getCode($registration, $type = '')
    {
        return config('registration.email.code') . $type . '-' . sprintf("%03s", self::max('id') + 1);
    }
}
