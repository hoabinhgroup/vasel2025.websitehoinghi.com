<?php namespace Modules\Paypal\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;

class RepositoryServiceProvider extends ServiceProvider
{


    public function register()
    {
		  $this->app->bind(
            'Modules\Paypal\Repositories\PaypalInterface',
            'Modules\Paypal\Repositories\Eloquent\PaypalRepository'
            );

       
    }
}