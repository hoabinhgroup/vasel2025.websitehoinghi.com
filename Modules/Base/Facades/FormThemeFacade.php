<?php

namespace Modules\Base\Facades;

use Modules\Base\Supports\FormTheme;
use Illuminate\Support\Facades\Facade;

class FormThemeFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return FormTheme::class;
    }
}
