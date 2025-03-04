<?php

namespace Modules\Page\Widgets;

use Modules\Base\Widgets\BaseAbstractWidget;

class AdminRecentPageWidget extends BaseAbstractWidget
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

    return view("page::widgets.admin_recent_page_widget", [
      "config" => $this->config,
    ]);
  }
}
