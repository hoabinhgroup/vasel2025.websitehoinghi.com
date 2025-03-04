<?php

namespace Modules\Theme\Providers;

use Composer\Autoload\ClassLoader;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Modules\Base\Supports\Helper;
use Modules\Theme\Facades\ThemeManagerFacade;
use Illuminate\Routing\Events\RouteMatched;
use Illuminate\Support\Arr;
use Modules\Base\Traits\LoadDataTrait;
use Modules\Theme\Contracts\ThemeContract;
use Theme;
use Modules\Theme\Theme as cmsTheme;
use Event;
use File;
use Modules\Setting\Facades\SettingFacade;

class ThemeServiceProvider extends ServiceProvider
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
    if (
      !File::exists(public_path("Themes")) &&
      config("theme.symlink") &&
      File::exists(config("theme.theme_path"))
    ) {
      app()
        ->make("files")
        ->link(config("theme.theme_path"), public_path("Themes"));
    }

    $this->registerTheme();
    $this->consoleCommand();
    $this->registerMiddleware();

    \Theme::set(setting("theme"));

    $theme = setting("theme");

    if (!empty($theme)) {
      $themePath = theme_folder_path($theme);

      Helper::autoload(theme_folder_path($theme . "/functions"));

      if (File::exists($themePath . "/theme.json")) {
        $content = get_file_data($themePath . "/theme.json");
        if (!empty($content)) {
          if (Arr::has($content, "namespace")) {
            $loader = new ClassLoader();
            $loader->setPsr4(
              $content["namespace"],
              theme_folder_path($theme . "/src")
            );
            $loader->register();
          }
        }
      }
    }

    $this->setNamespace("Theme")
      ->loadAndPublishConfigurations(["config"])
      ->loadAndPublishPermissions()
      ->loadAndPublishTranslations()
      ->loadAndPublishViews()
      ->loadMigrations();

    $this->app->register(HookServiceProvider::class);
        $this->app->register(RouteServiceProvider::class);
        $this->app->register(CommandServiceProvider::class);

        Event::listen(RouteMatched::class, function () {
          panel_menu()
            ->registerItem([
              "id" => "cms-core-theme-index",
              "priority" => 6,
              "parent_id" => null,
              "name" => "Themes",
              "icon" => "ft-layers",
              "url" => route("theme.index"),
              "permissions" => ["theme.index"],
            ])
            ->registerItem([
              "id" => "cms-core-theme-list",
              "priority" => 1,
              "parent_id" => "cms-core-theme-index",
              "name" => "Quản lý Theme",
              "icon" => null,
              "url" => route("theme.index"),
              "permissions" => ["theme.index"],
            ])
            ->registerItem([
              "id" => "cms-core-theme-options",
              "priority" => 2,
              "parent_id" => "cms-core-theme-index",
              "name" => "Quản lý tùy chọn",
              "icon" => null,
              "url" => route("theme.options"),
              "permissions" => ["theme.index"],
            ])
            ->registerItem([
              "id" => "cms-core-menu-theme",
              "priority" => 2,
              "parent_id" => "cms-core-theme-index",
              "name" => "Menus",
              "icon" => null,
              "url" => route("menus.index"),
              "permissions" => ["menus.index"],
            ]);
        });

    add_action(WIDGET_LIST, [$this, "registerWidgetList"], 3);
  }



  public function registerMiddleware()
  {
    if (config("theme.types.enable")) {
      $themeTypes = config("theme.types.middleware");
      foreach ($themeTypes as $middleware => $themeName) {
        $this->app["router"]->aliasMiddleware(
          $middleware,
          "\Modules\Theme\Middleware\RouteMiddleware:" . $themeName
        );
      }
    }
  }

  /**
   * Register theme required components .
   *
   * @return void
   */
  public function registerTheme()
  {
    $this->app->singleton(ThemeContract::class, function ($app) {
      $theme = new cmsTheme(
        $app,
        $this->app["view"]->getFinder(),
        $this->app["config"],
        $this->app["translator"]
      );

      return $theme;
    });
  }

  /**
   * Add Commands.
   *
   * @return void
   */
  public function consoleCommand()
  {
    /*
        $this->registerThemeListCommand();
        // Assign commands.
        $this->commands(
            'theme.list'
        );
*/
  }

  public function registerWidgetList($template_id)
  {
    return displayWidgetListByModule(THEME_SCREEN, $template_id);
  }

  /**
   * Register theme list command.
   *
   * @return void
   */
  public function registerThemeListCommand()
  {
    // $this->app->singleton('theme.list', ThemeListCommand::class);
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
