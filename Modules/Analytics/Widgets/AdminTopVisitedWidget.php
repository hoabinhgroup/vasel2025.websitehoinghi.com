<?php

namespace Modules\Analytics\Widgets;

use Modules\Base\Widgets\BaseAbstractWidget;

class AdminTopVisitedWidget extends BaseAbstractWidget
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

    //$this->config = $this->getTopReferrer();
    //$this->config = 123;

    return view("analytics::widgets.admin_top_visited_widget", [
      "config" => $this->config,
    ]);
  }
}
