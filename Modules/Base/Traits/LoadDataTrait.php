<?php

namespace Modules\Base\Traits;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Gate;

/**
 * @mixin ServiceProvider
 */
trait LoadDataTrait
{
    /**
     * @var string
     */
    protected $namespace = null;

    /**
     * @var string
     */
    protected $basePath = null;

    /**
     * @param string $namespace
     * @return $this
     */
    public function setNamespace(string $namespace): self
    {
        $this->namespace = ltrim(rtrim($namespace, "/"), "/");
        return $this;
    }

    /**
     * @param string $path
     * @return $this
     */
    public function setBasePath($path): self
    {
        $this->basePath = $path;
        return $this;
    }

    /**
     * @return string
     */
    public function getBasePath(): string
    {
        return $this->basePath ?? platform_path();
    }

    public function loadWidgets(): self
    {

    $module = \Module::find($this->namespace);
    $widgetPath = $module->getPath(). "/Widgets/";
      if (File::exists($widgetPath)) {
        app("arrilot.widget-namespaces")->registerNamespace(
          strtolower($this->namespace),
          "\\Modules\\$this->namespace\\Widgets"
        );
      }
        return $this;
    }

    /**
     * Publish the given configuration file name (without extension) and the given module
     * @param array|string $fileNames
     * @return $this
     */
    public function loadAndPublishConfigurations($fileNames): self
    {
        if (!is_array($fileNames)) {
            $fileNames = [$fileNames];
        }

        foreach ($fileNames as $fileName) {
            $this->mergeConfigFrom(
                $this->getConfigFilePath($fileName),
                strtolower($this->getDotedNamespace())
            );
            if ($this->app->runningInConsole()) {
                $this->publishes([
                    $this->getConfigFilePath($fileName) => config_path(
                        strtolower($this->getDotedNamespace()) . ".php"
                    ),
                ]);
            }
        }

        return $this;
    }

    public function loadAndPublishPermissions(): self
        {

             if (File::exists($this->getConfigFilePath('permissions'))
                    ) {
                      $this->mergeConfigFrom($this->getConfigFilePath('permissions'),  "permissions" );
                    }

                  if(!empty(\Config::get("permissions"))){
                     foreach (\Config::get("permissions") as $permission):
                          $role = $permission["flag"];
                          Gate::define($role, function ($user) use ($role) {
                            return $user->hasAccess([$role]);
                          });
                        endforeach;
                      }

            return $this;
        }

    /**
     * Publish the given configuration file name (without extension) and the given module
     * @param array|string $fileNames
     * @return $this
     */
    public function loadRoutes($fileNames = ["web"]): self
    {
        if (!is_array($fileNames)) {
            $fileNames = [$fileNames];
        }
        foreach ($fileNames as $fileName) {
            $this->loadRoutesFrom($this->getRouteFilePath($fileName));
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function loadAndPublishViews(): self
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                $this->getViewsPath() => resource_path(
                    "views/modules/" . strtolower($this->getDashedNamespace())
                ),
            ]);
        }

        $this->loadViewsFrom(
            array_merge(
                array_map(function ($path) {
                    return $path .
                        "/modules/" .
                        strtolower($this->getDashedNamespace());
                }, \Config::get("view.paths")),
                [$this->getViewsPath()]
            ),
            strtolower($this->getDashedNamespace())
        );

        return $this;
    }

    /**
     * @return $this
     */
    public function loadAndPublishTranslations(): self
    {
        $this->loadTranslationsFrom(
            $this->getTranslationsPath(),
            $this->getDashedNamespace()
        );
        if ($this->app->runningInConsole()) {
            $this->publishes([
                $this->getTranslationsPath() => resource_path(
                    "lang/modules/" . $this->getDashedNamespace()
                ),
            ]);
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function loadMigrations(): self
    {
        $this->loadMigrationsFrom($this->getMigrationsPath());
        return $this;
    }

    /**
     * @param string|null $path
     * @return $this
     */
    public function publishAssets($path = null): self
    {
        if ($this->app->runningInConsole()) {
            if (empty($path)) {
                $path = !Str::contains($this->getDotedNamespace(), "core.")
                    ? "vendor/core/" . $this->getDashedNamespace()
                    : "vendor/core";
            }
            $this->publishes(
                [$this->getAssetsPath() => public_path($path)],
                "cms-public"
            );
        }

        return $this;
    }

    /**
     * Get path of the give file name in the given module
     * @param string $file
     * @return string
     */
    protected function getConfigFilePath($file): string
    {
        return $this->getBasePath() .
            $this->getDashedNamespace() .
            "/Config/" .
            $file .
            ".php";
    }

    /**
     * @param string $file
     * @return string
     */
    protected function getRouteFilePath($file): string
    {
        return $this->getBasePath() .
            $this->getDashedNamespace() .
            "/Routes/" .
            $file .
            ".php";
    }

    /**
     * @return string
     */
    protected function getViewsPath(): string
    {
        return $this->getBasePath() .
            $this->getDashedNamespace() .
            "/Resources/views/";
    }

    /**
     * @return string
     */
    protected function getTranslationsPath(): string
    {
        return $this->getBasePath() .
            $this->getDashedNamespace() .
            "/Resources/lang/";
    }

    /**
     * @return string
     */
    protected function getMigrationsPath(): string
    {
        return $this->getBasePath() .
            $this->getDashedNamespace() .
            "/Database/Migrations/";
    }

    /**
     * @return string
     */
    protected function getAssetsPath(): string
    {
        return $this->getBasePath() . $this->getDashedNamespace() . "/public/";
    }

    /**
     * @return string
     */
    protected function getDotedNamespace(): string
    {
        return str_replace("/", ".", $this->namespace);
    }

    /**
     * @return string
     */
    protected function getDashedNamespace(): string
    {
        return str_replace(".", "/", $this->namespace);
    }
}
