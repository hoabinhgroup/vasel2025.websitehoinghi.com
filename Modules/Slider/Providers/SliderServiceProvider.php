<?php

namespace Modules\Slider\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Routing\Events\RouteMatched;
use Modules\Base\Traits\LoadDataTrait;
use Event;
use Modules\Base\Supports\Helper;

class SliderServiceProvider extends ServiceProvider
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
    $this->setNamespace("Slider")
      ->loadAndPublishConfigurations(["config"])
      ->loadAndPublishPermissions()
      ->loadAndPublishTranslations()
      ->loadAndPublishViews()
      ->loadMigrations();

        $this->app->register(RouteServiceProvider::class);
        $this->app->register(RepositoryServiceProvider::class);
        // $this->app->register(HookServiceProvider::class);

        Event::listen(RouteMatched::class, function () {
          panel_menu()->registerItem([
            "id" => "cms-plugins-slider",
            "priority" => 5,
            "parent_id" => null,
            "name" => "slider::slider.name",
            "icon" => "fa fa-picture-o",
            "url" => route("slider.index"),
            "permissions" => ["slider.index"],
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
