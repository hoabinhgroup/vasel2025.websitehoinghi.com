<?php

namespace Modules\Theme\Providers;

use File;
use Illuminate\Support\Facades\Route;
use Modules\Base\Providers\RoutingServiceProvider as BaseRoutingServiceProvider;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends BaseRoutingServiceProvider
{
	protected $moduleNamespace = 'Modules\Theme\Http\Controllers';
	    
  /*  public function boot()
    {
        $this->app->booted(function () {

            $themeRoute = theme_path(setting('theme') . '/routes/web.php');
            
            if (File::exists($themeRoute)) {
	    
                $this->loadRoutesFrom($themeRoute);
            }
            
            $this->loadRoutesFrom($this->getBackendRoute());
          
        });
    }
    */

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
