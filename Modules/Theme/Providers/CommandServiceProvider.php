<?php

namespace Modules\Theme\Providers;

use Modules\Theme\Console\CreateThemeCommand;
use Illuminate\Support\ServiceProvider;

class CommandServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                CreateThemeCommand::class,
            ]);
        }
    }
}
