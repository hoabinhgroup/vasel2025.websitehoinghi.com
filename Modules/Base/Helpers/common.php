<?php

use Modules\Base\Facades\PanelMenuFacade;
use Modules\Base\Facades\PageTitleFacade;
use Modules\Base\Supports\PageTitle;
use Modules\Setting\Facades\SettingFacade;
use Modules\Setting\Entities\Setting;

if (!function_exists("___wejns_wp_whitespace_fix")) {
  function ___wejns_wp_whitespace_fix($input)
  {
    /* valid content-type? */
    $allowed = false;

    /* found content-type header? */
    $found = false;

    /* we mangle the output if (and only if) output type is text/* */
    foreach (headers_list() as $header) {
      if (
        preg_match(
          "/^content-type:\\s+(text\\/|application\\/((xhtml|atom|rss)\\+xml|xml))/i",
          $header
        )
      ) {
        $allowed = true;
      }

      if (preg_match("/^content-type:\\s+/i", $header)) {
        $found = true;
      }
    }

    /* do the actual work */
    if ($allowed || !$found) {
      return preg_replace("/\\A\\s*/m", "", $input);
    } else {
      return $input;
    }
  }
}
/* start output buffering using custom callback */
ob_start("___wejns_wp_whitespace_fix");

if (!function_exists("domain")) {
  function domain()
  {
    return request()->getSchemeAndHttpHost();
  }
}

if (!function_exists("getBaseDefaultLanguage")) {
  function getBaseDefaultLanguage($select = ["*"])
  {
    if (is_plugin_active("Languages")) {
      $data = getDefaultLanguage($select);
    } else {
      $data = setting("main_language");
    }

    return $data;
  }
}

if (!function_exists("getBaseDefaultLocaleCode")) {
  function getBaseDefaultLocaleCode($select = ["*"])
  {
    if (is_plugin_active("Languages")) {
      $locale_code = getDefaultLanguage($select)->lang_locale;
    } else {
      $locale_code = setting("main_language");
    }

    return $locale_code;
  }
}



if (! function_exists('human_file_size')) {

  function human_file_size(float $bytes, int $precision = 2): string
  {
    $units = ['B', 'kB', 'MB', 'GB', 'TB'];

    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);

    $bytes /= pow(1024, $pow);

    return number_format($bytes, $precision, ',', '.') . ' ' . $units[$pow];
  }
}

function check_database_connection()
{
  try {
    DB::connection()->getPdo();
  } catch (\Exception $e) {
    die("Could not connect to the database.  Please check your configuration. error:" .
      $e);
  }
}

if (!function_exists("getClientIp")) {
  function getClientIp()
  {
    $ipaddress = "";

    if (isset($_SERVER["HTTP_CLIENT_IP"])) {
      $ipaddress = $_SERVER["HTTP_CLIENT_IP"];
    } elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
      $ipaddress = $_SERVER["HTTP_X_FORWARDED_FOR"];
    } elseif (isset($_SERVER["HTTP_X_FORWARDED"])) {
      $ipaddress = $_SERVER["HTTP_X_FORWARDED"];
    } elseif (isset($_SERVER["HTTP_FORWARDED_FOR"])) {
      $ipaddress = $_SERVER["HTTP_FORWARDED_FOR"];
    } elseif (isset($_SERVER["HTTP_FORWARDED"])) {
      $ipaddress = $_SERVER["HTTP_FORWARDED"];
    } elseif (isset($_SERVER["REMOTE_ADDR"])) {
      $ipaddress = $_SERVER["REMOTE_ADDR"];
    }

    return $ipaddress;
  }
}

if (!function_exists("account_sending_email_setting")) {
  function account_sending_email_setting($options = [])
  {
    if (empty($options)) {
      $config = [
        'driver' => 'smtp',
        'host' => setting('email_host'),
        'port' => setting('email_port'),
        'from' => [
          'address' => setting('email_from_address'),
          'name' => setting('email_from_name'),
        ],
        'encryption' => setting('email_encryption'),
        'username' => setting('email_username'),
        'password' => setting('email_password'),
        'sendmail' => '/usr/sbin/sendmail -bs',
        'pretend' => false,
      ];
    } else {
      $config =  $options;
    }

    \Config::set('mail', $config);
  }
}

if (!function_exists("platform_path")) {
  /**
   * @param string|null $path
   * @return string
   */
  function platform_path($path = null): string
  {
    return base_path("Modules/" . $path);
  }
}

if (!function_exists("get_array_value")) {
  /**
   * @param $limit
   * @return mixed
   * @author Tuan Louis
   */
  function get_array_value(array $array, $key)
  {
    if (array_key_exists($key, $array)) {
      return $array[$key];
    }
  }
}

if (!function_exists("is_backend")) {
  /**
   * @return bool
   */
  function is_backend()
  {
    $segment = request()->segment(1);
    if ($segment === config("base.admin_dir")) {
      return true;
    }

    return false;
  }
}

if (!function_exists("page_title")) {
  /**
   * @return PageTitle
   */
  function page_title()
  {
    return PageTitleFacade::getFacadeRoot();
  }
}

if (!function_exists("js_anchor")) {
  /**
   * @param $limit
   * @return mixed
   * @author Tuan Louis
   */
  function js_anchor($title = "", $attributes = "", $href = "#")
  {
    $title = (string) $title;
    $html_attributes = "";

    if (is_array($attributes)) {
      foreach ($attributes as $key => $value) {
        $html_attributes .= " " . $key . '="' . $value . '"';
        // $html_attributes .= ' ' . $key . '=' . $value . '';
      }
    }

    return '<a href="' . $href . '"' . $html_attributes . ">" . $title . "</a>";
  }
}

if (!function_exists("modal")) {
  /**
   * @param $limit
   * @return mixed
   * @author Tuan Louis
   */
  function modal($url, $title = "", $attributes = "")
  {
    $attributes["data-act"] = "ajax-modal";
    if (get_array_value($attributes, "data-modal-title")) {
      $attributes["data-title"] = get_array_value(
        $attributes,
        "data-modal-title"
      );
    } else {
      $attributes["data-title"] = get_array_value($attributes, "title");
    }
    $attributes["data-action-url"] = $url;

    return js_anchor($title, $attributes);
  }
}

if (!function_exists("getRandomCode")) {
  /**
   * @param $limit
   * @return mixed
   * @author Tuan Louis
   */
  function getRandomCode($length)
  {
    $random = "";
    $characters = [
      "A",
      "B",
      "C",
      "D",
      "E",
      "F",
      "G",
      "H",
      "J",
      "K",
      "L",
      "M",
      "N",
      "P",
      "Q",
      "R",
      "S",
      "T",
      "U",
      "V",
      "W",
      "X",
      "Y",
      "Z",
      "a",
      "b",
      "c",
      "d",
      "e",
      "f",
      "g",
      "h",
      "i",
      "j",
      "k",
      "m",
      "n",
      "o",
      "p",
      "q",
      "r",
      "s",
      "t",
      "u",
      "v",
      "w",
      "x",
      "y",
      "z",
      "1",
      "2",
      "3",
      "4",
      "5",
      "6",
      "7",
      "8",
      "9",
    ];

    $keys = [];

    while (count($keys) < $length) {
      $x = mt_rand(0, count($characters) - 1);
      if (!in_array($x, $keys)) {
        $keys[] = $x;
      }
    }

    foreach ($keys as $key) {
      $random .= $characters[$key];
    }

    return $random;
  }
}

if (!function_exists("panel_menu")) {
  /**
   * @return \Modules\Base\Supports\PanelMenu
   */
  function panel_menu()
  {
    return PanelMenuFacade::getFacadeRoot();
  }
}


if (!function_exists("html_escape")) {
  /**
   * Returns HTML escaped variable.
   *
   * @param	mixed	$var		The input string or array of strings to be escaped.
   * @param	bool	$double_encode	$double_encode set to FALSE prevents escaping twice.
   * @return	mixed			The escaped string or array of strings as a result.
   */
  function html_escape($var, $double_encode = true)
  {
    if (empty($var)) {
      return $var;
    }

    if (is_array($var)) {
      foreach (array_keys($var) as $key) {
        $var[$key] = html_escape($var[$key], $double_encode);
      }

      return $var;
    }

    return htmlspecialchars($var, ENT_QUOTES, "UTF-8", $double_encode);
  }
}

if (!function_exists("_parse_form_attributes")) {
  /**
   * Parse the form attributes
   *
   * Helper function used by some of the form helpers
   *
   * @param	array	$attributes	List of attributes
   * @param	array	$default	Default values
   * @return	string
   */
  function _parse_form_attributes($attributes, $default)
  {
    if (is_array($attributes)) {
      foreach ($default as $key => $val) {
        if (isset($attributes[$key])) {
          $default[$key] = $attributes[$key];
          unset($attributes[$key]);
        }
      }

      if (count($attributes) > 0) {
        $default = array_merge($default, $attributes);
      }
    }

    $att = "";

    foreach ($default as $key => $val) {
      if ($key === "value") {
        $val = html_escape($val);
      } elseif ($key === "name" && !strlen($default["name"])) {
        continue;
      }

      $att .= $key . '="' . $val . '" ';
    }

    return $att;
  }
}

if (!function_exists("_attributes_to_string")) {
  /**
   * Attributes To String
   *
   * Helper function used by some of the form helpers
   *
   * @param	mixed
   * @return	string
   */
  function _attributes_to_string($attributes)
  {
    if (empty($attributes)) {
      return "";
    }

    if (is_object($attributes)) {
      $attributes = (array) $attributes;
    }

    if (is_array($attributes)) {
      $atts = "";

      foreach ($attributes as $key => $val) {
        $atts .= " " . $key . '="' . $val . '"';
      }

      return $atts;
    }

    if (is_string($attributes)) {
      return " " . $attributes;
    }

    return false;
  }
}

if (!function_exists("selectbox")) {
  function selectbox(
    $name,
    $value = null,
    $options,
    $default = "None",
    $attribs = []
  ) {
    $strAttribs = "";
    if (count($attribs) > 0) {
      foreach ($attribs as $key => $val) {
        $strAttribs .= $key . ' = "' . $val . '"';
      }
    }

    $xhtml =
      '<select name="' . $name . '" id="' . $name . '" ' . $strAttribs . ">";
    $xhtml .=
      '<option label="' . $default . '" value="0">' . $default . "</option>";
    foreach ($options as $key => $info):
      $strSelect = "";
      if (in_array($info["id"], $value)) {
        $strSelect = ' selected="selected"';
      }

      $xhtml .=
        '<option value="' .
        $info["id"] .
        '" ' .
        $strSelect .
        "> " .
        $info["name"] .
        "</option>";
    endforeach;
    $xhtml .= "</select>";

    return $xhtml;
  }
}

if (!function_exists("dropdown")) {
  function dropdown(
    $name,
    $value = null,
    $options,
    $default = "None",
    $attribs = []
  ) {
    $strAttribs = "";
    if (count($attribs) > 0) {
      foreach ($attribs as $key => $val) {
        $strAttribs .= $key . ' = "' . $val . '"';
      }
    }

    $xhtml =
      '<select name="' . $name . '" id="' . $name . '" ' . $strAttribs . ">";
    $xhtml .=
      '<option label="' . $default . '" value="0">' . $default . "</option>";
    foreach ($options as $key => $info):
      $strSelect = "";
      if (in_array($info["id"], $value)) {
        $strSelect = ' selected="selected"';
      }

      if ($info["level"] == 1) {
        $xhtml .=
          '<option value="' .
          $info["id"] .
          '" ' .
          $strSelect .
          "> " .
          $info["name"] .
          "</option>";
      } else {
        $string = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
        $newString = "";
        for ($i = 1; $i < $info["level"]; $i++) {
          $newString .= $string;
        }
        $name = $newString . "-" . $info["name"];
        $xhtml .=
          ' <option label="' .
          $info["name"] .
          '" value="' .
          $info["id"] .
          '" ' .
          $strSelect .
          ">" .
          $name .
          "</option>";
      }
    endforeach;
    $xhtml .= "</select>";

    return $xhtml;
  }
}

if (!function_exists("tinymce")) {
  function tinymce($selector = "[name=content]")
  {
    // $key = Session::get("akey");
    return "<script>
      $(document).ready(function(){
                  tinymce.init({
                  selector:'[class=tinymce]',
                  document_base_url: '/',
                  relative_urls: true,
                  remove_script_host: true,
                  setup: function(editor) {
                  editor.on('GetContent', function(event) {
                  event.content = event.content.replace(/href=\"\/([^\"]+)\"/g, 'href=\"$1\"');
                    });
                  },
                  verify_html: false,
                  valid_children: '+body[style],h3[style],h3[br],h3[em],h3[strong],h3[span],h3[adiv],h3[ap],i[*],span[*]',
                  branding: false,
                  plugins: [
    'advlist autolink lists link image charmap print preview anchor',
    'searchreplace visualblocks codesample code fullscreen',
    'insertdatetime media table contextmenu paste textcolor responsivefilemanager'
	 ],
      protect: [
          /<\?php[\\s\\S]*?\?>/g // Protect php code
      ],
      codesample_languages: [
          {text: 'HTML/XML', value: 'markup'},
          {text: 'JavaScript', value: 'javascript'},
          {text: 'CSS', value: 'css'},
          {text: 'PHP', value: 'php'},
          {text: 'Ruby', value: 'ruby'},
          {text: 'Python', value: 'python'},
          {text: 'Java', value: 'java'},
          {text: 'C', value: 'c'},
          {text: 'C#', value: 'csharp'},
          {text: 'C++', value: 'cpp'}
      ],
      codesample_global_prismjs: true,
	toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify inlineCode | bullist numlist outdent indent | link image | styleselect fontselect | forecolor backcolor | responsivefilemanager | fullscreen | codesample',
	entity_encoding : 'raw',
	relative_urls: false,
	height: 350
                  });
                 });</script>";
  }
}


if (!function_exists("ckeditor")) {
  function ckeditor($selector = '#content')
  {
    $key = Session::get("akey");
    $selector = '#content';
    return "<script>
    $(document).ready(function(){
             ClassicEditor
             .create( document.querySelector( '#content' ) )
             .then( editor => {
                     console.log( editor );
             } )
             .catch( error => {
                     console.error( error );
             } );

                 });</script>";
  }
}

if (!function_exists("tinymceBasic")) {
  function tinymceBasic($selector = "[name=content]")
  {

    return "<script>
                $(document).ready(function(){
                 tinymce.init({
                   selector: 'textarea',
                   branding: false,
                   menubar: false,
                   plugins: 'code link fullscreen',
                   toolbar: 'bold italic underline | code | link | styleselect | fullscreen'
                 });
           });</script>";
  }
}

if (!function_exists("get_file_json")) {
  /**
   * @param $file
   * @param $convert_to_array
   * @return bool|mixed
   * @author Tuan Louis
   * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
   */
  function get_file_json($file, $convert_to_array = true)
  {
    $file = File::get($file);
    if (!empty($file)) {
      if ($convert_to_array) {
        return json_decode($file, true);
      } else {
        return $file;
      }
    }
    if (!$convert_to_array) {
      return null;
    }
    return [];
  }
}

if (!function_exists("get_file_data")) {
  /**
   * @param string $file
   * @param bool $toArray
   * @return bool|mixed
   * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
   */
  function get_file_data($file, $toArray = true)
  {
    $file = File::get($file);
    if (!empty($file)) {
      if ($toArray) {
        return json_decode($file, true);
      }
      return $file;
    }
    if (!$toArray) {
      return null;
    }
    return [];
  }
}

if (!function_exists("scan_folder")) {
  /**
   * @param $path
   * @param array $ignore_files
   * @return array
   * @author Tuan Louis
   */
  function scan_folder($path, $ignore_files = [])
  {
    try {
      if (is_dir($path)) {
        $data = array_diff(
          scandir($path),
          array_merge([".", ".."], $ignore_files)
        );
        natsort($data);
        return $data;
      }
      return [];
    } catch (Exception $ex) {
      return [];
    }
  }
}

if (!function_exists("array_to_obj")) {
  function array_to_obj(array $array, &$obj)
  {
    foreach ($array as $key => $value) {
      if (is_array($value)) {
        $obj->$key = new stdClass();
        array_to_obj($value, $obj->$key);
      } else {
        $obj->$key = $value;
      }
    }
    return $obj;
  }
}

if (!function_exists("arrayToObject")) {
  function arrayToObject($array)
  {
    $object = new stdClass();
    return array_to_obj($array, $object);
  }
}

if (!function_exists("object_to_array")) {
  function object_to_array($data)
  {
    if (!is_array($data) and !is_object($data)) {
      return $data;
    } // $data;

    $result = [];

    $data = (array) $data;
    foreach ($data as $key => $value) {
      if (is_object($value)) {
        $value = (array) $value;
      }
      if (is_array($value)) {
        $result[$key] = object_to_array($value);
      } else {
        $result[$key] = $value;
      }
    }
    return $result;
  }
}
