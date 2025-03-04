<?php

namespace Modules\Notification\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Eloquent;


class HookServiceProvider extends ServiceProvider
{
	
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function boot()
    {
	   
        add_action(BASE_FILTER_AFTER_SETTING_CONTENT, [$this, 'addSettings'], 301, 1);  
     
    }
    
       
    
    public function addSettings($data = null)
    {
	 	    
	    echo $data  . view('notification::telegram.setting')->render();
	    
    }
  
}