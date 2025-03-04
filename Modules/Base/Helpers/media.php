<?php
if (!function_exists("get_object_image")) {
  function get_object_image($image, $size = null, $relativePath = false)
  {
    if ($size == "thumb") {
      if ($image) {
        $image = str_replace("source", "thumbs", $image);
      } else {
        $image = "/images/default.png";
      }
    }

    return $image;
  }
}
