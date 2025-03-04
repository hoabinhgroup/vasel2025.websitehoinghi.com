<?php

if (!defined("BACKEND")) {
  define("BACKEND", "cmspanel");
}


if (!defined('WIDGET_LIST')) {
    define('WIDGET_LIST', 'show_widget_list');
}

// change data show in front page
if (!defined("BASE_FILTER_BEFORE_GET_FRONT_PAGE_ITEM")) {
  define(
    "BASE_FILTER_BEFORE_GET_FRONT_PAGE_ITEM",
    "before_get_front_page_item"
  );
}

if (!defined("BASE_FILTER_ENUM_LABEL")) {
  define("BASE_FILTER_ENUM_LABEL", "base_filter_enum_label");
}

if (!defined("BASE_FILTER_ENUM_ARRAY")) {
  define("BASE_FILTER_ENUM_ARRAY", "base_filter_enum_array");
}

if (!defined("BASE_FILTER_ENUM_HTML")) {
  define("BASE_FILTER_ENUM_HTML", "base_filter_enum_html");
}

if (!defined("BASE_FILTER_GROUP_PUBLIC_ROUTE")) {
  define("BASE_FILTER_GROUP_PUBLIC_ROUTE", "group_public_route");
}

if (!defined("BASE_FILTER_TOP_HEADER_LAYOUT")) {
  define("BASE_FILTER_TOP_HEADER_LAYOUT", "filter_top_header_layout");
}

if (!defined('BASE_ACTION_ENQUEUE_SCRIPTS')) {
  define('BASE_ACTION_ENQUEUE_SCRIPTS', 'base_action_enqueue_scripts');
}

if (!defined('BASE_FILTER_DASHBOARD_MENU')) {
  define('BASE_FILTER_DASHBOARD_MENU', 'base_filter_dashboard_menu');
}

if (!defined('BASE_FILTER_APPEND_MENU_NAME')) {
  define('BASE_FILTER_APPEND_MENU_NAME', 'base_filter_append_menu_name');
}

if (!defined('BASE_ACTION_PUBLIC_RENDER_SINGLE')) {
  define('BASE_ACTION_PUBLIC_RENDER_SINGLE', 'base_action_public_render_single');
}

if (!defined("BASE_FILTER_PUBLIC_SINGLE_DATA")) {
  define("BASE_FILTER_PUBLIC_SINGLE_DATA", "filter_public_single_data");
}

if (!defined("BASE_FILTER_BEFORE_GET_ADMIN_LIST_ITEM")) {
  define(
    "BASE_FILTER_BEFORE_GET_ADMIN_LIST_ITEM",
    "before_get_admin_list_item"
  );
}

if (!defined("BASE_ACTION_AFTER_CREATE_CONTENT")) {
  define("BASE_ACTION_AFTER_CREATE_CONTENT", "action_after_create_content");
}

if (!defined("BASE_ACTION_AFTER_UPDATE_CONTENT")) {
  define("BASE_ACTION_AFTER_UPDATE_CONTENT", "action_after_update_content");
}

if (!defined("BASE_ACTION_TOP_FORM_CONTENT_NOTIFICATION")) {
  define(
    "BASE_ACTION_TOP_FORM_CONTENT_NOTIFICATION",
    "base_top_form_content_notification"
  );
}

if (!defined("BASE_FILTER_FORM_EDITOR_BUTTONS")) {
  define("BASE_FILTER_FORM_EDITOR_BUTTONS", "base_filter_form_editor_buttons");
}

if (!defined("BASE_FILTER_BEFORE_GET_LIST_ITEM")) {
  define("BASE_FILTER_BEFORE_GET_LIST_ITEM", "before_get_list_item");
}

if (!defined("BASE_FILTER_APPEND_MENU_NAME")) {
  define("BASE_FILTER_APPEND_MENU_NAME", "base_filter_append_menu_name");
}

if (!defined("BASE_FILTER_CONTENT_TAB")) {
  define("BASE_FILTER_CONTENT_TAB", "base_filter_content_tab");
}

if (!defined("BASE_FILTER_BEFORE_GET_SINGLE")) {
  define("BASE_FILTER_BEFORE_GET_SINGLE", "base_filter_before_get_single");
}

if (!defined("BASE_FILTER_BEFORE_GET_ADMIN_SINGLE")) {
  define(
    "BASE_FILTER_BEFORE_GET_ADMIN_SINGLE",
    "base_filter_before_get_admin_single"
  );
}

if (!defined("BASE_ACTION_META_BOXES")) {
  define("BASE_ACTION_META_BOXES", "base_action_meta_box");
}

if (!defined('BASE_FILTER_GET_LIST_DATA')) {
  define('BASE_FILTER_GET_LIST_DATA', 'get_list_data');
}

if (!defined("BASE_FILTER_TABLE_BUTTONS")) {
  define("BASE_FILTER_TABLE_BUTTONS", "base_filter_table_buttons");
}

if (!defined("BASE_ACTION_BEFORE_EDIT_CONTENT")) {
  define("BASE_ACTION_BEFORE_EDIT_CONTENT", "base_action_before_edit_content");
}

if (!defined("BASE_FILTER_TABLE_QUERY")) {
  define("BASE_FILTER_TABLE_QUERY", "base_filter_table_query");
}

if (!defined("BASE_FILTER_BEFORE_RENDER_FORM")) {
  define("BASE_FILTER_BEFORE_RENDER_FORM", "base_filter_before_render_form");
}

if (!defined("BASE_FILTER_AFTER_SETTING_CONTENT")) {
  define(
    "BASE_FILTER_AFTER_SETTING_CONTENT",
    "base_filter_after_setting_content"
  );
}

if (!defined("BASE_FILTER_EMAIL_AFTER_SETTING_CONTENT")) {
  define(
    "BASE_FILTER_EMAIL_AFTER_SETTING_CONTENT",
    "base_filter_email_after_setting_content"
  );
}

if (!defined("BASE_ACTION_SITE_ERROR")) {
  define("BASE_ACTION_SITE_ERROR", "base_action_site_error");
}
