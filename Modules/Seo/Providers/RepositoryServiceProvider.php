<?php namespace Modules\Seo\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;

class RepositoryServiceProvider extends ServiceProvider
{


    public function register()
    {
		  $this->app->bind(
            'Modules\Seo\Repositories\SeoInterface',
            'Modules\Seo\Repositories\Eloquent\SeoRepository'
            );

       
    }
}
