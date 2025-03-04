<?php

return [
  [
    "name" => "Menu",
    "flag" => "menu.index",
  ],
  [
    "name" => "Create",
    "flag" => "menu.create",
    "parent_flag" => "menu.index",
  ],
  [
    "name" => "Edit",
    "flag" => "menu.edit",
    "parent_flag" => "menu.index",
  ],
  [
    "name" => "Delete",
    "flag" => "menu.delete",
    "parent_flag" => "menu.index",
  ],
  [
    "name" => "Menu Item",
    "flag" => "menus.index",
  ],
  [
    "name" => "Create",
    "flag" => "menus.create",
    "parent_flag" => "menus.index",
  ],
  [
    "name" => "Edit",
    "flag" => "menus.edit",
    "parent_flag" => "menus.index",
  ],
  [
    "name" => "Delete",
    "flag" => "menus.delete",
    "parent_flag" => "menus.index",
  ],
  [
    "name" => "Delete Many",
    "flag" => "menus.deletes",
    "parent_flag" => "menus.index",
  ],
  [
    "name" => "Menu Node",
    "flag" => "menunode.index",
  ],
  [
    "name" => "Update sort",
    "flag" => "menunode.sort",
    "parent_flag" => "menunode.index",
  ],
  [
    "name" => "Import",
    "flag" => "menunode.import",
    "parent_flag" => "menunode.index",
  ],
  [
      "name" => "Add external url",
      "flag" => "menunode.addExternalUrl",
      "parent_flag" => "menunode.index",
    ],
  [
    "name" => "Modal",
    "flag" => "menunode.modal",
    "parent_flag" => "menunode.index",
  ],
  [
    "name" => "Update",
    "flag" => "menunode.update",
    "parent_flag" => "menunode.index",
  ],
  [
    "name" => "Delete",
    "flag" => "menunode.delete",
    "parent_flag" => "menunode.index",
  ],
];
