<?php

namespace Modules\Template\Http\Controllers;

use Response;
use Auth;
use Illuminate\Http\Request;
use Modules\Acl\Entities\Users;
//use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Template\Tables\TemplateTable;
use Modules\Template\Repositories\TemplateInterface;
use Carbon\Carbon;

class TemplateController extends Controller
{
  /**
   * @var TemplateInterface
   */
  protected $template;

  public function __construct(TemplateInterface $template)
  {
    $this->template = $template;
  }

  /**
   * Display a listing of the resource.
   * @return Response
   */
  public function index(TemplateTable $table)
  {
    page_title()->setTitle(__("template::tables.list"));
    return $table->renderTable();
  }

  /**
   * Show the form for creating a new resource.
   * @return Response
   */
  public function create()
  {
    return view("template::cmspanel.create");
  }

  /**
   * Store a newly created resource in storage.
   * @param Request $request
   * @return Response
   */
  public function store(Request $request)
  {
    if ($request->ajax()) {
      $request->request->add(["user_id" => Auth::user()->id]);
      $template = $this->template->create($request->all());
      return Response::json(
        [
          "success" => true,
          "last_insert_id" => $template->id,
        ],
        200
      );
    }
  }

  /**
   * Show the specified resource.
   * @param int $id
   * @return Response
   */
  public function show($id)
  {
    return view("template::show");
  }

  /**
   * Show the form for editing the specified resource.
   * @param int $id
   * @return Response
   */
  public function edit($id)
  {
    $template = $this->template->find($id);

    $widget_sortable_rows = _make_editable_rows(json_decode($template->data));

    return view(
      "template::cmspanel.edit",
      compact("template", "widget_sortable_rows")
    );
  }

  /* private function _get_column_class_value($key, $columns, $column_ratio) {
        $columns_array = array(1 => 12, 2 => 6, 3 => 4, 4 => 3);

        $column_count = count($columns);
        $column_ratio_count = count($column_ratio);

        $class_value = $column_ratio[$key];

        if ($column_count < $column_ratio_count) {
            $class_value = $columns_array[$column_count];
        }

        return $class_value;
    }

    private function _make_editable_rows($elements) {
        $view = "";


        if ($elements) {
            foreach ($elements as $element) {

                $column_ratio = get_array_value((array) $element, "ratio");
                $column_ratio_explode = explode("-", $column_ratio);

                $view .= "<row class='widget-row clearfix block bg-white' data-column-ratio='" . $column_ratio . "'>
                            <div class='pull-left row-controller text-off font-16'>
                                <i class='fa fa-bars move'></i>
                                <i class='fa fa-times delete delete-widget-row'></i>
                            </div>
                            <div class = 'pull-left clearfix row-container'>";

                $columns = get_array_value((array) $element, "columns");

                if ($columns) {
                    foreach ($columns as $key => $value) {

                        $column_class_value = $this->_get_column_class_value($key, $columns, $column_ratio_explode);
                        $view .= "<div class = 'pr-0 widget-column col-md-" . $column_class_value . " col-sm-" . $column_class_value . "'>
                                    <div id = 'add-column-panel-" . rand(500, 10000) . "' class = 'add-column-panel add-column-drop text-center p-1'>";

                        foreach ($value as $content) {
                            $widget_value = get_array_value((array) $content, "widget");
                            $view .= $this->_make_widgets_row($content->screen, array($widget_value => get_array_value((array) $content, "title")));
                        }

                        $view .= "</div></div>";
                    }
                }
                $view .= "</div></row>";
            }
            return $view;
        }
    }


     private function _make_widgets_row($screen, $widgets_array = array()) {
        $widgets = "";


        foreach ($widgets_array as $key => $value) {

            $error_class = "";
            if (!is_numeric($key)) {
                $error_class = "error";
            }
            $widgets .= "<div data-value=" . $key . " data-screen=".$screen ." class='mb-1 widget border border-info clearfix p-1 bg-white $error_class' draggable='false'>" .
                    $this->_widgets_row_data(array($key => $value))
                    . "</div>";
        }

        if ($widgets) {
            return $widgets;
        } else {
            return "<span class='text-off empty-area-text'>Không có widget tồn tại</span>";
        }
    }


     private function _widgets_row_data($widget_array) {
        $key = key($widget_array);

        $value = $widget_array[key($widget_array)];
        $details_button = "";
        if (is_numeric($key)) {

            $widgets_title = $value;
            $details_button = modal(route("template.config_widget"), "<i class='fa fa-ellipsis-h'></i>", array("class" => "text-off pr-1 pl-1", "title" => 'custom_widget_details', "data-post-id" => $key));
        } else {
            $details_button = modal(route("template.config_widget"), "<i class='fa fa-ellipsis-h'></i>", array("class" => "text-off pr-1 pl-1", "title" => $key, "data-post-widget" => $key));
            $widgets_title = $value;
        }


        return "<span class='pull-left text-left'>" . $widgets_title . "</span>
                <span class='pull-right'>" . $details_button . "<i class='fa fa-arrows text-off'></i></span>";
    }*/

  /**
   * Update the specified resource in storage.
   * @param Request $request
   * @param int $id
   * @return Response
   */
  public function update(Request $request, $id)
  {
    if ($request->ajax()) {
      $this->template->update($id, $request->all());
      return Response::json(["success" => true], 200);
    }
  }

  /**
   * Remove the specified resource from storage.
   * @param int $id
   * @return Response
   */
  public function destroy(Request $request, $id)
  {
    $template = $this->template->find($id);
    $this->template->delete($id);
    event(new DeletedContentEvent($request->all(), $template));

    return Response::json(
      [
        "success" => true,
      ],
      200
    );
  }
}
