<?php

namespace Modules\Notification\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Routing\Events\RouteMatched;
use Modules\Base\Traits\LoadDataTrait;
use Modules\Base\Supports\Helper;
use Event;

class NotificationServiceProvider extends ServiceProvider
{
  use LoadDataTrait;
  /**
   * Boot the application events.
   *
   * @return void
   */
  public function boot()
  {
    $this->setNamespace("Notification")
      ->loadAndPublishConfigurations(["config"])
      ->loadAndPublishTranslations()
      ->loadAndPublishViews()
      ->loadMigrations();
  }

  /**
   * Register the service provider.
   *
   * @return void
   */
  public function register()
  {
    Helper::autoload(__DIR__ . "/../Helpers");
    config([
      "services.telegram-bot-api" => [
        "token" => env("TELEGRAM_BOT_TOKEN", setting("telegram_bot_token")),
      ],
      "services.telegram_id" => env("TELEGRAM_ID", setting("telegram_id")),
    ]);

    $this->app->register(RouteServiceProvider::class);
    $this->app->register(RepositoryServiceProvider::class);
    $this->app->register(HookServiceProvider::class);

    Event::listen(RouteMatched::class, function () {
      panel_menu()->registerItem([
        "id" => "cms-plugins-notification",
        "priority" => 5,
        "parent_id" => null,
        "name" => "notification::notification.name",
        "icon" => "fa fa-bell",
        "url" => route("notification.index"),
        "permissions" => ["notification.index"],
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
