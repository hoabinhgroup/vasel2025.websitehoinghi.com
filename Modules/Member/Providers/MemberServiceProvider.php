<?php

namespace Modules\Member\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Routing\Events\RouteMatched;
use Modules\Base\Traits\LoadDataTrait;
use Modules\Member\Entities\Member;
use Event;
use Modules\Base\Supports\Helper;

class MemberServiceProvider extends ServiceProvider
{
	use LoadDataTrait;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        config([
          'auth.guards.member' => [
            'driver' => 'session',
            'provider' => 'members',
          ],
          'auth.providers.members' => [
            'driver' => 'eloquent',
            'model' => Member::class,
          ],
          'auth.passwords.members' => [
            'provider' => 'members',
            'table' => 'member_password_resets',
            'expire' => 60,
          ],
          'auth.guards.member-api' => [
            'driver' => 'passport',
            'provider' => 'members',
          ],
        ]);
         Helper::autoload(__DIR__ . '/../Helpers');

    }

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {

       $this->setNamespace('Member')
       		->loadAndPublishConfigurations(['config'])
            ->loadAndPublishPermissions()
       		->loadAndPublishTranslations()
       		->loadAndPublishViews()
       		->loadMigrations();

            $this->app->register(RouteServiceProvider::class);
            $this->app->register(RepositoryServiceProvider::class);
            $this->app->register(EventServiceProvider::class);
          // $this->app->register(HookServiceProvider::class);

            Event::listen(RouteMatched::class, function () {
               panel_menu()->registerItem([
                   'id'          => 'cms-plugins-member',
                   'priority'    => 5,
                   'parent_id'   => null,
                   'name'        => 'member::member.name',
                   'icon'        => 'icon-doc',
                   'url'         => route('member.index'),
                   'permissions' => ['member.index'],
               ]);

           });
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
