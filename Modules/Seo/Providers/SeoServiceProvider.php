<?php

namespace Modules\Seo\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Routing\Events\RouteMatched;
use Modules\Base\Traits\LoadDataTrait;
use Modules\Base\Supports\Helper;
use Modules\Seo\Contracts\SeoHelperContract;
use Modules\Seo\Contracts\SeoMetaContract;
use Modules\Seo\Contracts\SeoOpenGraphContract;
use Modules\Seo\Contracts\SeoTwitterContract;
use Modules\Seo\SeoHelper;
use Modules\Seo\SeoMeta;
use Modules\Seo\SeoOpenGraph;
use Modules\Seo\SeoTwitter;
use Event;

class SeoServiceProvider extends ServiceProvider
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


       $this->setNamespace('Seo')
       		->loadAndPublishConfigurations(['config'])
            ->loadAndPublishPermissions()
       		->loadAndPublishTranslations()
       		->loadAndPublishViews()
       		->loadMigrations();

        $this->app->bind(SeoMetaContract::class, SeoMeta::class);
            $this->app->bind(SeoHelperContract::class, SeoHelper::class);
            $this->app->bind(SeoOpenGraphContract::class, SeoOpenGraph::class);
            $this->app->bind(SeoTwitterContract::class, SeoTwitter::class);


            $this->app->register(RepositoryServiceProvider::class);
            $this->app->register(EventServiceProvider::class);
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
