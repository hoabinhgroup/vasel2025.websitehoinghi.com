<?php

Form::macro("status", function (
  $name,
  $value,
  $default_value = false,
  $label = "base::form.status"
) {
  $html = "";
  $html .= view(
    "base::macro.status",
    compact("name", "value", "default_value", "label")
  )->render();
  return $html;
});

Form::macro("save", function ($label = "base::form.publish") {
  $html = "";
  $html .= view("base::macro.save", compact("label"))->render();
  return $html;
});

Form::macro("onlysave", function ($label = "base::macro.onlysave") {
  $html = "";
  $html .= view($label, compact("label"))->render();
  return $html;
});

Form::macro("tinyMCE", function (
  $name,
  $selected = null,
  $options = [],
  $selector = "[name=content]"
) {
  Assets::add(
    request()->getSchemeAndHttpHost() . "/editor/tinymce/tinymce.min.js"
  );

  Assets::addJs(request()->getSchemeAndHttpHost() . "/js/editor.js?v=1.2");
  //add codehightlight
  Assets::addCss(request()->getSchemeAndHttpHost() . "/prism/prism.css");
  Assets::addJs(request()->getSchemeAndHttpHost() . "/prism/prism.js");

  $textarea = $this->textarea($name, $selected, $options);
  if ($options['class'] == 'tinymce-basic') {
    $textarea .= tinymceBasic($selector);
  } else {
    $textarea .= tinymce($selector);
  }
  return $textarea;
});


Form::macro("ckeditor", function (
  $name,
  $selected = null,
  $options = [],
  $selector = "#content"
) {

  Assets::addJs(
    domain() . "/js/ckeditor.js"
  );

  // Assets::addJs(request()->getSchemeAndHttpHost() . "/js/editor.js");
  // //add codehightlight
  // Assets::addCss(request()->getSchemeAndHttpHost() . "/prism/prism.css");
  // Assets::addJs(request()->getSchemeAndHttpHost() . "/prism/prism.js");

  $textarea = $this->textarea($name, $selected, $options);
  $textarea .= ckeditor($selector);
  return $textarea;
});

Form::macro("multiCheckboxRecursive", function (
  $name,
  $source,
  $default_value = [],
  $label = "base::form.categories"
) {
  $html = "";
  $html .= view(
    "base::macro.multiCheckboxRecursive",
    compact("name", "source", "default_value", "label")
  )->render();
  return $html;
});

Form::macro("cover", function (
  $name,
  $value = null,
  $title = "base::form.cover"
) {
  $html = "";
  Assets::add([
    "https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css",
    "https://code.jquery.com/jquery-migrate-3.0.1.js",
    "https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js",
  ]);
  if (!$value) {
    $value = "/images/default.png";
  } else {
    $value = str_replace(request()->getSchemeAndHttpHost(), "", $value);
  }
  $key = \Session::get("akey");
  /* $html = '<a href="/filemanager/dialog.php?type=1&field_id=txt-image&akey=' . $key . '&callback=responsive_filemanager_callback" class="iframe-btn mt-1" id="upload_cover">';
     $html.= '<input type="hidden" name="'.$name.'" id="txt-image-hidden" value="'.$value.'" />';
     $html.= '<img width="100%" id="txt-image" src="'.$value.'" />';
     $html.= '</a>';
     $html.= '<a onclick="deleteImage()" class="text-danger"> Xoá</a>';*/
  $html .= view(
    "base::macro.cover",
    compact("name", "value", "title")
  )->render();

  return $html;
});

Form::macro("single", function (
  $name,
  $value = null,
  $title = "base::form.single"
) {
  $html = "";
  if (!$value) {
    $value = "images/default-thumbnail.png";
  } else {
    $value = str_replace(request()->getSchemeAndHttpHost(), "", $value);
  }

  $html .= view(
    "base::macro.single",
    compact("name", "value", "title")
  )->render();

  return $html;
});



Form::macro("recursive", function (
  $name,
  $data,
  $selected = [],
  $args = [],
  $label = "ecommerce::catalog.list"
) {
  $options = array_merge(
    [
      "class" => "chosen-select form-control w200",
    ],
    $args
  );

  $html = "";
  //$domain = 'http://'.request()->getHost();
  /*Assets::add([
		    $domain . '/assets/css/jquery-ui.custom.css',
		    $domain . '/assets/css/chosen.css',
		    $domain . '/assets/js/chosen.jquery.js'
	    ]);
	    */

  //$html.= $this->select($name, $data, $selected, $options);
  $html .= view(
    "base::macro.recursive",
    compact("name", "data", "selected", "options", "label")
  )->render();

  return $html;
});

Form::macro("chosen", function (
  $name,
  $label,
  $data,
  $selected = null,
  $args = []
) {
  $options = array_merge(
    [
      "class" => "chosen-select form-control",
      "style" => "width: 100%",
    ],
    $args
  );

  $html = "";
  $domain = request()->getSchemeAndHttpHost();
  Assets::add([
    $domain . "/assets/css/jquery-ui.custom.css",
    $domain . "/assets/css/chosen.css",
    $domain . "/assets/js/bootstrap-multiselect.js",
    $domain . "/assets/js/chosen.jquery.js",
  ]);

  //$html.= $this->select($name, $data, $selected, $options);
  $html .= view(
    "base::macro.chosen",
    compact("name", "label", "data", "selected", "options")
  )->render();

  return $html;
});
