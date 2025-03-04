<?php

namespace Modules\Paypal\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Routing\Events\RouteMatched;
use Modules\Base\Traits\LoadDataTrait;
use Event;
use Modules\Base\Supports\Helper;

class PaypalServiceProvider extends ServiceProvider
{
	use LoadDataTrait;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
         Helper::autoload(__DIR__ . '/../Helpers');

    }

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {

       $this->setNamespace('Paypal')
       		->loadAndPublishConfigurations(['config'])
       		->loadAndPublishTranslations()
       		->loadAndPublishViews()
       		->loadMigrations();

            $this->app->register(RouteServiceProvider::class);
            $this->app->register(RepositoryServiceProvider::class);
          // $this->app->register(HookServiceProvider::class);

            Event::listen(RouteMatched::class, function () {
               panel_menu()->registerItem([
                   'id'          => 'cms-plugins-paypal',
                   'priority'    => 5,
                   'parent_id'   => null,
                   'name'        => 'paypal::paypal.name',
                   'icon'        => 'icon-doc',
                   'url'         => route('paypal.index'),
                   'permissions' => ['paypal.index'],
               ]);

           });
    }


    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
