<?php
	namespace Modules\Menu\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;

class RepositoryServiceProvider extends ServiceProvider
{


    public function register()
    {
		  $this->app->bind(
            'Modules\Menu\Repositories\MenuInterface',
            'Modules\Menu\Repositories\Eloquent\MenuRepository'
            );
          
          $this->app->bind(
            'Modules\Menu\Repositories\MenusInterface',
            'Modules\Menu\Repositories\Eloquent\MenusRepository'
            );
           
           $this->app->bind(
            'Modules\Menu\Repositories\MenuNodeInterface',
            'Modules\Menu\Repositories\Eloquent\MenuNodeRepository'
            );  
       
    }
}
