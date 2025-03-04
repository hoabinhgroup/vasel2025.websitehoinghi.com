<?php

namespace Modules\Analytics\Providers;

use Modules\Analytics\Analytics;
use Modules\Analytics\AnalyticsClient;
use Modules\Analytics\AnalyticsClientFactory;
use Modules\Analytics\Facades\AnalyticsFacade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Routing\Events\RouteMatched;
use Modules\Base\Traits\LoadDataTrait;
use Event;
use Illuminate\Foundation\AliasLoader;
use Modules\Base\Supports\Helper;
use Modules\Analytics\Exceptions\InvalidConfiguration;

class AnalyticsServiceProvider extends ServiceProvider
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
    $this->setNamespace("Analytics")
      ->loadAndPublishConfigurations(["config"])
      ->loadAndPublishPermissions()
      ->loadAndPublishTranslations()
      ->loadWidgets()
      ->loadAndPublishViews();

    $this->app->bind(AnalyticsClient::class, function () {
      return AnalyticsClientFactory::createForConfig(config("analytics"));
    });

    $this->app->bind(Analytics::class, function () {
      if (empty(setting("analytics_view_id", config("analytics.view_id")))) {
        throw InvalidConfiguration::viewIdNotSpecified();
      }

      if (!setting("analytics_service_account_credentials")) {
        throw InvalidConfiguration::credentialsIsNotValid();
      }

      return new Analytics(
        $this->app->make(AnalyticsClient::class),
        setting("analytics_view_id", config("analytics.view_id"))
      );
    });

    $this->app->register(RouteServiceProvider::class);
    $this->app->register(HookServiceProvider::class);

    AliasLoader::getInstance()->alias("Analytics", AnalyticsFacade::class);
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
