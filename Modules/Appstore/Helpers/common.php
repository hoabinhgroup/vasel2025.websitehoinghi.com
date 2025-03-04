<?php

if (!defined("APPSTORE_SCREEN")) {
  define("APPSTORE_SCREEN", "appstore");
}

if (!function_exists("plugin_path")) {
  /**
   * @return string
   *
   */
  function plugin_path($path = null)
  {
    return base_path("Modules" . DIRECTORY_SEPARATOR . $path);
  }
}

if (!function_exists("is_plugin_active")) {
  /**
   * @param $alias
   * @return bool
   * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
   */
  function is_plugin_active($alias)
  {
    $path = plugin_path($alias);

    if (in_array($alias, Module::collections()->toArray())) {
      $active = true;
    } else {
      $active = false;
    }

    return $active;
  }
}

if (!function_exists("is_module_active")) {
  /**
   * @param $alias
   * @return bool
   * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
   */
  function is_module_active($alias)
  {
    $path = plugin_path($alias);

    if (in_array($alias, Module::collections()->toArray())) {
      $active = true;
    } else {
      $active = false;
    }

    return $active;
  }
}

if (!function_exists("get_active_plugins")) {
  /**
   * @return array
   */
  function get_active_plugins()
  {
    return Module::allEnabled();
    //return json_decode(setting('activated_plugins', '[]'), true);
  }
}
