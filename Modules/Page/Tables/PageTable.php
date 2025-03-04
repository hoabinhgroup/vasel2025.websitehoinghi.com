<?php

namespace Modules\Page\Tables;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
//use Modules\Ecommerce\Exports\ProductExport;
use Modules\Base\Enums\BaseStatusEnum;
use Modules\Acl\Entities\Users;
use Modules\Page\Entities\Page;
use Modules\Template\Entities\Templates;
use Modules\Page\Repositories\PageInterface;
use Modules\Base\Table\TableAbstract;
use Carbon\Carbon;
use Html;
use Illuminate\Contracts\Routing\UrlGenerator;
use DataTables;
use Excel;

class PageTable extends TableAbstract
{
  /**
   * @var bool
   */
  protected $hasActions = true;

  protected $hasFilter = true;
  /**
   * @var bool
   */
  protected $hasTab = false;

  protected $pageLength = 25;
  /**
   * @var bool
   */
  protected $hasFilterDateRange = false;

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

    if (Auth::check() && !Auth::user()->can(["page.edit", "page.delete"])) {
      $this->hasOperations = false;
      $this->hasActions = false;
    }
  }

  /**
   * {@inheritDoc}
   */
  public function ajax()
  {
    return $this->table($this->query())
      ->editColumn("name", function ($item) {
        if (!Auth::user()->can("page.edit")) {
          $name = $item->name;
        } else {
          $name = Html::link(route("page.edit", $item->id), $item->name);
        }

        return apply_filters(PAGE_FILTER_PAGE_NAME_IN_ADMIN_LIST, $name, $item);
      })
      ->editColumn("user_id", function ($item) {
        return $item->user->name;
      })

      ->addColumn("action", function ($item) {
        return $this->getActionsButtonRow(
          "page.edit",
          "page.delete",
          $item,
          null,
          "page.restore"
        );
      })
      ->make(true);
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
    );
  }

  /**
   * {@inheritDoc}
   */
  public function columns()
  {
    return [
      "id" => [
        "name" => "id",
        "title" => __("Base::tables.id"),
        "width" => "10px",
      ],
      "name" => [
        "name" => "name",
        "title" => __("Base::tables.name"),
        "orderable" => false,
        "class" => "text-left",
        "width" => "300px",
      ],
      "user_id" => [
        "name" => "user_id",
        "title" => __("Base::tables.author"),
        "orderable" => false,
        "class" => "text-left",
      ],
      "status" => [
        "name" => "status",
        "title" => __("Base::tables.status"),
        "orderable" => false,
        "class" => "text-center",
      ],
      "created_at" => [
        "name" => "created_at",
        "title" => __("Base::tables.created_at"),
        "orderable" => false,
        "class" => "text-center",
        "width" => "160px",
      ],
      "updated_at" => [
        "name" => "updated_at",
        "title" => __("Base::tables.updated_at"),
        "orderable" => false,
        "class" => "text-center",
        "width" => "160px",
      ],
    ];
  }

  /**
   * {@inheritDoc}
   */
  public function buttons()
  {
    $buttons = $this->addCreateButton(route("page.create"), "page.create");

    return apply_filters(BASE_FILTER_TABLE_BUTTONS, $buttons, Page::class);
  }

  public function getActions(): array
  {
    return [];
    // return [$this->addExcelButton(route('product.export'), 'product.export')];
  }

  /**
   * {@inheritDoc}
   */
  public function bulkActions(): array
  {
    return $this->addDeleteAction(
      route("page.deletes"),
      "page.deletes",
      parent::bulkActions()
    );
  }

  /**
   * {@inheritDoc}
   */
  public function getBulkChanges(): array
  {
    return [
      "name" => [
        "title" => trans("base::tables.name"),
        "type" => "text",
        "validate" => "required|max:120",
      ],
      "status" => [
        "title" => trans("base::tables.status"),
        "type" => "select",
        "choices" => BaseStatusEnum::labels(),
        "validate" => "required|" . Rule::in(BaseStatusEnum::values()),
      ],
      "template" => [
        "title" => trans("base::tables.template"),
        "type" => "select",
        "choices" => Templates::pluck("name", "id"),
        "validate" => "required",
      ],
      "created_at" => [
        "title" => trans("base::tables.created_at"),
        "type" => "date",
      ],
    ];
  }

  public function getFilterDropdowns(): array
  {
    $options = [];

    $options[] = [
      "name" => "template",
      "defaultOption" => "Chọn template",
      "class" => "w220 select2 select2-size form-control",
      "options" => $this->selectTemplates(),
    ];

    return $options;
  }

  public function selectTemplates()
  {
    $selectTemplates = [];
    $templates = Templates::pluck("name", "id");

    foreach ($templates as $id => $template):
      $selectTemplates[] = ["id" => $id, "name" => $template];
    endforeach;

    return $selectTemplates;
  }

  /**
   * {@inheritDoc}
   */
  public function applyFilterCondition($query)
  {
    $request = request();

    if ($request->has("template") && $request->template > 0) {
      $query = $query->where("pages.template", "=", $request->template);
    }

    return parent::applyFilterCondition($query);
  }
}
