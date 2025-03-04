<?php

namespace Modules\Analytics\Providers;

use Illuminate\Support\ServiceProvider;
use Eloquent;

class HookServiceProvider extends ServiceProvider
{
  /**
   * Register the service provider.
   *
   * @return void
   */
  public function boot()
  {
    add_action(WIDGET_LIST, [$this, "registerWidgetList"], 2);
    add_action(
      BASE_FILTER_AFTER_SETTING_CONTENT,
      [$this, "addAnalyticsSetting"],
      99,
      1
    );
  }

  public function registerWidgetList($template_id)
  {
    return displayWidgetListByModule("analytics", $template_id);
  }

  public function addAnalyticsSetting($data = null)
  {
    echo $data . view("analytics::setting")->render();
  }
}
