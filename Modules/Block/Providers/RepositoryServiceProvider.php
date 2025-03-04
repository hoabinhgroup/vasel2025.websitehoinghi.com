<?php namespace Modules\Block\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;

class RepositoryServiceProvider extends ServiceProvider
{


    public function register()
    {
		  $this->app->bind(
            'Modules\Block\Repositories\BlockInterface',
            'Modules\Block\Repositories\Eloquent\BlockRepository'
            );

       
    }
}
