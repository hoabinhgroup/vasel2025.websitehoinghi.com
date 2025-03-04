<?php

namespace Modules\Appstore\Widgets;

use Modules\Base\Widgets\BaseAbstractWidget;

class AdminDashboardPluginCountWidget extends BaseAbstractWidget
{
  /**
   * The configuration array.
   *
   * @var array
   */
  protected $config = [];

  public function run()
  {
    return view("appstore::widgets.admin_dashboard_plugin_count_widget", [
      "config" => $this->config,
    ]);
  }
}
