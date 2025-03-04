<?php

namespace Modules\Page\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Arrilot\Widgets\AbstractWidget;
use Illuminate\Routing\Events\RouteMatched;
use Modules\Base\Traits\LoadDataTrait;
use Modules\Base\Supports\Helper;
use Event;

class PageServiceProvider extends ServiceProvider
{
    use LoadDataTrait;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        Helper::autoload(__DIR__ . '/../Helpers');

    }

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->register(RepositoryServiceProvider::class);

        $this->setNamespace('Page')
            ->loadAndPublishConfigurations(['config'])
            ->loadAndPublishPermissions()
            ->loadAndPublishTranslations()
            ->loadWidgets()
            ->loadAndPublishViews()
            ->loadMigrations();


        //  Event::listen(RouteMatched::class, function () {
        //     panel_menu()->registerItem([
        //         'id'          => 'cms-core-page',
        //         'priority'    => 2,
        //         'parent_id'   => null,
        //         'name'        => 'Pages',
        //         'icon'        => 'icon-doc',
        //         'url'         => route('page.index'),
        //         'permissions' => ['page.index'],
        //     ])
        //     ->registerItem([
        //          'id'          => 'cms-plugins-page-list',
        //          'priority'    => 1,
        //          'parent_id'   => 'cms-core-page',
        //          'name'        => 'Danh sách Trang',
        //          'icon'        => null,
        //          'url'         => route('page.index'),
        //          'permissions' => ['page.index'],
        //         ])
        //     ->registerItem([
        //          'id'          => 'cms-plugins-page-create',
        //          'priority'    => 2,
        //          'parent_id'   => 'cms-core-page',
        //          'name'        => 'Thêm Trang',
        //          'icon'        => null,
        //          'url'         => route('page.create'),
        //          'permissions' => ['page.create'],
        //         ]);

        // });


        $this->app->register(RouteServiceProvider::class);

        $this->app->register(HookServiceProvider::class);

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
