<?php

namespace Modules\Base\Providers;

use Modules\Menu\Policies\CategoriesPolicy;
use Modules\Menu\Entities\Categories;


use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
	
	/*protected $policies = [
	    'Modules\Menu\Model' => 'Modules\Menu\Policies\ModelPolicy',
        Categories::class => CategoriesPolicy::class,
    ]; 
    */
    /**
     * The module namespace to assume when generating URLs to actions.
     *
     * @var string
     */
    protected $moduleNamespace = 'Modules\Base\Http\Controllers';

    /**
     * Called before routes are registered.
     *
     * Register any model bindings or pattern based filters.
     *
     * @return void
     */
    public function boot()
    {
      // $this->registerPolicies();
           
    }

}
