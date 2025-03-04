<?php

namespace Modules\Base\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Support\Facades\File;
use Modules\Base\Exceptions\Handler;
use Modules\Base\Supports\Helper;
use Illuminate\Foundation\AliasLoader;
use Modules\Base\Supports\CustomResourceRegistrar;
use Modules\Base\Facades\ActionFacade;
use Modules\Base\Facades\FilterFacade;
use Illuminate\Routing\ResourceRegistrar;
use Modules\Base\Traits\LoadDataTrait;
use Illuminate\Support\Str;
use MetaBox;
use Gate;
use Module;

class BaseServiceProvider extends ServiceProvider
{

  use LoadDataTrait;
  /**
   * @var string $moduleName
   */
  protected $moduleName = "Base";

  /**
   * @var string $moduleNameLower
   */
  protected $moduleNameLower = "base";

  /**
   * Boot the application events.
   *
   * @return void
   */

  /**
   * Register the service provider.
   *
   * @return void
   */
  public function register()
  {

    Helper::autoload(__DIR__ . "/../Helpers");
    Helper::autoload(__DIR__ . "/../Services");

    $this->setNamespace('Base')
    ->loadAndPublishConfigurations(['config'])
    ->loadAndPublishPermissions()
    ->loadAndPublishTranslations()
    ->loadWidgets()
    ->loadAndPublishViews();

    // $module = Module::find("Setting");
    // $module->enable();

    //$modules = Module::collections()->toArray();
    // $modules = file_get_contents(base_path() . '/modules_statuses.json');
    // $modules = json_decode($modules, true);
    // $modules = array_filter($modules, function($value){
    //     return $value == 1;
    // });

  // dd(array_keys($modules));
    check_database_connection();

    $loader = AliasLoader::getInstance();
    $loader->alias("Action", ActionFacade::class);
    $loader->alias("Filter", FilterFacade::class);

  }

  public function boot()
    {
        $this->app->bind(ResourceRegistrar::class, function ($app) {
              return new CustomResourceRegistrar($app["router"]);
            });


      $this->app->booted(function () {
        add_action(BASE_ACTION_META_BOXES, [MetaBox::class, "doMetaBoxes"], 8, 2);
        $this->app->register(MailConfigServiceProvider::class);
      });

          $this->app->register(AuthServiceProvider::class);
          $this->app->register(CommandServiceProvider::class);
          $this->app->register(EventServiceProvider::class);
          $this->app->register(FormServiceProvider::class);
          $this->app->register(RouteServiceProvider::class);


          $this->app->bind(
            "Modules\Base\Repositories\MetaBoxInterface",
            "Modules\Base\Repositories\Eloquent\MetaBoxRepository"
          );

          $this->app->singleton(ExceptionHandler::class, Handler::class);


    }


  /**
   * Get the services provided by the provider.
   *
   * @return array
   */
  public function provides()
  {
    return [BreadcrumbsManager::class];
  }
}
