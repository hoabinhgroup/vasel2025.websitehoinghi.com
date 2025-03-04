<?php

namespace Modules\Menu\Tables;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Modules\Base\Enums\BaseStatusEnum;
use Modules\Menu\Entities\Menu;
use Modules\Menu\Repositories\MenusInterface;
use Modules\Base\Table\TableAbstract;
use Carbon\Carbon;
use Html;
use Illuminate\Contracts\Routing\UrlGenerator;
use DataTables;
use Excel;
use Modules\Menu\Libraries\Recursive;

class MenusTable extends TableAbstract
{
  /**
   * @var bool
   */
  protected $hasActions = true;

  protected $hasTab = false;

  /**
   * @var int
   */
  protected $defaultSortColumn = 5;

  /**
   * PostTable constructor.
   * @param DataTables $table
   * @param UrlGenerator $urlGenerator
   * @param CatalogInterface $catalog
   */
  public function __construct(
    DataTables $table,
    UrlGenerator $urlGenerator,
    MenusInterface $menu
  ) {
    $this->repository = $menu;
    $this->setOption("id", "menus-table");

    parent::__construct($table, $urlGenerator);

    if (Auth::check() && !Auth::user()->can(["menus.edit", "menus.delete"])) {
      $this->hasOperations = false;
      $this->hasActions = false;
    }
  }

  /**
   * {@inheritDoc}
   */
  public function ajax()
  {
    $catalog = $this->repository;
    $request = request();

    return $this->table($this->query())

      ->addColumn("action", function ($data) {
        return $this->getActionsButtonRow("menus.edit", "menus.delete", $data);
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
    )->get();
  }

  /**
   * {@inheritDoc}
   */
  public function columns()
  {
    return [
      "name" => [
        "name" => "name",
        "title" => __("base::tables.name"),
        "orderable" => false,
        "class" => "text-left",
      ],
      "slug" => [
        "name" => "parent",
        "title" => __("base::tables.slug"),
        "orderable" => false,
        "width" => "25px",
      ],
      "created_at" => [
        "name" => "created_at",
        "title" => __("base::tables.created_at"),
        "orderable" => false,
        "width" => "15px",
      ],
      "updated_at" => [
        "name" => "updated_at",
        "title" => __("base::tables.updated_at"),
        "orderable" => false,
        "width" => "15px",
      ],
      "id" => [
        "name" => "id",
        "title" => __("base::tables.id"),
        "orderable" => false,
        "width" => "10px",
      ],
    ];
  }

  /**
   * {@inheritDoc}
   */
  public function bulkActions(): array
  {
    return $this->addDeleteAction(
      route("menus.deletes"),
      "menus.deletes",
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
      "created_at" => [
        "title" => trans("base::tables.created_at"),
        "type" => "date",
      ],
    ];
  }

  /**
   * {@inheritDoc}
   */
  public function buttons()
  {
    $buttons = $this->addCreateButton(route("menus.create"), "menus.create");

    return apply_filters(BASE_FILTER_TABLE_BUTTONS, $buttons, Menu::class);
  }

  public function getActions(): array
  {
    //return [$this->addExcelButton(route('catalog.export'), 'catalog.export')];
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
