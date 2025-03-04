<?php

namespace Modules\Media\Facades;

use Modules\Media\LouisMedia;
use Illuminate\Support\Facades\Facade;

class LouisMediaFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return LouisMedia::class;
    }
}
