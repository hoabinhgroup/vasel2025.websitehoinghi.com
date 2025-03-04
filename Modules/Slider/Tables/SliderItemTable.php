<?php

namespace Modules\Slider\Tables;

use Illuminate\Support\Facades\Auth;
use Modules\Acl\Entities\Users;
use Modules\Slider\Entities\SliderItem;
use Modules\Slider\Repositories\SliderItemInterface;
use Modules\Base\Table\TableAbstract;
use Carbon\Carbon;
use Html;
use Illuminate\Contracts\Routing\UrlGenerator;
use DataTables;
use Excel;

class SliderItemTable extends TableAbstract
{
  protected $type = self::TABLE_TYPE_SIMPLE;

  /**
   * @var string
   */
  protected $view = "slider::items";
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
  protected $hasFilterDateRange = false;

  /**
   * @var int
   */
  protected $defaultSortColumn = 3;

  /**
   * PostTable constructor.
   * @param DataTables $table
   * @param UrlGenerator $urlGenerator
   */
  public function __construct(
    DataTables $table,
    UrlGenerator $urlGenerator,
    SliderItemInterface $sliderItem
  ) {
    $this->repository = $sliderItem;
    $this->setOption("id", "slider-item-table");
    parent::__construct($table, $urlGenerator);

    if (
      Auth::check() &&
      !Auth::user()->can(["slider-item.edit", "slider-item.delete"])
    ) {
      $this->hasOperations = false;
      $this->hasActions = false;
    }
  }

  public function ajax()
  {
   
    return $this->table($this->query())
      ->editColumn("image", function($item){
        return Html::image(get_image_url($item->image, 'thumb'), 'alt', ['width' => 100, 'height' => 100]);
      })
      ->addColumn("action", function ($item) {
        return view("slider::partials.actions", compact("item"))->render();
      })
      ->make(true);
  }

  /**
   * {@inheritDoc}
   */
  public function query()
  {
    $model = $this->repository;
    $query = $model->select(["*"], $this->applyCondition())->where(
      "slider_id", (int) request()->sliderId
    );

    return $this->applyScopes(
      apply_filters(BASE_FILTER_TABLE_QUERY, $query, $model)
    );
  }

  /**
   * {@inheritDoc}
   */
  public function columns()
  {
    $operation = $this->getOperationsHeading();
    $operation["action"]["width"] = "180px;";

    return [
      "id" => [
        "name" => "id",
        "title" => __("base::tables.id"),
        "width" => "10px",
      ],
      "image" => [
        "name" => "image",
        "title" => "Image",
        "orderable" => false,
        "class" => "text-left",
      ],
      "title" => [
        "name" => "title",
        "title" => "Title",
        "orderable" => false,
        "class" => "text-left",
      ],
      "order" => [
        "name" => "order",
        "title" => "Order",
        "orderable" => true,
        "class" => "text-center order-column",
      ],
      "description" => [
        "name" => "description",
        "title" => "Description",
        "orderable" => false,
        "class" => "text-left",
      ],
      "updated_at" => [
        "name" => "updated_at",
        "title" => __("base::tables.updated_at"),
        "orderable" => false,
        "class" => "text-center",
      ],
    ] + $operation;
  }

  public function htmlInitCompleteFunction(): ?string
  {
    return '
        var listValues = [];
         var options = {
               onStart: function (evt) {
                 evt.oldIndex;
                // console.log("onStart", evt.oldIndex);
               },

               onUpdate: function (evt) {
                   var items = evt.to.children;

                  $.each( items, function( key, value ) {
                      var id = $(value).attr("id");
                          listValues.push({ id: id, order: key});
                      });
                      $.ajax({
                           url: window.location.origin + "/api/slideItem/sort",
                           type: "POST",
                           dataType: "json",
                           data: { data: listValues },
                           success: function (result) {
                             if(result.success){
                                 appAlert.success(result.message, {container: "body", duration: 3000});
                                 louisData._load();
                             }

                           },
                           error: function (response) {
                             console.log(response);
                           },
                         });

               },
             };
             var el = document.getElementById("slider-item-table").getElementsByTagName("tbody")[0];

             var sortable = Sortable.create(el, options);

      ';
  }
  /**
   * {@inheritDoc}
   */
  public function buttons()
  {
    return [];
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
