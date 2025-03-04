<?php
use Modules\Theme\Facades\ThemeOptionFacade;

if (!function_exists("themes")) {
  /**
   * Generate an asset path for the theme.
   *
   * @param string $path
   * @param bool   $secure
   *
   * @return string
   */
  function themes($path, $secure = null)
  {
    return Theme::assets($path, $secure);
  }
}

if (!function_exists("theme_folder_path")) {
  /**
   * @return string
   *
   */
  function theme_folder_path($path = null)
  {
    return base_path("Themes" . DIRECTORY_SEPARATOR . $path);
  }
}

if (!function_exists("theme_path")) {
  /**
   * @return string
   *
   */
  function theme_path($path = null)
  {
    return base_path("Themes" . DIRECTORY_SEPARATOR . $path);
  }
}

if (!function_exists("theme_option")) {
  /**
   * @return mixed
   *
   */
  function theme_option($key = null, $default = "")
  {
    if (!empty($key)) {
      try {
        return ThemeOption::getOption($key, $default);
      } catch (FileNotFoundException $exception) {
        info($exception->getMessage());
      }
    }

    return ThemeOptionFacade::getFacadeRoot();
  }
}

if (!function_exists("sanitize_html_class")) {
  /**
   * @param $class
   * @param string $fallback
   * @return mixed
   */
  function sanitize_html_class($class, $fallback = "")
  {
    //Strip out any % encoded octets
    $sanitized = preg_replace("|%[a-fA-F0-9][a-fA-F0-9]|", "", $class);

    //Limit to A-Z,a-z,0-9,_,-
    $sanitized = preg_replace("/[^A-Za-z0-9_-]/", "", $sanitized);

    if ("" == $sanitized && $fallback) {
      return sanitize_html_class($fallback);
    }
    /**
     * Filters a sanitized HTML class string.
     *
     * @param string $sanitized The sanitized HTML class.
     * @param string $class HTML class before sanitization.
     * @param string $fallback The fallback string.
     * @since 2.8.0
     *
     */
    return apply_filters("sanitize_html_class", $sanitized, $class, $fallback);
  }
}

if (!function_exists("parse_args")) {
  /**
   * @param $args
   * @param string $defaults
   * @return array
   */
  function parse_args($args, $defaults = "")
  {
    if (is_object($args)) {
      $result = get_object_vars($args);
    } else {
      $result = &$args;
    }

    if (is_array($defaults)) {
      return array_merge($defaults, $result);
    }

    return $result;
  }
}
