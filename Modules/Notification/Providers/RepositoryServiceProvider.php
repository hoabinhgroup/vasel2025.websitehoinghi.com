<?php namespace Modules\Notification\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;

class RepositoryServiceProvider extends ServiceProvider
{


    public function register()
    {
		  $this->app->bind(
            'Modules\Notification\Repositories\NotificationInterface',
            'Modules\Notification\Repositories\Eloquent\NotificationRepository'
            );

       
    }
}