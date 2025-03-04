<?php

namespace Modules\Analytics\Http\Controllers;

use Auth;
use Modules\Base\Http\Responses\BaseHttpResponse;
use Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Acl\Entities\Users;
use Modules\Analytics\Tables\AnalyticsTable;
use Modules\Analytics\Tables\AdminTopReferrerWidgetTable;
use Modules\Analytics\Tables\AdminTopVisitPagesWidgetTable;
use Carbon\Carbon;
use Assets;

class AnalyticsController extends Controller
{
  /**
   * @var AnalyticsInterface
   */

  public function __construct()
  {
  }

  /**
   * Display a listing of the resource.
   * @return Response
   */
  public function index(AnalyticsTable $table)
  {
    page_title()->setTitle(__("analytics::analytics.list"));
    return $table->renderTable();
  }

  public function topRererrerWidgetTable(AdminTopReferrerWidgetTable $table)
  {
    return $table->renderTable();
  }

  public function topVisitPageWidgetTable(AdminTopVisitPagesWidgetTable $table)
  {
    return $table->renderTable();
  }
}
