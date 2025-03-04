<?php

namespace Modules\Setting\Providers;

use Modules\Setting\Supports\SettingStore;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Modules\Setting\Facades\SettingFacade;
use Illuminate\Routing\Events\RouteMatched;
use Modules\Base\Traits\LoadDataTrait;
use Modules\Base\Supports\Helper;
use Event;

class SettingServiceProvider extends ServiceProvider
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

    $this->app->singleton(SettingStore::class, function () {
        return new DatabaseSettingStore();
    });
    
    if (! class_exists('Setting')) {
        AliasLoader::getInstance()->alias('Setting', Setting::class);
    }


  }

  /**
   * Boot the application events.
   *
   * @return void
   */
  public function boot()
  {

     $this->setNamespace("Setting")
        ->loadAndPublishConfigurations(["config"])
        ->loadAndPublishPermissions()
        ->loadAndPublishTranslations()
        ->loadAndPublishViews()
        ->loadMigrations();


    Event::listen(RouteMatched::class, function () {
      panel_menu()
        ->registerItem([
          "id" => "cms-tools",
          "priority" => 7,
          "parent_id" => null,
          "name" => "Cài đặt",
          "icon" => "icon-wrench",
          "url" => route("setting.general"),
          "permissions" => ["setting.general"],
        ])
        ->registerItem([
          "id" => "cms-core-setting-general",
          "priority" => 0,
          "parent_id" => "cms-tools",
          "name" => "Cơ bản",
          "icon" => null,
          "url" => route("setting.general"),
          "permissions" => ["setting.general"],
        ])
        ->registerItem([
          "id" => "cms-core-setting-email",
          "priority" => 0,
          "parent_id" => "cms-tools",
          "name" => "Cấu hình gửi Email",
          "icon" => null,
          "url" => route("setting.email"),
          "permissions" => ["setting.cache"],
        ])
        ->registerItem([
          "id" => "cms-core-setting-cache",
          "priority" => 1,
          "parent_id" => "cms-tools",
          "name" => "Quản lý Sao lưu",
          "icon" => null,
          "url" => route("setting.backup"),
          "permissions" => ["setting.backup"],
        ])
        ->registerItem([
          "id" => "cms-core-setting-cache",
          "priority" => 2,
          "parent_id" => "cms-tools",
          "name" => "Quản lý bộ nhớ đệm",
          "icon" => null,
          "url" => route("setting.cache"),
          "permissions" => ["setting.cache"],
        ])
        ->registerItem([
            'id'          => 'cms-core-setting-media',
            'priority'    => 3,
            'parent_id'   => 'cms-tools',
            'name'        => 'Media',
            'icon'        => null,
            'url'         => route('setting.media'),
            'permissions' => ['setting.media'],
        ]);
    });

    $this->app->register(RouteServiceProvider::class);

    $this->app->bind(
      "Modules\Setting\Repositories\SettingInterface",
      "Modules\Setting\Repositories\Eloquent\SettingRepository"
    );
  }

  /**
   * Get the services provided by the provider.
   *
   * @return array
   */
  public function provides()
  {
    return [
      SettingStore::class
        
      ];
  }
}
