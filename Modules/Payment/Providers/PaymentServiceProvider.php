<?php

namespace Modules\Payment\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Modules\Base\Traits\LoadDataTrait;
use Modules\Base\Supports\Helper;
use PaymentMethods;

class PaymentServiceProvider extends ServiceProvider
{
	
	use LoadDataTrait;
    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->setNamespace('Payment')
       		->loadAndPublishConfigurations(['config'])
            ->loadAndPublishPermissions()
       		->loadAndPublishTranslations()
       		->loadAndPublishViews();

            PaymentMethods::method(ONEPAY_PAYMENT_METHOD_NAME, [
                'html' => view('payment::partials.onepay')->render(),
                'priority' => 998,
            ]);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
	    Helper::autoload(__DIR__ . '/../Helpers');
        $this->app->register(RouteServiceProvider::class);
        $this->app->register(EventServiceProvider::class);

       
        
       
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
