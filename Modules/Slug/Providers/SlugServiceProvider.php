<?php

namespace Modules\Slug\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Modules\Base\Traits\LoadDataTrait;
use Modules\Base\Supports\Helper;

class SlugServiceProvider extends ServiceProvider
{
    use LoadDataTrait;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RepositoryServiceProvider::class);

        Helper::autoload(__DIR__ . "/../Helpers");
        $this->app->register(FormServiceProvider::class);

    }
    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {

        $this->app->register(HookServiceProvider::class);

        $this->app->register(EventServiceProvider::class);
        $this->app->register(RouteServiceProvider::class);


       $this->setNamespace("Slug")
       ->loadAndPublishConfigurations(["config"])
       ->loadAndPublishPermissions()
       ->loadAndPublishTranslations()
       ->loadAndPublishViews()
       ->loadMigrations();


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
