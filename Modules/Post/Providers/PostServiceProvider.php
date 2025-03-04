<?php

namespace Modules\Post\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Routing\Events\RouteMatched;
use Modules\Base\Traits\LoadDataTrait;
use Modules\Base\Supports\Helper;
use Modules\Post\Entities\Post;
use Modules\Post\Entities\Categories;
use Modules\Post\Entities\Tag;
use Event;
use SeoHelper;

class PostServiceProvider extends ServiceProvider
{
  use LoadDataTrait;
  /**
   * Boot the application events.
   *
   * @return void
   */

  public function register()
  {
    Helper::autoload(__DIR__ . '/../Helpers');

  }

  public function boot()
  {
    $this->setNamespace('Post')
      ->loadAndPublishConfigurations(['config'])
      ->loadAndPublishPermissions()
      ->loadAndPublishTranslations()
      ->loadAndPublishViews()
      ->loadMigrations();



    $this->app->booted(function () {
      $models = [Post::class, Categories::class, Tag::class];

      if (defined('LANG_NAME')) {
        \Language::registerModule($models);
      }
      \Slug::registerModule($models);

      SeoHelper::registerModule($models);
    });

    $this->app->register(RouteServiceProvider::class);
    $this->app->register(RepositoryServiceProvider::class);
    $this->app->register(HookServiceProvider::class);
    $this->app->register(EventServiceProvider::class);

    Event::listen(RouteMatched::class, function () {
      panel_menu()
        ->registerItem([
          'id' => 'cms-plugins-post',
          'priority' => 1,
          'parent_id' => null,
          'name' => 'Post::post.name',
          'icon' => 'fa fa-edit',
          'url' => route('post.index'),
          'permissions' => ['post.index'],
        ])
        ->registerItem([
          'id' => 'cms-plugins-post-list',
          'priority' => 1,
          'parent_id' => "cms-plugins-post",
          'name' => 'Post::post.name',
          'icon' => '',
          'url' => route('post.index'),
          'permissions' => ['post.index'],
        ])
        ->registerItem([
          'id' => 'cms-plugins-categories',
          'priority' => 1,
          'parent_id' => "cms-plugins-post",
          'name' => 'Post::categories.name',
          'icon' => '',
          'url' => route('categories.index'),
          'permissions' => ['categories.index'],
        ])
        ->registerItem([
          'id' => 'cms-plugins-tags',
          'priority' => 1,
          'parent_id' => "cms-plugins-post",
          'name' => 'Post::tag.name',
          'icon' => '',
          'url' => route('tag.index'),
          'permissions' => ['tag.index'],
        ]);
    });
  }

  /**
   * Register the service provider.
   *
   * @return void
   */


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
