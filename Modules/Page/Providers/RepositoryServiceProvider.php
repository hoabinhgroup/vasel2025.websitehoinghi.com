<?php
	namespace Modules\Page\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;

class RepositoryServiceProvider extends ServiceProvider
{


    public function register()
    {
		  $this->app->bind(
            'Modules\Page\Repositories\PageInterface',
            'Modules\Page\Repositories\Eloquent\PageRepository'
            );

       
    }
}
