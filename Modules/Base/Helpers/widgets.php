<?php
if (!function_exists("make_template")) {
  function make_template($elements)
  {
    $view = "";
    if ($elements) {
      foreach ($elements as $element) {
        $view .= "<div class='container-row clearfix row'>";

        $columns = get_array_value((array) $element, "columns");
        $column_ratio = explode(
          "-",
          get_array_value((array) $element, "ratio")
        );

        if ($columns) {
          foreach ($columns as $key => $value) {
            $view .=
              "<div class='widget-container col-md-" .
              _get_column_class_value($key, $columns, $column_ratio) .
              "'>";
            //dd(json_decode($value[1]->config));
            foreach ($value as $content) {
              $content->config = $content->config ? $content->config : "";

              $widget = get_array_value((array) $content, "widget");
            
              if ($widget) {
                if (
                  view()->exists(
                    $content->screen .
                      "::widgets." .
                      Str::snake($content->widget)
                  )
                ) {
                  $view_template = is_backend() ? 'backend' : 'frontend';
                  $view .= view("template::partials." . $view_template, [
                    "content" => $content,
                  ])->render();
                }
              }
            }
            $view .= "</div>";
          }
        }

        $view .= "</div>";
      }
      return $view;
    }
  }
}

if (!function_exists("displayWidgetListByModule")) {
  function displayWidgetListByModule($module, $template_id)
  {
    $view = "";
    $widget_list = [];
    $widget_array = [];
    if ($template_id) {
      $template = app(
        \Modules\Template\Repositories\TemplateInterface::class
      )->find($template_id);
      $show_widget_list = json_decode($template->data);

      foreach ($show_widget_list as $key_column => $columns):
        foreach ($columns->columns as $column):
          $column = $column[0];
          $widget_list[$column->widget] = $column->title;
        endforeach;
      endforeach;
    }

    $widgetDir = __DIR__ . "/../../" . ucfirst($module) . "/Widgets/";
    $scanwidgetDir = glob("$widgetDir*");

    foreach ($scanwidgetDir as $widgetFile) {
      $widgetNameScan = lcfirst(basename($widgetFile, ".php"));
      $widget_array[$widgetNameScan] = Lang::get(
        $module . "::widget." . $widgetNameScan
      );
    }

    // $widget_filter = array_diff_key($widget_array, $widget_list);

    foreach ($widget_array as $key => $widget):
      $view .= _make_widgets_row($module, [$key => $widget]);
    endforeach;

    echo $view;
  }
}

if (!function_exists("_get_column_class_value")) {
  function _get_column_class_value($key, $columns, $column_ratio)
  {
    $columns_array = [1 => 12, 2 => 6, 3 => 4, 4 => 3];

    $column_count = count($columns);
    $column_ratio_count = count($column_ratio);

    $class_value = $column_ratio[$key];

    if ($column_count < $column_ratio_count) {
      $class_value = $columns_array[$column_count];
    }

    return $class_value;
  }
}

if (!function_exists("_make_editable_rows")) {
  function _make_editable_rows($elements)
  {
    $view = "";

    if ($elements) {
      foreach ($elements as $element) {
        $column_ratio = get_array_value((array) $element, "ratio");
        $column_ratio_explode = explode("-", $column_ratio);

        $view .=
          "<row class='widget-row clearfix block bg-white' data-column-ratio='" .
          $column_ratio .
          "'>
                            <div class='pull-left row-controller text-off font-16'>
                                <i class='fa fa-bars move'></i>
                                <i class='fa fa-times delete delete-widget-row'></i>
                            </div>
                            <div class = 'pull-left clearfix row-container'>";

        $columns = get_array_value((array) $element, "columns");

        if ($columns) {
          foreach ($columns as $key => $value) {
            $column_class_value = _get_column_class_value(
              $key,
              $columns,
              $column_ratio_explode
            );
            $view .=
              "<div class = 'pr-0 widget-column col-md-" .
              $column_class_value .
              " col-sm-" .
              $column_class_value .
              "'>
                                    <div id = 'add-column-panel-" .
              rand(500, 10000) .
              "' class = 'add-column-panel add-column-drop text-center p-1'>";

            foreach ($value as $content) {
              $config = isset($content->config)
                ? strip_tags($content->config)
                : "";
              $widget_value = get_array_value((array) $content, "widget");
              $view .= _make_widgets_row(
                $content->screen,
                [$widget_value => get_array_value((array) $content, "title")],
                $config
              );
            }

            $view .= "</div></div>";
          }
        }
        $view .= "</div></row>";
      }
      return $view;
    }
  }
}

if (!function_exists("_make_widgets_row")) {
  function _make_widgets_row($screen, $widgets_array = [], $config = "")
  {
    $widgets = "";

    foreach ($widgets_array as $key => $value) {
      $error_class = "";
      if (!is_numeric($key)) {
        $error_class = "error";
      }
      $widgets .=
        "<div id='element_" .
        $key .
        "' data-value=" .
        $key .
        " data-screen=" .
        $screen .
        " data-config='" .
        $config .
        "'   class='mb-1 widget border border-info clearfix p-1 bg-white $error_class'>" .
        _widgets_row_data([$key => $value], $config, $screen) .
        "</div>";
    }

    if ($widgets) {
      return $widgets;
    } else {
      return "<span class='text-off empty-area-text'>Không có widget tồn tại</span>";
    }
  }
}

if (!function_exists("_widgets_row_data")) {
  function _widgets_row_data($widget_array, $config = "", $screen = "")
  {
    $key = key($widget_array);

    $value = $widget_array[key($widget_array)];

    $details_button = "";
    if (is_numeric($key)) {
      $widgets_title = $value;
      $details_button = modal(
        route("template.config_widget"),
        "<i class='fa fa-cog bigger-130'></i>",
        [
          "class" => "text-off pr-1 pl-1",
          "title" => "custom_widget_details",
          "data-post-id" => $key,
        ]
      );
    } else {
      if ($config) {
        $details_button =
          "<a href='#' class='text-off pr-1 pl-1' title='" .
          $key .
          "' data-post-widget='" .
          $key .
          "' data-post-screen='" .
          $screen .
          "' data-post-element='" .
          $key .
          "' data-post-config='" .
          $config .
          "' data-act='ajax-modal' data-title='" .
          $value .
          "' data-action-url='" .
          route("template.config_widget") .
          "'><i class='fa fa-cog bigger-130'></i></a>";
      } else {
        $details_button = modal(
          route("template.config_widget"),
          "<i class='fa fa-cog bigger-130'></i>",
          [
            "class" => "text-off pr-1 pl-1",
            "title" => $value,
            "data-post-widget" => $key,
            "data-post-screen" => $screen,
            "data-post-element" => $key,
          ]
        );
      }

      $widgets_title = $value;
    }

    return "<span class='pull-left text-left'>" .
      $widgets_title .
      "</span>
                <span class='pull-right'>" .
      $details_button .
      "<i class='fa fa-times text-off delete-widget bigger-130'></i></span>";
  }
}
