<?php

namespace Modules\Analytics\Tables;

use Illuminate\Support\Facades\Auth;
use Modules\Base\Repositories\RepositoryInterface;
//use Modules\Acl\Entities\Users;
use Modules\Base\Table\TableAbstract;
use Modules\Analytics\Exceptions\InvalidConfiguration;
use Modules\Analytics\Period;
use Carbon\Carbon;
use Html;
use Illuminate\Contracts\Routing\UrlGenerator;
use DataTables;
use Excel;
use Analytics;

class AdminTopReferrerWidgetTable extends TableAbstract
{
  /**
   * @var bool
   */
  protected $hasActions = false;

  protected $hasOperations = false;
  /**
   * @var bool
   */
  protected $hasTab = false;
  /**
   * @var bool
   */
  protected $hasCheckbox = false;

  /**
   * @var bool
   */
  protected $hasFilterDateRange = false;

  protected $view = "base::table.table-admin-widget";
  /**
   * @var int
   */
  protected $defaultSortColumn = 1;

  /**
   * PostTable constructor.
   * @param DataTables $table
   * @param UrlGenerator $urlGenerator
   */
  public function __construct(DataTables $table, UrlGenerator $urlGenerator)
  {
    $this->setOption("id", "top-referrer-widget-table");
    parent::__construct($table, $urlGenerator);
  }

  public function getAjaxUrl(): string
  {
    return route("analytics.top.referrer");
  }

  /**
   * {@inheritDoc}
   */
  public function ajax()
  {
    return $this->table($this->query())->make(true);
  }

  /**
   * {@inheritDoc}
   */
  public function query()
  {
    $startDate = Carbon::today(config("app.timezone"))->startOfDay();
    $endDate = Carbon::today(config("app.timezone"))->endOfDay();
    $data = [];
    try {
      $period = Period::create($startDate, $endDate);
      $referrers = Analytics::fetchTopReferrers($period, 10);
      if ($referrers) {
        foreach ($referrers as $referrer):
          $data[] = [
            "id" => 1,
            "url" => $referrer["url"],
            "pageViews" => $referrer["pageViews"],
            "status" => 1,
            "created_at" => 1,
            "updated_at" => 1,
          ];
        endforeach;
      }
      return $data;
    } catch (InvalidConfiguration $exception) {
      return [];
    } catch (Exception $exception) {
      dd($exception);
    }
  }

  /**
   * {@inheritDoc}
   */
  public function columns()
  {
    return [
      "url" => [
        "name" => "url",
        "title" => "Url",
        "width" => "100px",
      ],
      "pageViews" => [
        "name" => "pageViews",
        "title" => "PageViews",
        "class" => "text-left",
      ],
    ];
  }

  public function buttons()
  {
    //return apply_filters(BASE_FILTER_TABLE_BUTTONS, [], InvestRequest::class);
  }

  public function getDefaultButtons(): array
  {
    return [];
  }

  /**
   * {@inheritDoc}
   */
  public function applyFilterCondition($query)
  {
    return parent::applyFilterCondition($query);
  }
}
