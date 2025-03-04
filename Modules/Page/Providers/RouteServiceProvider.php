<?php

namespace Modules\Page\Providers;

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
    protected $moduleNamespace = 'Modules\Page\Http\Controllers';


  /**
     * @return string
     */
    protected function getFrontendRoute()
    {
        return __DIR__ . '/../Routes/frontend.php';
    }

    
     protected function getBackendRoute()
    {
	    
         return __DIR__ . '/../Routes/backend.php';
    }

      /**
     * @return string
     */
    protected function getApiRoute()
    {
        return __DIR__ . '/../Routes/api.php';
    }

}
