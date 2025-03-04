<?php

namespace Modules\Base\Providers;

//use Illuminate\Support\Facades\Route;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;
use File;

abstract class RoutingServiceProvider extends ServiceProvider
{
  /**
   * The module namespace to assume when generating URLs to actions.
   *
   * @var string
   */
  // protected $moduleNamespace = 'Modules\Base\Http\Controllers';
  protected $moduleNamespace = "";

  /**
   * Called before routes are registered.
   *
   * Register any model bindings or pattern based filters.
   *
   * @return void
   */
  public function boot()
  {
    parent::boot();
  }

  /**
   * @return string
   */
  abstract protected function getFrontendRoute();

  /**
   * @return string
   */
  abstract protected function getBackendRoute();

  /**
   * @return string
   */
  abstract protected function getApiRoute();

  /**
   * Define the routes for the application.
   *
   * @return void
   */

  public function map(Router $router)
  {
    $router->group(["namespace" => $this->moduleNamespace], function (
      Router $router
    ) {
      $this->loadApiRoutes($router);
    });

    $router->group([], function (Router $router) {
      $this->loadBackendRoutes($router);
      $this->loadFrontendRoutes($router);

      $themeRoute = theme_folder_path(setting("theme") . "/routes/web.php");

      if (File::exists($themeRoute)) {
        $this->loadRoutesFrom($themeRoute);
      }
    });
  }

  /**
   * @param Router $router
   */
  private function loadFrontendRoutes(Router $router)
  {
    $frontend = $this->getFrontendRoute();

    if ($frontend && file_exists($frontend)) {
      $middleware = ["web"];
      if (is_plugin_active("Languages")) {
        $middleware = array_merge($middleware, ["locale"]);
      } else {
        app()->setLocale(setting("main_language"));
      }

      $router->group(
        [
          "namespace" => $this->moduleNamespace,
          "middleware" => $middleware,
        ],
        function (Router $router) use ($frontend) {
          require $frontend;
        }
      );
    }
  }

  protected function loadBackendRoutes(Router $router)
  {
    $backend = $this->getBackendRoute();
    $middleware = ["backend", "auth.base"];
    if (is_plugin_active("Languages")) {
      $middleware = array_merge($middleware, ["locale"]);
    } else {
      app()->setLocale(setting("main_language"));
    }

    if ($backend && file_exists($backend)) {
      $router->group(
        [
          "namespace" => $this->moduleNamespace,
          "prefix" => BACKEND,
          "middleware" => $middleware,
        ],
        function (Router $router) use ($backend) {
          require $backend;
        }
      );
    }
  }

  /**
   * Define the "api" routes for the application.
   *
   * These routes are typically stateless.
   *
   * @return void
   */
  protected function loadApiRoutes(Router $router)
  {
    $api = $this->getApiRoute();

    if ($api && file_exists($api)) {
      $router->group(
        [
          "namespace" => "Api",
          "prefix" => "api",
          "middleware" => "api",
        ],
        function (Router $router) use ($api) {
          require $api;
        }
      );
    }
  }
}
