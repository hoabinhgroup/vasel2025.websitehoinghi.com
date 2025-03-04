<?php

namespace Modules\Theme\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Base\Http\Responses\BaseHttpResponse;
use Shipu\Themevel\Contracts\ThemeContract;
//use Modules\Theme\Contracts\ThemeContract;
use Modules\Setting\Repositories\SettingInterface;
use Theme;
use Setting;
use Assets;
use ThemeOption;

class ThemeController extends Controller
{
  private $theme;

  protected $setting;

  public function __construct(SettingInterface $setting)
  {
    $this->setting = $setting;
  }

  /**
   * @return Factory|View
   */
  public function getOptions()
  {
    page_title()->setTitle(__("theme::theme.theme_options"));

    // $domain = "http://" . request()->getHost();
    Assets::add([
      domain() . "/vendor/core/theme/css/theme-options.css",
      // $domain .'/vendor/core/theme/js/theme-options.js'
    ]);

    return view("theme::options");
  }

  public function postUpdate(Request $request, BaseHttpResponse $response)
  {
    $sections = $request->all();
    foreach ($sections as $settingKey => $settingValue) {
      $key =
        "theme-" .
        setting("theme") .
        "-" .
        getBaseDefaultLocaleCode("lang_locale") .
        "-" .
        $settingKey;

      $this->setting->createOrUpdate(
        ["key" => $key, "value" => $settingValue],
        ["key" => $key]
      );
    }

    return $response->setMessage(__("base::notices.update_success_message"));
  }

  public function index(ThemeContract $theme)
  {
    page_title()->setTitle(__("theme::theme.list"));
    return view("theme::backend.list");
  }

  /**
   * Show the form for creating a new resource.
   * @return Response
   */
  public function create()
  {
    return view("theme::create");
  }

  /**
   * Store a newly created resource in storage.
   * @param Request $request
   * @return Response
   */
  public function store(Request $request)
  {
    //
  }

  /**
   * Show the specified resource.
   * @param int $id
   * @return Response
   */
  public function show($id)
  {
    return view("theme::show");
  }

  /**
   * Show the form for editing the specified resource.
   * @param int $id
   * @return Response
   */
  public function edit($id)
  {
    return view("theme::edit");
  }

  /**
   * Update the specified resource in storage.
   * @param Request $request
   * @param int $id
   * @return Response
   */
  public function update(Request $request, $id)
  {
    //
  }

  public function getActiveTheme($theme, BaseHttpResponse $response)
  {
    // Setting::set("theme", $theme);
    // Setting::save();
    $this->setting->createOrUpdate(
      ["key" => "theme", "value" => $theme],
      ["key" => "theme"]
    );
    return $response
      ->setNextUrl(route("theme.index"))
      ->setMessage("Kích hoạt thành công");
  }

  /**
   * Remove the specified resource from storage.
   * @param int $id
   * @return Response
   */
  public function destroy($id)
  {
    //
  }
}
