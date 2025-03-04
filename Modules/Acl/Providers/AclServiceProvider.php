<?php

namespace Modules\Acl\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Routing\Events\RouteMatched;
use Modules\Base\Traits\LoadDataTrait;
use Modules\Base\Supports\Helper;
use Event;

class AclServiceProvider extends ServiceProvider
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
    $this->setNamespace("Acl")
      ->loadAndPublishConfigurations(["config"])
      ->loadAndPublishPermissions()
      ->loadAndPublishTranslations()
      ->loadAndPublishViews()
      ->loadWidgets()
      ->loadMigrations();

    $this->app->register(RouteServiceProvider::class);
        $this->app->register(RepositoryServiceProvider::class);

        Event::listen(RouteMatched::class, function () {
          panel_menu()
            ->registerItem([
              "id" => "cms-core-acl",
              "priority" => 8,
              "parent_id" => null,
              "name" => "Users",
              "icon" => "ft-users",
              "url" => route("user.index"),
              "permissions" => ["user.index"],
            ])
            ->registerItem([
              "id" => "cms-core-users",
              "priority" => 1,
              "parent_id" => "cms-core-acl",
              "name" => "Quản lý Users",
              "icon" => null,
              "url" => route("user.index"),
              "permissions" => ["user.index"],
            ])
            ->registerItem([
              "id" => "cms-core-group-and-permission",
              "priority" => 2,
              "parent_id" => "cms-core-acl",
              "name" => "Nhóm và phân quyền",
              "icon" => null,
              "url" => route("user-group.index"),
              "permissions" => ["user-group.index"],
            ])
            ->registerItem([
              "id" => "cms-core-user-create",
              "priority" => 3,
              "parent_id" => "cms-core-acl",
              "name" => "Thêm User",
              "icon" => null,
              "url" => route("user.create"),
              "permissions" => ["user.create"],
            ]);
        });

    add_action(WIDGET_LIST, [$this, "registerWidgetList"], 3);
  }


  public function registerWidgetList($template_id)
  {
    return displayWidgetListByModule(ACL_SCREEN, $template_id);
  }
}
