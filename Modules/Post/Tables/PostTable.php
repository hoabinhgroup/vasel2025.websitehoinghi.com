<?php

namespace Modules\Post\Tables;

use Illuminate\Support\Facades\Auth;
use Modules\Acl\Entities\Users;
use Modules\Post\Entities\Post;
use Modules\Post\Repositories\PostInterface;
use Modules\Base\Table\TableAbstract;
use Carbon\Carbon;
use Html;
use Illuminate\Contracts\Routing\UrlGenerator;
use DataTables;
use Excel;

class PostTable extends TableAbstract
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
  protected $hasFilter = true;
  /**
   * @var bool
   */
  protected $hasFilterDateRange = false;

  /**
   * @var int
   */
  protected $defaultSortColumn = 6;

  /**
   * PostTable constructor.
   * @param DataTables $table
   * @param UrlGenerator $urlGenerator
   */
  public function __construct(
    DataTables $table,
    UrlGenerator $urlGenerator,
    PostInterface $post
  ) {
    $this->repository = $post;
    $this->setOption("id", "post-table");
    parent::__construct($table, $urlGenerator);

    if (Auth::check() && !Auth::user()->can(["post.edit", "post.delete"])) {
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
      ->editColumn("author_id", function ($item) {
        return Users::find($item["author_id"])->name;
      })
      ->addColumn("action", function ($item) {
        return $this->getActionsButtonRow(
          "post.edit",
          "post.delete",
          $item,
          null,
          "post.restore"
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
      "name" => [
        "name" => "name",
        "title" => __("base::tables.name"),
        "orderable" => false,
        "class" => "text-left",
        "width" => "500px",
      ],
      "author_id" => [
        "name" => "author_id",
        "title" => __("base::tables.author"),
        "orderable" => false,
        "class" => "text-center",
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
      "id" => [
        "name" => "id",
        "title" => __("base::tables.id"),
        "width" => "10px",
      ],
    ];
  }

  /**
   * {@inheritDoc}
   */
  public function buttons()
  {
    $buttons = $this->addCreateButton(route("post.create"), "post.create");

    return apply_filters(BASE_FILTER_TABLE_BUTTONS, $buttons, Post::class);
  }

  public function getFilterDropdowns(): array
  {
    return [
      [
        "name" => "category",
        "defaultOption" => __("base::form.select-categories"),
        "class" => "w200 select2 select2-size form-control",
        "options" => \Categories::recursive(),
      ],
    ];
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
    $request = request();

    if ($request->has("category") && $request->category > 0) {
      $query = $query
        ->join("post_categories", "post_categories.post_id", "posts.id")
        ->where("post_categories.category_id", "=", $request->category);
    }

    return parent::applyFilterCondition($query);
  }
}
