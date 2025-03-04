<?php

namespace Modules\Acl\Widgets;

use Modules\Base\Widgets\BaseAbstractWidget;

class AdminDashboardStaffCountWidget extends BaseAbstractWidget
{
  /**
   * The configuration array.
   *
   * @var array
   */
  protected $config = [];

  public function run()
  {
    return view("acl::widgets.admin_dashboard_staff_count_widget", [
      "config" => $this->config,
    ]);
  }
}
