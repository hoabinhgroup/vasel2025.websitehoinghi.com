<?php

namespace Modules\Template\Providers;

use Modules\Template\Console\CreateWidgetCommand;
use Illuminate\Support\ServiceProvider;

class CommandServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                CreateWidgetCommand::class,
            ]);
        }
    }
}
