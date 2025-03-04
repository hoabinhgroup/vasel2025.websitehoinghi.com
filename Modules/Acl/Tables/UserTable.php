<?php

namespace Modules\Acl\Tables;

use Illuminate\Support\Facades\Auth;
use Modules\Acl\Entities\Users;
use Modules\Acl\Repositories\UserGroupInterface;
use Modules\Acl\Repositories\UserInterface;
use Modules\Base\Table\TableAbstract;
use Carbon\Carbon;
use Html;
use Illuminate\Contracts\Routing\UrlGenerator;
use DataTables;
use Excel;

class UserTable extends TableAbstract
{
  /**
   * @var bool
   */
  protected $hasActions = true;

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
   * @param UserInterface $user
   */
  public function __construct(
    DataTables $table,
    UrlGenerator $urlGenerator,
    UserInterface $user,
    UserGroupInterface $userGroup
  ) {
    $this->repository = $user;
    $this->userGroup = $userGroup;
    $this->setOption("id", "user-table");
    parent::__construct($table, $urlGenerator);

    if (Auth::check() && !Auth::user()->can(["user.edit", "user.delete"])) {
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
      ->editColumn("id_group", function ($data) {
        if ($data["id_group"]) {
          return $this->userGroup->find($data["id_group"])->name;
        }
      })
      ->editColumn("status", function ($data) {
        if ($data["status"] == 0) {
          return "Chưa kích hoạt";
        } elseif ($data["status"] == 1) {
          return "Kích hoạt";
        } else {
          return "Bị khóa";
        }
      })
      ->addColumn("action", function ($data) {
        return $this->getActionsButtonRow(
          "user.edit",
          "user.delete",
          $data,
          apply_filters(
            ACL_FILTER_USER_TABLE_ACTIONS,
            view("acl::table.partials.role", compact("data"))->render(),
            $data
          )
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
        "width" => "30px",
      ],
      "name" => [
        "name" => "name",
        "title" => __("base::tables.name"),
        "orderable" => false,
        "class" => "text-left",
        "width" => "50px",
      ],
      "email" => [
        "name" => "email",
        "title" => __("acl::tables.email"),
        "orderable" => false,
        "class" => "text-left",
        "width" => "60px",
      ],
      "id_group" => [
        "name" => "id_group",
        "title" => __("acl::tables.group"),
        "orderable" => false,
        "class" => "text-center",
        "width" => "50px",
      ],
      "status" => [
        "name" => "status",
        "title" => "Trạng thái",
        "orderable" => false,
        "class" => "text-center",
        "width" => "30px",
      ],
    ];
  }

  /**
   * {@inheritDoc}
   */
  public function buttons()
  {
    $buttons = $this->addCreateButton(route("user.create"), "user.create");

    return apply_filters(BASE_FILTER_TABLE_BUTTONS, $buttons, Users::class);
  }

  public function getActions(): array
  {
    return [];
    // return [$this->addExcelButton(route('product.export'), 'product.export')];
  }

  /**
   * {@inheritDoc}
   */
  public function applyFilterCondition($query)
  {
    return parent::applyFilterCondition($query);
  }
}
