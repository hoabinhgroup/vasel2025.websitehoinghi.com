<?php

namespace Modules\Analytics\Widgets;

use Modules\Base\Widgets\BaseAbstractWidget;
use Modules\Analytics\Exceptions\InvalidConfiguration;
use Modules\Analytics\Period;
use Modules\Base\Http\Responses\BaseHttpResponse;
use Analytics;
use Carbon\Carbon;
use Exception;
use Throwable;

class AdminTopReferrerWidget extends BaseAbstractWidget
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

    return view("analytics::widgets.admin_top_referrer_widget", [
      "config" => $this->config,
    ]);
  }
}
