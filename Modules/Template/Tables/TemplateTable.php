<?php

namespace Modules\Template\Tables;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Modules\Base\Enums\BaseStatusEnum;
use Modules\Acl\Entities\Users;
use Modules\Template\Entities\Templates;
use Modules\Template\Repositories\TemplateInterface;
use Modules\Base\Table\TableAbstract;
use Carbon\Carbon;
use Html;
use Illuminate\Contracts\Routing\UrlGenerator;
use DataTables;
use Excel;

class TemplateTable extends TableAbstract
{
  /**
   * @var bool
   */
  protected $hasActions = true;

  /**
   * @var bool
   */
  protected $hasTab = true;

  /**
   * @var bool
   */
  protected $hasFilterDateRange = false;

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
   * @param TemplateInterface $template
   */
  public function __construct(
    DataTables $table,
    UrlGenerator $urlGenerator,
    TemplateInterface $template
  ) {
    $this->repository = $template;
    $this->setOption("id", "template-table");
    parent::__construct($table, $urlGenerator);

    if (
      Auth::check() &&
      !Auth::user()->can(["template.edit", "template.delete"])
    ) {
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
      ->editColumn("user_id", function ($item) {
        return Users::find($item->user_id)->name;
      })

      ->addColumn("action", function ($item) {
        return $this->getActionsButtonRow(
          "template.edit",
          "template.delete",
          $item
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
      "user_id" => [
        "name" => "user_id",
        "title" => __("base::tables.author"),
        "orderable" => false,
        "class" => "text-left",
      ],
      "created_at" => [
        "name" => "created_at",
        "title" => __("base::tables.created_at"),
        "orderable" => false,
        "class" => "text-center",
      ],
      "updated_at" => [
        "name" => "updated_at",
        "title" => __("base::tables.updated_at"),
        "orderable" => false,
        "class" => "text-center",
      ],
    ];
  }

  /**
   * {@inheritDoc}
   */
  public function buttons()
  {
    $buttons = $this->addCreateButton(
      route("template.create"),
      "template.create"
    );

    return apply_filters(BASE_FILTER_TABLE_BUTTONS, $buttons, Templates::class);
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
    return parent::bulkActions();
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
  public function applyFilterCondition($query)
  {
    return parent::applyFilterCondition($query);
  }
}
