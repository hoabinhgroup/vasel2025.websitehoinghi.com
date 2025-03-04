<?php

namespace Modules\Page\Widgets;

use Modules\Base\Widgets\BaseAbstractWidget;

class AdminDashboardPageCountWidget extends BaseAbstractWidget
{
  /**
   * The configuration array.
   *
   * @var array
   */
  protected $config = [];

  public function run()
  {
    //

    return view("page::widgets.admin_dashboard_page_count_widget", [
      "config" => $this->config,
    ]);
  }
}
