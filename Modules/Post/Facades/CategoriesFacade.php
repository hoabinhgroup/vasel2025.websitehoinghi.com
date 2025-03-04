<?php

namespace Modules\Post\Facades;

use Modules\Post\Categories;
use Illuminate\Support\Facades\Facade;

/**
 * Class ManagerFacade
 * @package Modules\Base
 */
class CategoriesFacade extends Facade
{

    /**
     * @return string
     * @author Tuan Louis
     */
    protected static function getFacadeAccessor()
    {
        return Categories::class;
    }
}
