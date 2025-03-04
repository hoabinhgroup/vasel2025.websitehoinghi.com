<?php

namespace Modules\Menu\Providers;

use Illuminate\Support\Facades\Route;
use Modules\Base\Providers\RoutingServiceProvider as BaseRoutingServiceProvider;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends BaseRoutingServiceProvider
{
    /**
     * The module namespace to assume when generating URLs to actions.
     *
     * @var string
     */
    protected $moduleNamespace = "Modules\Menu\Http\Controllers";

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    /**
     * @return string
     */
    protected function getFrontendRoute()
    {
        return false;
    }

    protected function getBackendRoute()
    {
        return __DIR__ . "/../Routes/backend.php";
    }

    /**
     * @return string
     */
    protected function getApiRoute()
    {
        return __DIR__ . "/../Routes/api.php";
    }
}
