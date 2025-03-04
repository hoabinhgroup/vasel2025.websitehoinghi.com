<?php namespace Modules\Post\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;

class RepositoryServiceProvider extends ServiceProvider
{


    public function register()
    {
		 $this->app->bind(
            'Modules\Post\Repositories\PostInterface',
            'Modules\Post\Repositories\Eloquent\PostRepository'
            );
            
         $this->app->bind(
            'Modules\Post\Repositories\CategoriesInterface',
            'Modules\Post\Repositories\Eloquent\CategoriesRepository'
            );

		$this->app->bind(
            'Modules\Post\Repositories\PostCategoriesInterface',
            'Modules\Post\Repositories\Eloquent\PostCategoriesRepository'
            );	
            
         $this->app->bind(
            'Modules\Post\Repositories\TagInterface',
            'Modules\Post\Repositories\Eloquent\TagRepository'
            );	
       
    }
}