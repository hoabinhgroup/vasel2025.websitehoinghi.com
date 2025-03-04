<?php

namespace Modules\Registration\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;

class RepositoryServiceProvider extends ServiceProvider
{


  public function register()
  {
    $this->app->bind(
      'Modules\Registration\Repositories\RegistrationInterface',
      'Modules\Registration\Repositories\Eloquent\RegistrationRepository'
    );

    $this->app->bind(
      'Modules\Registration\Repositories\AbstractSubmissionInterface',
      'Modules\Registration\Repositories\Eloquent\AbstractSubmissionRepository'
    );

    $this->app->bind(
      'Modules\Registration\Repositories\VsaRegistrationInterface',
      'Modules\Registration\Repositories\Eloquent\VsaRegistrationRepository'
    );

    $this->app->bind(
      'Modules\Registration\Repositories\FacultyInterface',
      'Modules\Registration\Repositories\Eloquent\FacultyRepository'
    );

    $this->app->bind(
      'Modules\Registration\Repositories\FullpaperSubmissionInterface',
      'Modules\Registration\Repositories\Eloquent\FullpaperSubmissionRepository'
    );
  }
}
