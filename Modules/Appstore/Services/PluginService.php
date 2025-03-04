<?php

namespace Modules\Appstore\Services;

use Modules\Base\Supports\Helper;
//use Modules\Setting\Supports\SettingStore;
use Composer\Autoload\ClassLoader;
use DB;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Application;
use Illuminate\Support\Arr;
use Schema;
use Module;
use Artisan;

class PluginService
{
  /**
   * @var Application
   */
  public $app;

  /**
   * @var SettingStore
   */
  //public $settingStore;

  /**
   * @var Filesystem
   */
  public $files;

  /**
   * PluginService constructor.
   * @param Application $app
   * @param SettingStore $settingStore
   * @param Filesystem $files
   */
  public function __construct(Application $app, Filesystem $files)
  {
    $this->app = $app;
    $this->files = $files;
  }

  /**
   * @param string $plugin
   * @return array
   * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
   */
  public function activate(string $plugin): array
  {
    $validate = $this->validate($plugin);

    if ($validate["error"]) {
      return $validate;
    }

    $content = get_file_data(plugin_path($plugin) . "/module.json");
    if (empty($content)) {
      return [
        "error" => true,
        "message" => __("Invalid module.json!"),
      ];
    }

    $activatedPlugins = get_active_plugins();

    if (!in_array($plugin, $activatedPlugins)) {
      //active
      $module = Module::find($plugin);
      $module->enable();
      $this->publishAssets($plugin);

      if (
        $this->files->isDirectory(plugin_path($plugin . "/Database/Migrations"))
      ) {
        // $this->app
        //   ->make("migrator")
        //   ->run(plugin_path($plugin . "/Database/Migrations"));

        Artisan::call("module:migrate " . $plugin, [
           '--force' => true
        ]);
      }

      //Artisan::call('optimize');
      Helper::clearCache();

      return [
        "error" => false,
        "message" => __("Activate plugin successfully!"),
      ];
    }

    return [
      "error" => true,
      "message" => __("This plugin is activated already!"),
    ];
  }

  /**
   * @param string $plugin
   * @return array
   * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
   */
  protected function validate(string $plugin): array
  {
    $location = plugin_path($plugin);

    if (!$this->files->isDirectory($location)) {
      return [
        "error" => true,
        "message" => __("This plugin is not exists."),
      ];
    }

    if (!$this->files->exists($location . "/module.json")) {
      return [
        "error" => true,
        "message" => __("Missing file module.json!"),
      ];
    }

    return [
      "error" => false,
      "message" => __("Plugin is valid!"),
    ];
  }

  /**
   * @param string $plugin
   * @return array
   */
  public function publishAssets(string $plugin): array
  {
    $validate = $this->validate($plugin);

    if ($validate["error"]) {
      return $validate;
    }

    if ($this->files->isDirectory(plugin_path($plugin . "/Public"))) {
      $this->files->copyDirectory(
        plugin_path($plugin . "/Public"),
        public_path("vendor/core/modules/" . strtolower($plugin))
      );
    }

    return [
      "error" => false,
      "message" => __("Publish assets for plugin :name successfully!", [
        "name" => $plugin,
      ]),
    ];
  }

  /**
   * @param string $plugin
   * @return array
   * @throws FileNotFoundException
   */
  public function remove(string $plugin): array
  {
    $validate = $this->validate($plugin);

    if ($validate["error"]) {
      return $validate;
    }

    $this->deactivate($plugin);

    $location = plugin_path($plugin);

    if ($this->files->exists($location . "/module.json")) {
      $content = get_file_data($location . "/module.json");
      if (!empty($content)) {
        Artisan::call("module:migrate-rollback " . $plugin);
      }
    }

    $migrations = [];
    foreach (scan_folder($location . "/Database/Migrations") as $file) {
      $migrations[] = pathinfo($file, PATHINFO_FILENAME);
    }

    DB::table("migrations")
      ->whereIn("migration", $migrations)
      ->delete();

    $this->files->deleteDirectory($location);

    if (empty($this->files->directories(plugin_path()))) {
      $this->files->deleteDirectory(plugin_path());
    }

    Helper::removeModuleFiles($plugin, "modules");

    Helper::clearCache();

    return [
      "error" => false,
      "message" => __("Plugin is removed!"),
    ];
  }

  /**
   * @param string $plugin
   * @return array
   * @throws FileNotFoundException
   */
  public function deactivate(string $plugin): array
  {
    $validate = $this->validate($plugin);

    if ($validate["error"]) {
      return $validate;
    }

    $content = get_file_data(plugin_path($plugin) . "/module.json");
    if (empty($content)) {
      return [
        "error" => true,
        "message" => __("Invalid module.json!"),
      ];
    }

    $module = Module::find($plugin);
    $module->disable();

    Helper::clearCache();

    return [
      "error" => true,
      "message" => __("This plugin is deactivated already!"),
    ];
  }
}
