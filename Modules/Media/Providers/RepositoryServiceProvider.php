<?php namespace Modules\Media\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;

class RepositoryServiceProvider extends ServiceProvider
{


    public function register()
    {
		$this->app->bind(
            'Modules\Media\Repositories\MediaFileInterface',
            'Modules\Media\Repositories\Eloquent\MediaFileRepository'
        );

        $this->app->bind(
            'Modules\Media\Repositories\MediaFolderInterface',
            'Modules\Media\Repositories\Eloquent\MediaFolderRepository'
        );
        
        $this->app->bind(
            'Modules\Media\Repositories\MediaSettingInterface',
            'Modules\Media\Repositories\Eloquent\MediaSettingRepository'
        );

       
    }
}