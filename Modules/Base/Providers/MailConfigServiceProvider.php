<?php

namespace Modules\Base\Providers;

use Illuminate\Support\ServiceProvider;
use Config;

class MailConfigServiceProvider extends ServiceProvider
{
  /**
   * Bootstrap the application services.
   *
   * @return void
   */
  public function boot()
  {
     //return account_sending_email_setting();
    $config = [
      'driver' => 'smtp',
      'host' => setting('email_host'),
      'port' => setting('email_port'),
      'from' => [
        'address' => setting('email_from_address'),
        'name' => setting('email_from_name'),
      ],
      'encryption' => setting('email_encryption'),
      'username' => setting('email_username'),
      'password' => setting('email_password'),
      'sendmail' => '/usr/sbin/sendmail -bs',
      'pretend' => false,
    ];
    Config::set('mail', $config);
  }
}
