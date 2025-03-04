<?php

namespace Modules\Registration\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Routing\Events\RouteMatched;
use Modules\Base\Traits\LoadDataTrait;
use Modules\Registration\Entities\AbstractSubmission;
use Modules\Registration\Entities\Registration;
use Modules\Registration\Entities\Invited;
use Modules\Registration\Entities\Observers\AbstractSubmissionObserver;
use Modules\Registration\Entities\Observers\InvitedObserver;
use Modules\Registration\Entities\Observers\RegistrationObserver;
use Event;
use Form;
use Illuminate\Support\Arr;
use Modules\AbstractScore\Entities\AbstractScore;
use Modules\Acl\Entities\Users;
use Modules\Base\Supports\Helper;
use Modules\Payment\Enums\PaymentMethodEnum;
use Modules\Registration\Events\NotificationAfterSubmit;

class RegistrationServiceProvider extends ServiceProvider
{
  use LoadDataTrait;

  /**
   * Register the service provider.
   *
   * @return void
   */
  public function register()
  {
    Helper::autoload(__DIR__ . '/../Helpers');
  }

  /**
   * Boot the application events.
   *
   * @return void
   */
  public function boot()
  {

    $this->setNamespace('Registration')
      ->loadAndPublishConfigurations(['config'])
      ->loadAndPublishPermissions()
      ->loadAndPublishTranslations()
      ->loadAndPublishViews()
      ->loadMigrations();


    $this->app->register(RouteServiceProvider::class);
    $this->app->register(RepositoryServiceProvider::class);
    $this->app->register(EventServiceProvider::class);
    $this->app->register(FormServiceProvider::class);
    // $this->app->register(HookServiceProvider::class);

    add_action(
      BASE_FILTER_EMAIL_AFTER_SETTING_CONTENT,
      [$this, "addSettings"],
      301,
      1
    );

    Event::listen(RouteMatched::class, function () {
      panel_menu()->registerItem([
        'id' => 'cms-plugins-registration',
        'priority' => 5,
        'parent_id' => null,
        'name' => 'registration::registration.name',
        'icon' => 'ft-users',
        'url' => route('registration.index'),
        'permissions' => ['registration.index'],
      ]);

      panel_menu()->registerItem([
        'id' => 'cms-plugins-speaker',
        'priority' => 0,
        'parent_id' => 'cms-plugins-registration',
        'name' => 'Speaker',
        'icon' => 'ft-users',
        'url' => route('speaker.registration.index'),
        'permissions' => ['registration.index'],
      ]);

      panel_menu()->registerItem([
        'id' => 'cms-plugins-speaker-vn',
        'priority' => 1,
        'parent_id' => 'cms-plugins-registration',
        'name' => 'Speaker VN',
        'icon' => 'ft-users',
        'url' => route('speakervn.registration.index'),
        'permissions' => ['registration.index'],
      ]);

      panel_menu()->registerItem([
        'id' => 'cms-plugins-invitee',
        'priority' => 2,
        'parent_id' => 'cms-plugins-registration',
        'name' => 'Invitee',
        'icon' => 'ft-users',
        'url' => route('invitee.registration.index'),
        'permissions' => ['registration.index'],
      ]);

      panel_menu()->registerItem([
        'id' => 'cms-plugins-invitee-vn',
        'priority' => 3,
        'parent_id' => 'cms-plugins-registration',
        'name' => 'Invitee VN',
        'icon' => 'ft-users',
        'url' => route('inviteevn.registration.index'),
        'permissions' => ['registration.index'],
      ]);
    });


    if (defined('PAYMENT_ACTION_PAYMENT_PROCESSED')) {
      add_action(PAYMENT_ACTION_PAYMENT_PROCESSED, function ($data) {

        switch ($data['payment_method']) {
          case PaymentMethodEnum::ONEPAY_PAYMENT:
            $data['payment_status'] = 'Pending';
            event(new NotificationAfterSubmit($data));
            break;
          case PaymentMethodEnum::BANK_TRANSFER:
            // Nếu bank transfer xử lý
            event(new NotificationAfterSubmit($data));
            break;
          default:
            // Nếu bank transfer xử lý
            event(new NotificationAfterSubmit($data));
            break;
        }
      }, 123);
    }
  }


  public function addSettings($data = null)
  {
    echo $data . view("registration::email.setting")->render();
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
