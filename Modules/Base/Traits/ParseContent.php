<?php

namespace Modules\Base\Traits;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

/**
 * @mixin ServiceProvider
 */
trait ParseContent
{
  /**
   * @param string $namespace
   * @return $this
   */
  public function parseContent($template, $array)
  {
    $template = htmlspecialchars_decode($template, ENT_QUOTES);
    $template = preg_replace_callback(
      "#{([a-z_]+)}#i",
      function ($data) use ($array) {
        return isset($array[$data[1]]) ? $array[$data[1]] : $data[1];
      },
      $template
    );
    return $template;
  }
}
