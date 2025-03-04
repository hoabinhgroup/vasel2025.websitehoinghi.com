<?php

namespace Modules\Analytics\Tables;

use Illuminate\Support\Facades\Auth;
use Modules\Acl\Entities\Users;
use Modules\Base\Table\TableAbstract;
use Carbon\Carbon;
use Html;
use Illuminate\Contracts\Routing\UrlGenerator;
use DataTables;
use Modules\Analytics\Period;
use Analytics;
use Exception;
use Throwable;

class AdminTopVisitPagesWidgetTable extends TableAbstract
{
  /**
   * @var bool
   */
  protected $hasActions = false;

  protected $hasOperations = false;

  protected $hasCheckbox = false;

  /**
   * @var bool
   */
  protected $hasTab = false;

  /**
   * @var bool
   */
  protected $hasFilterDateRange = false;

  protected $view = "base::table.table-admin-widget";

  /**
   * @var string
   */

  /**
   * @var int
   */
  protected $defaultSortColumn = 1;

  /**
   * PostTable constructor.
   * @param DataTables $table
   * @param UrlGenerator $urlGenerator
   * @param ProductCatalogsInterface $productCatalogs
   */
  public function __construct(DataTables $table, UrlGenerator $urlGenerator)
  {
    $this->setOption("id", "top-visit-pages-table");
    parent::__construct($table, $urlGenerator);
  }

  /**
   * {@inheritDoc}
   */
  public function ajax()
  {
    return $this->table($this->query())->make(true);
  }

  public function getAjaxUrl(): string
  {
    return route("analytics.top.visit.page");
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
      $mostVisistedPages = Analytics::fetchMostVisitedPages($period, 200);
      if ($mostVisistedPages) {
        foreach ($mostVisistedPages as $key => $visit):
          $data[] = [
            "id" => $key,
            "url" => $visit["url"],
            "pageViews" => $visit["pageViews"],
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
      return [];
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
        "orderable" => false,
        "class" => "text-left",
      ],
      "pageViews" => [
        "name" => "pageViews",
        "title" => "View",
        "orderable" => false,
        "class" => "text-left",
      ],
    ];
  }

  /**
   * {@inheritDoc}
   */
  public function buttons()
  {
    return [];
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
