<?php

namespace Modules\Sitemap\Providers;

use Modules\Base\Events\CreatedContentEvent;
use Modules\Base\Events\DeletedContentEvent;
use Modules\Base\Events\UpdatedContentEvent;
use Illuminate\Support\ServiceProvider;
use Modules\Base\Traits\LoadDataTrait;
use Modules\Sitemap\Sitemap;
use Illuminate\Support\Facades\Event;

class SitemapServiceProvider extends ServiceProvider
{
	use LoadDataTrait;

    protected $defer = true;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('sitemap', function ($app) {
            $config = config('sitemap');

            return new Sitemap(
                $config,
                $app['Illuminate\Cache\Repository'],
                $app['config'],
                $app['files'],
                $app['Illuminate\Contracts\Routing\ResponseFactory'],
                $app['view']
            );
        });

        $this->app->alias('sitemap', Sitemap::class);       

    }

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {

       $this->setNamespace('Sitemap')
       		->loadAndPublishConfigurations(['config'])
            ->loadAndPublishPermissions()
       		->loadAndPublishViews();

        Event::listen(CreatedContentEvent::class, function () {
                cache()->forget('public.sitemap');
            });
    
        Event::listen(UpdatedContentEvent::class, function () {
                cache()->forget('public.sitemap');
            });
    
        Event::listen(DeletedContentEvent::class, function () {
                cache()->forget('public.sitemap');
            });

    }


    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['sitemap', Sitemap::class];
    }
}
