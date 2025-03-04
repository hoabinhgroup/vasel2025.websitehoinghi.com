<?php

namespace Modules\Appstore\Http\Controllers;

use Illuminate\Http\Request;
use Response;
use Illuminate\Routing\Controller;
use Modules\Base\Http\Responses\BaseHttpResponse;
use Modules\Appstore\Services\PluginService;
use Assets;
use File;
use Exception;
use Module;

class AppstoreController extends Controller
{
  /**
   * Display a listing of the resource.
   * @return Response
   */
  public function index()
  {

    Assets::add([domain() . "/css/plugin.css", domain() . "/js/plugin.js"]);

    $list = [];

    if (File::exists(plugin_path(".DS_Store"))) {
      File::delete(plugin_path(".DS_Store"));
    }

    $core_plugin = [
      "Acl",
      "Appstore",
      "Base",
      "Menu",
      "Page",
      "Setting",
      "Slug",
      "Template",
    ];

    $plugins = scan_folder(plugin_path());

    if (!empty($plugins)) {
      $installed = get_active_plugins();
      // dd($installed);

      foreach ($plugins as $plugin) {
        if (File::exists(plugin_path($plugin . "/.DS_Store"))) {
          File::delete(plugin_path($plugin . "/.DS_Store"));
        }

        $pluginPath = plugin_path($plugin);
        if (
          !File::isDirectory($pluginPath) ||
          !File::exists($pluginPath . "/module.json")
        ) {
          exit();
        }

        $content = get_file_data($pluginPath . "/module.json");

        if (!empty($content)) {
          if (!in_array($plugin, $installed)) {
            $content["status"] = 0;
          } else {
            $content["status"] = 1;
          }

          $content["path"] = $plugin;
          $content["image"] = null;
          if (File::exists($pluginPath . "/screenshot.png")) {
            $content["image"] = base64_encode(
              File::get($pluginPath . "/screenshot.png")
            );
          }
          $list[] = (object) $content;
        }
      }
    }

    return view("appstore::index", compact("list", "core_plugin"));
  }

  /**
   * Show the form for creating a new resource.
   * @return Response
   */
  public function create()
  {
    return view("appstore::create");
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
    return view("appstore::show");
  }

  public function changeStatus(Request $request, PluginService $pluginService)
  {
    $plugin = $request->name;

    $module = Module::find($plugin);

    $content = get_file_data(plugin_path($plugin . "/module.json"));

    if (!empty($content)) {
      try {
        $activatedPlugins = get_active_plugins();
        if (!in_array($plugin, $activatedPlugins)) {
          $result = $pluginService->activate($plugin);
        } else {
          $result = $pluginService->deactivate($plugin);
        }

        if ($result["error"]) {
          return Response::json([
            "success" => false,
            "data" => $result["message"],
          ]);
        }

        // return $response->setMessage('Cập nhật trạng thái plugin thành công');
      } catch (Exception $ex) {
        return Response::json([
          "success" => false,
          "data" => $ex->getMessage(),
        ]);
      }
    }

    return Response::json(
      [
        "success" => true,
        "data" => $module->getName(),
      ],
      200
    );
  }
  /**
   * Show the form for editing the specified resource.
   * @param int $id
   * @return Response
   */
  public function edit($id)
  {
    return view("appstore::edit");
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

  /**
   * Remove the specified resource from storage.
   * @param int $id
   * @return Response
   */
  public function destroy(
    $plugin,
    BaseHttpResponse $response,
    PluginService $pluginService
  ) {
    try {
      $result = $pluginService->remove($plugin);

      if ($result["error"]) {
        return $response->setError()->setMessage($result["message"]);
      }

      return $response->setMessage("Xóa Module thành công");
    } catch (Exception $exception) {
      return $response->setError()->setMessage($exception->getMessage());
    }
  }
}
