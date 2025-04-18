<?php

namespace Modules\Base\Table;

use Assets;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Modules\Base\Repositories\RepositoryInterface;
use Modules\Base\Exports\BaseExport;
use Carbon\Carbon;
use Form;
use Html;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Arr;
use Illuminate\View\View;
use Request;
use Throwable;
use DataTables;
use Yajra\DataTables\Services\DataTable;
use Modules\Base\Events\DeletedContentEvent;
use Modules\Base\Events\UpdatedContentEvent;
//use Excel;

abstract class TableAbstract extends DataTable
{
  const TABLE_TYPE_ADVANCED = "advanced";

  const TABLE_TYPE_SIMPLE = "simple";

  /**
   * @var bool
   */
  protected $bStateSave = true;

  /**
   * @var DataTables
   */
  // protected $table;

  /**
   * @var string
   */
  protected $type = self::TABLE_TYPE_ADVANCED;

  /**
   * @var string
   */
  protected $ajaxUrl;

  /**
   * @var int
   */
  protected $pageLength = 10;

  /**
   * @var string
   */
  protected $view = "base::table.table";

  /**
   * @var string
   */
  protected $filterTemplate = "base::table.filter";

  /**
   * @var array
   */
  protected $options = [];

  /**
   * @var bool
   */
  protected $hasCheckbox = true;

  /**
   * @var bool
   */
  protected $hasOperations = true;


  protected $setRowIdByField = 'id';
  /**
   * @var bool
   */
  protected $hasActions = false;

  protected $hasTab = false;

  protected $hasExportButton = false;

  protected $tabActive = "all";
  /**
   * @var string
   */
  protected $bulkChangeUrl = "";

  /**
   * @var bool
   */
  protected $hasFilter = false;

  protected $hasFilterDateRange = false;

  /**
   * @var RepositoryInterface
   */
  protected $repository;

  /**
   * @var bool
   */
  protected $useDefaultSorting = true;

  /**
   * @var int
   */
  protected $defaultSortColumn = 1;

  /**
   * @var string
   */
  // protected $exportClass = TableExportHandler::class;

  /**
   * TableAbstract constructor.
   * @param DataTables $table
   * @param UrlGenerator $urlGenerator
   */
  public function __construct(DataTables $table, UrlGenerator $urlGenerator)
  {
    $this->table = $table;
    $this->ajaxUrl = $urlGenerator->current();

    if ($this->type == self::TABLE_TYPE_SIMPLE) {
      $this->pageLength = -1;
    }

    if (!$this->getOption("id")) {
      $this->setOption("id", "table_" . md5(get_class($this)));
    }

    if (!$this->getOption("class")) {
      $this->setOption("class", "table table-bordered table-striped dataTable");
    }

    $this->bulkChangeUrl = route("tables.bulk-change.save");
  }

  /**
   * @param string $key
   * @return string
   */
  public function getOption(string $key): ?string
  {
    return Arr::get($this->options, $key);
  }

  public function getTableName(): string
  {
    return $this->repository->getTable();
  }

  /**
   * @param string $key
   * @param mixed $value
   * @return $this
   */
  public function setOption(string $key, $value): self
  {
    $this->options[$key] = $value;

    return $this;
  }

  public function getOperations(): bool
  {
    return $this->hasOperations;
  }

  public function setOperations(bool $hasOperations): self
  {
    $this->hasOperations = $hasOperations;

    return $this;
  }
  /**
   * @return bool
   */
  public function isHasFilter(): bool
  {
    return $this->hasFilter;
  }

  public function ishasTab(): bool
  {
    return $this->hasTab;
  }

  public function isHasFilterDateRange(): bool
  {
    return $this->hasFilterDateRange;
  }

  /**
   * @param bool $hasFilter
   * @return $this
   */
  public function setHasFilter(bool $hasFilter): self
  {
    $this->hasFilter = $hasFilter;
    return $this;
  }

  /**
   * @return RepositoryInterface
   */
  public function getRepository(): RepositoryInterface
  {
    return $this->repository;
  }

  /**
   * @return string
   */
  public function getType(): string
  {
    return $this->type;
  }

  /**
   * @param string $type
   * @return $this
   */
  public function setType(string $type): self
  {
    $this->type = $type;
    return $this;
  }

  /**
   * @return string
   */
  public function getView(): string
  {
    return $this->view;
  }

  /**
   * @param string $view
   * @return $this
   */
  public function setView(string $view): self
  {
    $this->view = $view;

    return $this;
  }

  /**
   * @return array
   */
  public function getOptions(): array
  {
    return $this->options;
  }

  /**
   * @param array $options
   * @return $this
   */
  public function setOptions(array $options): self
  {
    $this->options = array_merge($this->options, $options);

    return $this;
  }

  public function table($data)
  {
    //$data = $this->filterDataBeforeDisplayTable($request);
    $datatable = Datatables::of($data)
      ->editColumn(
        "checkbox",
        '<div class="pretty p-icon">
	   	 		 <input type="checkbox" class="ace"  name="table_checkbox[]" value="{{ $id }}"  />
       			 <div class="state">
	   			 <i class="icon fa fa-check"></i>
	   			 <label></label>
	   			 </div>
	   			 </div>'
      )
      ->editColumn("created_at", function ($data) {
        $date = Carbon::parse($data["created_at"]);
        return $date->format("d/m/Y h:i A");
      })
      ->editColumn("updated_at", function ($data) {
        $date = Carbon::parse($data["updated_at"]);
        return $date->format("d/m/Y h:i A");
      })
      ->editColumn("status", function ($data) {
        return '<div class="badge badge-' .
          $data["status"] .
          '">' .
          __("base::enums.statuses." . $data["status"]) .
          "</div>";
      })

      ->editColumn("image", function ($data) {
        if (isset($data["image"])) {
          $image = $data["image"];
          if ($image) {
            $image = $image;
          } else {
            $image = "/images/default.png";
          }

          return HTML::image($image, $data->name, [
            "width" => 50,
            "height" => 50,
          ]);
        }
      });

    if ($this->ishasTab()) {
      $datatable->with(
        "tabs",
        $this->ishasTab() ? $this->get_tabs($this->repository) : false
      );
    }
    $datatable->escapeColumns([]);
    return $datatable;
  }

  /**
   * @return array
   * @throws Throwable
   */
  public function bulkActions(): array
  {
    $actions = [];

    if ($this->getBulkChanges()) {
      $actions["bulk-change"] = view("base::table.bulk-changes", [
        "bulk_changes" => $this->getBulkChanges(),
        "class" => get_class($this),
        "url" => $this->bulkChangeUrl,
      ])->render();
    }

    return $actions;
  }

  /**
   * @return array
   */
  public function getBulkChanges(): array
  {
    return [];
  }

  /**
   * @param array $ids
   * @param string $inputKey
   * @param string $inputValue
   * @return boolean
   */
  public function saveBulkChanges(
    array $ids,
    string $inputKey,
    $inputValue
  ): bool {
    foreach ($ids as $id) {
      $item = $this->repository->find($id);

      if ($item) {
        $this->saveBulkChangeItem($item, $inputKey, $inputValue);
        event(new UpdatedContentEvent(request()->all(), $item));
      }
    }

    return true;
  }

  /**
   * @param Model $item
   * @param string $inputKey
   * @param string $inputValue
   * @return false|Model
   */
  public function saveBulkChangeItem($item, string $inputKey, $inputValue)
  {
    $item->{$inputKey} = $this->prepareBulkChangeValue($inputKey, $inputValue);

    return $this->repository->createOrUpdate($item);
  }

  /**
   * @param string $key
   * @param string $value
   * @return string
   */
  public function prepareBulkChangeValue(string $key, $value)
  {
    if (strpos($key, ".") !== -1) {
      $key = Arr::last(explode(".", $key));
    }

    switch ($key) {
      case "created_at":
        $value = Carbon::createFromFormat(
          config("base.date_format.date_time"),
          $value
        )->toDateTimeString();
        break;
      case "updated_at":
        $value = Carbon::createFromFormat(
          config("base.date_format.date_time"),
          $value
        )->toDateTimeString();
        break;
    }

    return $value;
  }

  public function get_tabs($data): array
  {
    $data->resetModel();
    $request = request();

    if ($request->has("tabbar")) {
      $this->tabActive = $request->anchor_tab ?? "all";
      return [
        "all" => $data->all()->count(),
        "trash" => $data->allBy(["deleted_at" => true])->count(),
        "tab_active" => $this->tabActive,
      ];
    }

    return [];
  }

  public function getActionsButtonRow(
    $edit,
    $delete,
    $item,
    $extra = null,
    $restore = null
  ) {
    if ($this->tabActive != "trash") {
      return view(
        "base::table.partials.actions",
        compact("edit", "delete", "item", "extra")
      )->render();
    } else {
      // return '----';
      if ($restore) {
        return view(
          "base::table.partials.restore",
          compact("item", "restore")
        )->render();
      } else {
        return "----";
      }
    }
  }

  public function getSortColumn(): string
  {
    return $this->hasCheckbox ? $this->defaultSortColumn : 0;
  }
  /**
   * @return array
   * @since 2.1
   */
  public function getColumns(): array
  {
    $columns = $this->columns();

    if ($this->type == self::TABLE_TYPE_SIMPLE) {
      return $columns;
    }

    foreach ($columns as $key => &$column) {
      $column["class"] = Arr::get($column, "class") . " column-key-" . $key;
    }

    if ($this->repository) {
      //  $columns = apply_filters(BASE_FILTER_TABLE_HEADINGS, $columns, $this->repository->getModel());
    }

    if ($this->getOperations()) {
      $columns = array_merge($columns, $this->getOperationsHeading());
    }

    if ($this->hasCheckbox) {
      $columns = array_merge($this->getCheckboxColumnHeading(), $columns);
    }

    return $columns;
  }

  /**
   * @return array
   * @since 2.1
   */
  abstract public function columns();

  /**
   * @return array
   */
  public function getOperationsHeading()
  {
    return [
      "action" => [
        "title" => "Actions",
        "width" => "134px",
        "class" => "text-center",
        "orderable" => false,
        "searchable" => false,
        "exportable" => false,
        "printable" => false,
      ],
    ];
  }

  /**
   * @return array
   */
  public function getCheckboxColumnHeading()
  {
    $checkbox = "";
    $checkbox .= '<div class="pretty p-icon">';
    $checkbox .= Form::input("checkbox", null, null, [
      "id" => "ck_All",
      "class" => "table-check-all",
      "data-set" => ".dataTable .checkboxes",
    ])->toHtml();
    $checkbox .=
      '<div class="state"><i class="icon fa fa-check"></i><label></label></div></div>';
    return [
      "checkbox" => [
        "width" => "10px",
        "class" => "text-left no-sort",
        "title" => $checkbox,
        "orderable" => false,
        "searchable" => false,
        "exportable" => false,
        "printable" => false,
      ],
    ];
  }

  /**
   * @return string
   */
  public function getAjaxUrl(): string
  {
    return $this->ajaxUrl;
  }

  /**
   * @param string $ajaxUrl
   * @return $this
   */
  public function setAjaxUrl(string $ajaxUrl): self
  {
    $this->ajaxUrl = $ajaxUrl;
    return $this;
  }

  /**
   * @return null|string
   */
  public function getDom(): ?string
  {
    $dom = null;

    switch ($this->type) {
      case self::TABLE_TYPE_ADVANCED:
        $dom =
          "<'datatable-tools'<'custom-toolbar'><'d-flex justify-content-end filter-toolbar'f>r>t<'datatable-tools row clearfix'<'col-md-4'li><'col-md-8'p>>";
        break;
      case self::TABLE_TYPE_SIMPLE:
        $dom = "t<'datatables__info_wrap'<'clearfix'>>";
        break;
    }

    return $dom;
  }

  /**
   * @return array
   * @throws Throwable
   * @since 2.1
   */
  public function getBuilderParameters(): array
  {
    $params = [
      "stateSave" => true,
    ];

    if ($this->type == self::TABLE_TYPE_SIMPLE) {
      return $params;
    }

    $buttons = array_merge($this->getButtons(), $this->getActionsButton());

    $buttons = array_merge($buttons, $this->getDefaultButtons());
    if (!$buttons) {
      return $params;
    }

    return $params + compact("buttons");
  }

  /**
   * @return array
   * @since 2.1
   */
  public function getButtons(): array
  {
    $buttons = [];
    if (!$this->buttons()) {
      return $buttons;
    }
    //dd($this->buttons());
    foreach ($this->buttons() as $key => $button) {
      if (Arr::get($button, "extend") == "collection") {
        $buttons[] = $button;
      } else {
        $buttons[$key] = [
          "link" => $button["link"],
          "text" => $button["text"],
        ];

        if (Arr::has($button, "class")) {
          $buttons[$key]["class"] = $button["class"];
        }
      }
      if ($key == "modal") {
        foreach ($button as $index => $value):
          $buttons[$key][$index] = $button[$index];
        endforeach;
      }
    }

    return $buttons;
  }

  /**
   * @return array
   * @since 2.1
   * @throws \Throwable
   */
  public function buttons()
  {
    return [];
  }

  /**
   * @return array
   * @throws Throwable
   */
  public function getActionsButton(): array
  {
    if (!$this->getActions()) {
      return [];
    }

    return [
      [
        "extend" => "collection",
        "text" =>
        "<span>" .
          trans("base::forms.actions") .
          ' <span class="caret"></span></span>',
        "buttons" => $this->getActions(),
      ],
    ];
  }

  /**
   * @return array
   * @throws Throwable
   * @since 2.1
   */
  public function getActions(): array
  {
    if ($this->type == self::TABLE_TYPE_SIMPLE || !$this->actions()) {
      return [];
    }

    $actions = [];

    foreach ($this->actions() as $key => $action) {
      $actions[] = [
        "className" => "action-item",
        "text" =>
        '<span data-action="' .
          $key .
          '" data-href="' .
          $action["link"] .
          '"> ' .
          $action["text"] .
          "</span>",
      ];
    }
    return $actions;
  }

  /**
   * @return array
   * @since 2.1
   */
  public function actions()
  {
    return [];
  }

  /**
   * @return array
   * @throws Throwable
   */
  public function getDefaultButtons(): array
  {
    return ["reload"];
  }

  /**
   * @return string
   */
  public function htmlFooterCallback(): ?string
  {
    return "function (row, data, start, end, display) {" .
      $this->htmlFooterCallbackFunction() .
      "}";
  }

  public function htmlInitComplete(): ?string
  {
    return "function (data) {" . $this->htmlInitCompleteFunction() . "}";
  }

  /**
   * @return string
   */
  public function htmlInitCompleteFunction(): ?string
  {
    return "";
  }

  public function htmlFooterCallbackFunction(): ?string
  {
    return "";
  }

  /**
   * @return string
   */
  public function htmlDrawCallback(): ?string
  {
    /*  if ($this->type == self::TABLE_TYPE_SIMPLE) {
            return '';
        }
        */

    return "function () {" . $this->htmlDrawCallbackFunction() . "}";
  }

  /**
   * @return string
   */
  public function htmlDrawCallbackFunction(): ?string
  {
    return "";
  }

  /**
   * @param array $data
   * @param array $mergeData
   * @return JsonResponse|View
   * @throws Throwable
   * @since 2.4
   */
  public function renderTable($data = [], $mergeData = [])
  {
    return $this->render($this->view, $data, $mergeData);
  }

  /**
   * @param string $view
   * @param array $data
   * @param array $mergeData
   * @return mixed
   * @throws Throwable
   */
  public function render($view, $data = [], $mergeData = [])
  {
    $request = request();

    // if ($this->hasActions) {
    //   $this->saveBulkChanges();
    // }

    Assets::addJs([
      domain() . "/vendors/js/pickers/dateTime/bootstrap-datetimepicker.min.js",
    ]);
    Assets::addJs([domain() . "/js/table.js"]);

    Assets::addCss([
      domain() . "/vendors/css/pickers/bootrap-datetimepicker.min.css",
    ]);

    /*   Assets::addScripts(['datatables', 'moment', 'datepicker'])
            ->addStyles(['datatables', 'datepicker'])
            ->addStylesDirectly('vendor/core/css/table.css')
            ->addScriptsDirectly([
                'vendor/core/libraries/bootstrap3-typeahead.min.js',
                'vendor/core/js/table.js',
                'vendor/core/js/filter.js',
            ]);
            */

    $data["id"] = Arr::get($data, "id", $this->getOption("id"));
    $data["class"] = Arr::get($data, "class", $this->getOption("class"));

    $this->setAjaxUrl(
      $this->ajaxUrl . "?" . http_build_query(request()->input())
    );

    // $this->setAjaxUrl($this->ajaxUrl);

    $this->setOptions($data);

    $data["dom"] = $this->getDom();

    $data["actions"] = $this->hasActions ? $this->bulkActions() : [];

    $data["filterDropdown"] = $this->hasFilter ? $this->filterDropdown() : [];

    $data["table"] = $this;

    $data["data"] = Arr::get($data, "data", []);

    //dd($this->query());
    return parent::render($view, $data, $mergeData);
  }

  /**
   * @return array
   * @throws Throwable
   */
  // public function bulkActions(): array
  // {
  //   return $this->getBulkChanges();
  // }

  public function filterDropdown(): array
  {
    return $this->getFilterDropdowns();
  }

  /**
   * @return array
   */
  //   public function getBulkChanges(): array
  //   {
  //     $options = [
  //       "0" => "Bulk Action",
  //       "publish" => __("base::tables.active"),
  //       "draft" => __("base::tables.draft"),
  //     ];
  //
  //     if ($this->ishasTab()) {
  //       $options["trash"] = __("base::tables.trash");
  //       $options["restore"] = __("base::tables.restore");
  //     }
  //
  //     $options["delete"] = __("base::tables.delete");
  //
  //     return $options;
  //   }

  /**
   * @param \Illuminate\Database\Eloquent\Builder|Builder $query
   * @return mixed
   */
  public function applyScopes($query)
  {
    $request = request();

    $query = $this->applyFilterCondition($query);

    return parent::applyScopes($query);
  }

  public function applyCondition()
  {
    $request = request();
    $options = [];
    if ($request->anchor_tab == "trash") {
      $options["deleted_at"] = true;
    }

    return $options;
  }

  /**
   * @param Builder $query
   * @param string $key
   * @param string $operator
   * @param string $value
   * @return Builder
   */
  public function applyFilterCondition($query)
  {
    return $query;
  }

  public function setRowIdByField()
  {
    return $this->setRowIdByField;
  }

  /**
   * @param string|null $title
   * @param string|null $value
   * @param string| null $type
   * @param null $data
   * @return array
   * @throws Throwable
   */
  public function getValueInput(
    ?string $title,
    ?string $value,
    ?string $type,
    $data = null
  ): array {
    $inputName = "value";

    if (empty($title)) {
      $inputName = "filter_values[]";
    }
    $attributes = [
      "class" => "form-control input-value filter-column-value",
      //"placeholder" => trans("base::tables.general.value"),
      "autocomplete" => "off",
    ];

    switch ($type) {
      case "select":
        $attributes["class"] = $attributes["class"] . " select";
        $attributes["placeholder"] = trans(
          "base::tables.general.select_option"
        );
        $html = Form::customSelect(
          $inputName,
          $data,
          $value,
          $attributes
        )->toHtml();
        break;
      case "select-multiple":
        $attributes["class"] = $attributes["class"] . " select2";
        $attributes["multiple"] = "multiple";
        // $attributes["placeholder"] = "";
        $html = Form::customSelect(
          $inputName,
          $data,
          $value,
          $attributes
        )->toHtml();
        break;
      case "select-search":
        $attributes["class"] = $attributes["class"] . " select-search-full";
        $attributes["placeholder"] = trans("base::table.general.select_option");
        $html = Form::customSelect(
          $inputName,
          $data,
          $value,
          $attributes
        )->toHtml();
        break;
      case "number":
        $html = Form::number($inputName, $value, $attributes)->toHtml();
        break;
      case "date":
        $attributes["class"] =
          $attributes["class"] . " datepicker pickadate date";
        // $attributes["data-date-format"] = config(
        //   "base.date_format.js.date"
        // );
        $content = Form::text($inputName, $value, $attributes)->toHtml();
        $html = view(
          "base::table.partials.date-field",
          compact("content")
        )->render();
        break;
      default:
        $attributes["placeholder"] = trans("base::tables.general.value");
        $html = Form::text($inputName, $value, $attributes)->toHtml();
        break;
    }

    return compact("html", "data");
  }

  /**
   * @return array
   */
  public function getFilters(): array
  {
    return $this->getBulkChanges();
  }

  function getExcel()
  {
    $columns = $this->columns();
    $title = [];
    $field = [];
    foreach ($columns as $key => $column):
      $title[] = $column["title"];
      $field[] = $column["name"];
    endforeach;
    $excel[] = $title;

    foreach ($this->ajax()->original["data"] as $data):
      $dataExcel = [];
      for ($loop = 0; $loop < count($field); $loop++) {
        if ($field[$loop] == "image") {
          $dataField = $data[$field[$loop]];
          preg_match('@src="([^"]+)"@', $dataField, $match);
          $dataField = array_pop($match);
        } else {
          $dataField = strip_tags($data[$field[$loop]]);
        }
        $dataExcel[$title[$loop]] = $dataField;
      }
      $excel[] = $dataExcel;
    endforeach;

    $export = new BaseExport($excel);
    return Excel::download(
      $export,
      $this->getOption("id") . "_" . date("d-m-Y", time()) . ".xlsx"
    );
  }

  /**
   * @return array
   * @deprecated 5.3
   */
  protected function getYesNoSelect(): array
  {
    return [
      0 => trans("base::base.no"),
      1 => trans("base::base.yes"),
    ];
  }

  /**
   * @param array $buttons
   * @param string $url
   * @param null|string $permission
   * @throws Throwable
   * @return array
   */
  protected function addCreateButton(
    string $url,
    $permission = null,
    array $buttons = [],
    $title = null
  ): array {
    if (!$permission || Auth::user()->can($permission)) {
      $queryString = http_build_query(Request::query());
      if ($queryString) {
        $url .= "?" . $queryString;
      }
      $buttons["create"] = [
        "link" => $url,
        "text" => view(
          "base::table.partials.create",
          compact("title")
        )->render(),
      ];
    }

    return $buttons;
  }

  protected function addExcelButton(
    string $url,
    $permission = null,
    array $buttons = []
  ): array {
    if (!$permission || Auth::user()->can($permission)) {
      $queryString = http_build_query(Request::query());
      if ($queryString) {
        $url .= "?" . $queryString;
      }
      $buttons["excel"] = [
        "link" => $url,
        "class" => "btn btn-info mr5",
        "text" => view("base::table.partials.excel")->render(),
      ];
    }

    return $buttons;
  }

  /**
   * @param string $url
   * @param null|string $permission
   * @param array $actions
   * @return array
   */
  protected function addDeleteAction(
    string $url,
    $permission = null,
    $actions = []
  ): array {
    if (!$permission || Auth::user()->can($permission)) {
      $actions["delete-many"] = view("base::table.partials.delete", [
        "href" => $url,
        "data_class" => get_called_class(),
      ]);
    }

    return $actions;
  }
}
