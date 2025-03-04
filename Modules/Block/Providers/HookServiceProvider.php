<?php

namespace Modules\Block\Providers;

use Modules\Block\Repositories\BlockInterface;
use Illuminate\Support\ServiceProvider;

class HookServiceProvider extends ServiceProvider
{
  public function boot()
  {
    if (function_exists("shortcode")) {
      add_shortcode(
        "static-block",
        trans("block::block.static_block_short_code_name"),
        trans("block::block.static_block_short_code_description"),
        [$this, "render"]
      );

      shortcode()->setAdminConfig(
        "static-block",
        view("block::partials.short-code-admin-config")->render()
      );
    }
  }

  /**
   * @param \stdClass $shortcode
   * @return null
   * @throws \Illuminate\Contracts\Container\BindingResolutionException
   */
  public function render($shortcode)
  {
    $block = $this->app->make(BlockInterface::class)->getFirstBy([
      "alias" => $shortcode->alias,
      "status" => 1,
    ]);

    if (empty($block)) {
      return null;
    }

    return $block->content;
  }
}
