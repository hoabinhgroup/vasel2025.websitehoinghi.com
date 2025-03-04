<?php
if (!function_exists("recursiveUl")) {
  function recursiveUl($sourceArr, $parents = 0, $optionString, &$newMenu)
  {
    if (!empty($sourceArr) > 0) {
      $newMenu .= '<ul class="group-items">';

      foreach ($sourceArr as $key => $value) {
        if ($value->parent == $parents) {
          $id = $value->id;

          $newMenu .=
            '<li><input type="checkbox" class="checkbox_value" name="' .
            $value->name .
            '" id="' .
            $id .
            '" value="' .
            $id .
            '"> ' .
            $value->name .
            "</li>";

          $newParents = $id;

          unset($sourceArr[$key]);
          recursiveUl($sourceArr, $newParents, [], $newMenu);
        }
      }

      $newMenu .= "</ul>";
    }
  }
}

if (!function_exists("recursiveCategory")) {
  function recursiveCategory(
    $sourceArr,
    $parents = 0,
    $optionString = [],
    &$newMenu,
    $name = "categories[]"
  ) {
    if (!empty($sourceArr) > 0) {
      $newMenu .= '<ul class="group-items">';

      $checked = "";

      foreach ($sourceArr as $key => $value) {
        if ($value->parent == $parents) {
          $id = $value->id;

          if (!empty($optionString)) {
            if (in_array($id, $optionString)) {
              $checked .= " checked";
            } else {
              $checked = "";
            }
          }

          $newMenu .= "<li>";
          $newMenu .= '<div class="pretty p-icon">';
          $newMenu .=
            '<input type="checkbox" class="ace" name="' .
            $name .
            '" value="' .
            $id .
            '" ' .
            $checked .
            ">";
          $newMenu .=
            '<div class="state"><i class="icon fa fa-check"></i><label>' .
            $value->name .
            "</label></div>";
          $newMenu .= "</div>";
          $newMenu .= "</li>";

          //	 $newMenu .= '<li><input type="checkbox" class="checkbox_value" name="'. $name .'" id="' . $id . '" value="' . $id .'" '.$checked.'> ' . $value->name . '</li>';

          $newParents = $id;

          unset($sourceArr[$key]);
          recursiveCategory(
            $sourceArr,
            $newParents,
            $optionString,
            $newMenu,
            $name
          );
        }
      }

      $newMenu .= "</ul>";
    }
  }
}
