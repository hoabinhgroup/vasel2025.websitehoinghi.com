<?php

namespace Modules\Slider\Tables;

use Illuminate\Support\Facades\Auth;
use Modules\Acl\Entities\Users;
use Modules\Slider\Entities\Slider;
use Modules\Slider\Repositories\SliderInterface;
use Modules\Base\Table\TableAbstract;
use Carbon\Carbon;
use Html;
use Illuminate\Contracts\Routing\UrlGenerator;
use DataTables;
use Excel;

class SliderTable extends TableAbstract
{
  /**
   * @var bool
   */
  protected $hasActions = true;

  /**
   * @var bool
   */
  protected $hasTab = false;

  /**
   * @var bool
   */
  protected $hasFilterDateRange = false;

  /**
   * @var int
   */
  protected $defaultSortColumn = 1;

  /**
   * PostTable constructor.
   * @param DataTables $table
   * @param UrlGenerator $urlGenerator
   */
  public function __construct(
    DataTables $table,
    UrlGenerator $urlGenerator,
    SliderInterface $slider
  ) {
    $this->repository = $slider;
    $this->setOption("id", "slider-table");
    parent::__construct($table, $urlGenerator);

    if (Auth::check() && !Auth::user()->can(["slider.edit", "slider.delete"])) {
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

      ->addColumn("action", function ($item) {
        return $this->getActionsButtonRow(
          "slider.edit",
          "slider.delete",
          $item,
          null,
          "slider.restore"
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
        "title" => __("base::tables.id"),
        "width" => "10px",
      ],
      "name" => [
        "name" => "name",
        "title" => __("base::tables.name"),
        "orderable" => false,
        "class" => "text-left",
      ],
      "key" => [
        "name" => "key",
        "title" => "Key",
        "orderable" => false,
        "class" => "text-left",
      ],
      "status" => [
        "name" => "status",
        "title" => __("base::tables.status"),
        "orderable" => false,
        "class" => "text-center",
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
    $buttons = $this->addCreateButton(route("slider.create"), "slider.create");

    return apply_filters(BASE_FILTER_TABLE_BUTTONS, $buttons, Slider::class);
  }

  public function getActions(): array
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
