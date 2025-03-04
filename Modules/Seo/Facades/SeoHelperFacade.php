<?php

namespace Modules\Seo\Facades;

use Modules\Seo\SeoHelper;
use Illuminate\Support\Facades\Facade;


class SeoHelperFacade extends Facade
{

    /**
     * @return string
     *
     */
    protected static function getFacadeAccessor()
    {
        return SeoHelper::class;
    }
}
