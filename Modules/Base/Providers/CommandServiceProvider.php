<?php

namespace Modules\Base\Providers;

use Modules\Base\Console\ModuleCreateCommand;
use Illuminate\Support\ServiceProvider;

class CommandServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                ModuleCreateCommand::class
            ]);
        }
    }
}
