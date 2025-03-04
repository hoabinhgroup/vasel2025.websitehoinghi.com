<?php

namespace Modules\Page\Tables;

use Illuminate\Support\Facades\Auth;
//use Modules\Ecommerce\Exports\ProductExport;
use Modules\Acl\Entities\Users;
use Modules\Page\Entities\Page;
use Modules\Page\Repositories\PageInterface;
use Modules\Base\Table\TableAbstract;
use Carbon\Carbon;
use Html;
use Illuminate\Contracts\Routing\UrlGenerator;
use DataTables;
use Excel;

class PageAdminWidgetTable extends TableAbstract
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
   * @var
   */
  protected $catalog;

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
   * @param ProductsInterface $product
   * @param CatalogInterface $catalog
   * @param ProductCatalogsInterface $productCatalogs
   */
  public function __construct(
    DataTables $table,
    UrlGenerator $urlGenerator,
    PageInterface $page
  ) {
    $this->repository = $page;
    $this->setOption("id", "page-table");
    parent::__construct($table, $urlGenerator);
  }

  /**
   * {@inheritDoc}
   */
  public function ajax()
  {
    return $this->table($this->query())
      ->editColumn("user_id", function ($data) {
        return Users::find($data["user_id"])->name;
      })

      ->make(true);
  }

  public function getAjaxUrl(): string
  {
    return route("page.index");
  }

  /**
   * {@inheritDoc}
   */
  public function query()
  {
    $model = $this->repository;

    $query = $model->select(["*"], $this->applyCondition());

    return $this->applyScopes(
      apply_filters(BASE_FILTER_TABLE_QUERY, $query, $model)
    )->get();
  }

  /**
   * {@inheritDoc}
   */
  public function columns()
  {
    return [
      "id" => [
        "name" => "id",
        "title" => __("base::tables.id"),
        "width" => "10px",
      ],
      "name" => [
        "name" => "name",
        "title" => __("base::tables.name"),
        "orderable" => false,
        "class" => "text-left",
      ],
      "created_at" => [
        "name" => "created_at",
        "title" => __("base::tables.created_at"),
        "orderable" => false,
        "class" => "text-center",
        "width" => "150px",
      ],
    ];
  }

  /**
   * {@inheritDoc}
   */
  public function buttons()
  {
    return apply_filters(BASE_FILTER_TABLE_BUTTONS, [], Page::class);
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
