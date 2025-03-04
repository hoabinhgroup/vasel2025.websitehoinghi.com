<?php
	namespace Modules\Acl\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;

class RepositoryServiceProvider extends ServiceProvider
{


    public function register()
    {
		  $this->app->bind(
            'Modules\Acl\Repositories\UserInterface',
            'Modules\Acl\Repositories\Eloquent\UserRepository'
            );

			$this->app->bind(
            'Modules\Acl\Repositories\UserGroupInterface',
            'Modules\Acl\Repositories\Eloquent\UserGroupRepository'
            );
    }
}
