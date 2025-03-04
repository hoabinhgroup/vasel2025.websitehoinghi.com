<?php

namespace Modules\Theme\Widgets;

use Modules\Base\Widgets\BaseAbstractWidget;

class AdminDashboardThemeCountWidget extends BaseAbstractWidget
{
  /**
   * The configuration array.
   *
   * @var array
   */
  protected $config = [];

  public function run()
  {
    return view("theme::widgets.admin_dashboard_theme_count_widget", [
      "config" => $this->config,
    ]);
  }
}
