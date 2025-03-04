<?php

namespace Modules\Media\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Routing\Events\RouteMatched;
use Modules\Base\Traits\LoadDataTrait;
use Event;
use Modules\Base\Supports\Helper;
use Modules\Media\Facades\LouisMediaFacade;
use Illuminate\Foundation\AliasLoader;
use Assets;
use Illuminate\Support\Facades\URL;
use LouisMedia;

class MediaServiceProvider extends ServiceProvider
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

        $this->setNamespace('Media')
            ->loadAndPublishConfigurations(['config'])
            ->loadAndPublishPermissions()
            ->loadAndPublishTranslations()
            ->loadAndPublishViews()
            ->loadMigrations();

        if (is_backend()) {
            Assets::addJs(URL::asset('/vendor/core/modules/media/js/core.js'));
        }

        if (!class_exists('LouisMedia')) {
            AliasLoader::getInstance()->alias('LouisMedia', LouisMediaFacade::class);
        }

        //     Event::listen(RouteMatched::class, function () {
        //        panel_menu()->registerItem([
        //            'id'          => 'cms-plugins-media',
        //            'priority'    => 5,
        //            'parent_id'   => null,
        //            'name'        => 'Media',
        //            'icon'        => 'fa fa-images',
        //            'url'         => route('media.index'),
        //            'permissions' => ['media.index'],
        //        ]);

        //    });

        $this->app->register(RouteServiceProvider::class);
        $this->app->register(RepositoryServiceProvider::class);
        // $this->app->register(HookServiceProvider::class);


        $config = $this->app->make('config');

        $config->set([
            // 'filesystems.default' => setting('media_driver', 'public'),
            'filesystems.default' => setting('media_driver', 'public'),
            'filesystems.disks.public.throw' => true,
        ]);


        LouisMedia::setS3Disk([
            'key' => setting('media_aws_access_key_id', $config->get('filesystems.disks.s3.key')),
            'secret' => setting('media_aws_secret_key', $config->get('filesystems.disks.s3.secret')),
            'region' => setting('media_aws_default_region', $config->get('filesystems.disks.s3.region')),
            'bucket' => setting('media_aws_bucket', $config->get('filesystems.disks.s3.bucket')),
            'url' => setting('media_aws_url', $config->get('filesystems.disks.s3.url')),
            'endpoint' => setting('media_aws_endpoint', $config->get('filesystems.disks.s3.endpoint')) ?: null,
            'use_path_style_endpoint' => setting('filesystems.disks.s3.use_path_style_endpoint'),
        ]);

        LouisMedia::setDoSpacesDisk([
            'key' => setting('media_do_spaces_access_key_id'),
            'secret' => setting('media_do_spaces_secret_key'),
            'region' => setting('media_do_spaces_default_region'),
            'bucket' => setting('media_do_spaces_bucket'),
            'endpoint' => setting('media_do_spaces_endpoint'),
        ]);

        if (setting('media_driver', 'public') == 'cloudinary') {
            LouisMedia::setCloudinaryDisk([
                'key' => setting('cloudinary_api_key'),
                'secret' => setting('cloudinary_api_secret'),
                'name' => setting('cloudinary_cloud_name'),
                'secure' => setting('cloudinary_secure')
            ]);
        }
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
