<?php

namespace Modules\Appstore\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Routing\Events\RouteMatched;
use Modules\Base\Traits\LoadDataTrait;
use Event;
use Modules\Base\Supports\Helper;

class AppstoreServiceProvider extends ServiceProvider
{
    use LoadDataTrait;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        Helper::autoload(__DIR__ . "/../Helpers");

    }

    public function boot()
    {
        $this->setNamespace("Appstore")
            ->loadAndPublishConfigurations(["config"])
            ->loadAndPublishPermissions()
            ->loadWidgets()
            ->loadAndPublishViews()
            ->loadMigrations();

        $this->app->register(RouteServiceProvider::class);
            Event::listen(RouteMatched::class, function () {
                panel_menu()->registerItem([
                    "id" => "cms-core-appstore",
                    "priority" => 5,
                    "parent_id" => null,
                    "name" => "Plugins",
                    "icon" => "fa fa-cubes",
                    "url" => route("appstore.index"),
                    "permissions" => ["appstore.index"],
                ]);
            });

        add_action(WIDGET_LIST, [$this, "registerWidgetList"], 3);
    }



    public function registerWidgetList($template_id)
    {
        return displayWidgetListByModule(APPSTORE_SCREEN, $template_id);
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
