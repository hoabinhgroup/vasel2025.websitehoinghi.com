<?php
	namespace Modules\Slug\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;

class RepositoryServiceProvider extends ServiceProvider
{


    public function register()
    {
		  $this->app->bind(
            'Modules\Slug\Repositories\SlugInterface',
            'Modules\Slug\Repositories\Eloquent\SlugRepository'
            );
       
    }
}
