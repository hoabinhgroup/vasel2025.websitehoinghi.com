<?php

namespace Modules\Menu\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Modules\Base\Supports\Helper;
use Theme;
use Illuminate\Foundation\AliasLoader;
use Modules\Menu\Facades\MenuFacade;
use Illuminate\Routing\Events\RouteMatched;
use Modules\Base\Traits\LoadDataTrait;
use Event;

class MenuServiceProvider extends ServiceProvider
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
        Helper::autoload(__DIR__.'/../Libraries');


    }
    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {

        $this->setNamespace('Menu')
       		->loadAndPublishConfigurations(['config'])
            ->loadAndPublishPermissions()
       		->loadAndPublishTranslations()
       		->loadAndPublishViews()
       		->loadMigrations();
            // $this->registerBindings();
             AliasLoader::getInstance()->alias('Menu', MenuFacade::class);
             $this->app->register(RouteServiceProvider::class);
             $this->app->register(RepositoryServiceProvider::class);
             $this->app->register(HookServiceProvider::class);
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
