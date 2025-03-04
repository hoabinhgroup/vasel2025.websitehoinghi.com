<?php

namespace Modules\Block\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Routing\Events\RouteMatched;
use Modules\Base\Traits\LoadDataTrait;
use Event;
use Modules\Base\Supports\Helper;

class BlockServiceProvider extends ServiceProvider
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

      $this->app->booted(function () {
        if (defined("LANG_NAME")) {
          \Language::registerModule([\Modules\Block\Entities\Block::class]);
        }
        $this->app->register(HookServiceProvider::class);
      });
    }

  /**
   * Boot the application events.
   *
   * @return void
   */
  public function boot()
  {
    $this->setNamespace("Block")
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
              "id" => "cms-plugins-block",
              "priority" => 5,
              "parent_id" => null,
              "name" => "block::block.name",
              "icon" => "ft-layers",
              "url" => route("block.index"),
              "permissions" => ["block.index"],
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
