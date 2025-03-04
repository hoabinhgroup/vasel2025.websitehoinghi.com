<?php
if (!function_exists('randomString')) {
  function randomString($length = 10)
  {
    $characters =
      '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
      $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
  }
}

// if (!function_exists('parseContent')) {
//   function parseContent($template, $array)
//   {
//     $template = htmlspecialchars_decode($template, ENT_QUOTES);
//     $template = preg_replace_callback(
//       "#{([a-z_]+)}#i",
//       function ($data) use ($array) {
//         return isset($array[$data[1]]) ? $array[$data[1]] : $data[1];
//       },
//       $template
//     );
//     return $template;
//   }
// }
