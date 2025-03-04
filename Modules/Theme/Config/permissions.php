<?php

return [
  [
    "name" => "Themes",
    "flag" => "theme.index",
  ],
  [
    "name" => "Themes active",
    "flag" => "theme.active",
    "parent_flag" => "theme.index",
  ],
  [
    "name" => "Themes Options",
    "flag" => "theme.options",
    "parent_flag" => "theme.index",
  ],
  [
    "name" => "Update options",
    "flag" => "theme.options.update",
    "parent_flag" => "theme.index",
  ],
];
