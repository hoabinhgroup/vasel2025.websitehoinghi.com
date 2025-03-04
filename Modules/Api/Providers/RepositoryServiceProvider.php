<?php namespace Modules\Api\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;

class RepositoryServiceProvider extends ServiceProvider
{


    public function register()
    {
		  $this->app->bind(
            'Modules\Api\Repositories\ApiInterface',
            'Modules\Api\Repositories\Eloquent\ApiRepository'
            );

       
    }
}