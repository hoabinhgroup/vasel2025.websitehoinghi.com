<?php namespace Modules\Member\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;

class RepositoryServiceProvider extends ServiceProvider
{


    public function register()
    {
		  $this->app->bind(
            'Modules\Member\Repositories\MemberInterface',
            'Modules\Member\Repositories\Eloquent\MemberRepository'
            );

       
    }
}