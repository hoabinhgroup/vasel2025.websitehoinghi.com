<?php namespace Modules\Slider\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;

class RepositoryServiceProvider extends ServiceProvider
{
  public function register()
  {
    $this->app->bind(
      "Modules\Slider\Repositories\SliderInterface",
      "Modules\Slider\Repositories\Eloquent\SliderRepository"
    );

    $this->app->bind(
      "Modules\Slider\Repositories\SliderItemInterface",
      "Modules\Slider\Repositories\Eloquent\SliderItemRepository"
    );
  }
}
