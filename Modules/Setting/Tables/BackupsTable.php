<?php

namespace Modules\Setting\Tables;

use Illuminate\Support\Facades\Auth;
//use Modules\Acl\Entities\Users;
use Modules\Base\Table\TableAbstract;
use Carbon\Carbon;
use Html;
use Illuminate\Contracts\Routing\UrlGenerator;
use DataTables;
use Excel;
use GoogleDrive;

class BackupsTable extends TableAbstract
{
  /**
   * @var bool
   */
  protected $hasActions = false;
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
  /**
   * @var int
   */
  protected $defaultSortColumn = 2;

  /**
   * PostTable constructor.
   * @param DataTables $table
   * @param UrlGenerator $urlGenerator
   */
  public function __construct(DataTables $table, UrlGenerator $urlGenerator)
  {
    $this->setOption("id", "backup-table");
    parent::__construct($table, $urlGenerator);
    if (Auth::check() && !Auth::user()->can(["backup.delete"])) {
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
      ->addColumn("name", function ($item) {
        return "<a href='" .
          route("backup.download", $item["id"]) .
          "'>" .
          $item["name"] .
          "</a>";
      })
      ->addColumn("action", function ($item) {
        return $this->getActionsButtonRow(null, "backup.delete", $item, null);
      })
      ->make(true);
  }

  public function getActionsButtonRow(
    $edit,
    $delete,
    $item,
    $extra = null,
    $restore = null
  ) {
    return view("setting::table.actions", compact("delete", "item"))->render();
  }

  /**
   * {@inheritDoc}
   */
  public function query()
  {
    $data = [];

    $files = GoogleDrive::service()
      ->files->listFiles([
        "fields" =>
          "files(id, name, mimeType, parents, properties, trashed, quotaBytesUsed, kind, size)",
        "q" => "'" . env("GOOGLE_DRIVE_FOLDER_ID") . "' in parents",
      ])
      ->getFiles();

    // dd($files);

    foreach ($files as $k => $file):
      $data[] = [
        "id" => $file["id"],
        "name" => $file["name"],
        "kind" => $file["mimeType"],
        "size" => $file["size"] / 1000 . "kb",
        "created_at" => null,
        "updated_at" => null,
        "status" => null,
      ];
    endforeach;

    return $data;
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
        "orderable" => false,
        "width" => "200px",
      ],
      "name" => [
        "name" => "name",
        "title" => "Tên file Backup",
        "orderable" => true,
        "class" => "text-left",
        "width" => "300px",
      ],
      "kind" => [
        "name" => "kind",
        "title" => "Kiểu file",
        "orderable" => false,
        "class" => "text-left",
        "width" => "300px",
      ],
      "size" => [
        "name" => "size",
        "title" => "Kích thước",
        "orderable" => false,
        "class" => "text-left",
      ],
    ];
  }

  public function buttons()
  {
    // $buttons = $this->addCreateButton(
    //   route("backup.generation", ["type" => ""]),
    //   "backup.generation",
    //   [],
    //   "Backup Db"
    // );

    $buttons = [
      "create" => [
        "link" => route("backup.generation", ["type" => "db"]),
        "class" => "btn btn-info mr5",
        "text" =>
          Html::tag("i", "", ["class" => "fa fa-hdd-o"])->toHtml() .
          " " .
          "Backup Db",
      ],
      "create-all" => [
        "link" => route("backup.generation", ["type" => "all"]),
        "class" => "btn btn-danger mr5",
        "text" =>
          Html::tag("i", "", ["class" => "fa fa-hdd-o"])->toHtml() .
          " " .
          "Backup All",
      ],
    ];
    return $buttons;
  }

  /**
   * {@inheritDoc}
   */
  public function applyFilterCondition($query)
  {
    return parent::applyFilterCondition($query);
  }
}
