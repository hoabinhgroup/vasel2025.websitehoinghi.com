<?php

Route::get("sitemap.xml", [
  "as" => "public.sitemap",
  "uses" => "PublicController@getSiteMap",
]);
