<?php

namespace Modules\Template\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Routing\Events\RouteMatched;
use Modules\Base\Traits\LoadDataTrait;
use Modules\Base\Supports\Helper;
use Event;

class TemplateServiceProvider extends ServiceProvider
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

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->setNamespace("Template")
        ->loadAndPublishConfigurations(["config"])
        ->loadAndPublishPermissions()
        ->loadAndPublishTranslations()
        ->loadAndPublishViews()
        ->loadMigrations();

        $this->app->register(RouteServiceProvider::class);
        $this->app->register(CommandServiceProvider::class);

       $this->app->bind(
                "Modules\Template\Repositories\TemplateInterface",
                "Modules\Template\Repositories\Eloquent\TemplateRepository"
            );


            Event::listen(RouteMatched::class, function () {
                panel_menu()->registerItem([
                    "id" => "cms-core-template",
                    "priority" => 10,
                    "parent_id" => null,
                    "name" => "Template",
                    "icon" => "ft-layout",
                    "url" => route("template.index"),
                    "permissions" => ["template.index"],
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
