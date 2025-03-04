<?php

namespace Modules\Setting\Http\Controllers;

use Illuminate\Http\Request;
use Response;
use Illuminate\Routing\Controller;
use Modules\Base\Supports\Helper;
use Modules\Base\Http\Responses\BaseHttpResponse;
use Modules\Setting\Repositories\SettingInterface;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Application;
use Modules\Setting\Tables\BackupsTable;
use Modules\Setting\Http\Requests\MediaSettingRequest;
use File;
use Assets;
use GoogleDrive;
use Artisan;
use Setting;
//use Modules\Setting\Supports\SettingStore;

class SettingController extends Controller
{
    /**
     * @var SettingInterface
     */
    protected $setting;

    /**
     * @var SettingStore
     */
    protected $settingStore;

    /**
     * SettingController constructor.
     * @param SettingInterface $settingRepository
     * @param SettingStore $settingStore
     */
    public function __construct(SettingInterface $setting)
    {
        $this->setting = $setting;
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view("setting::index");
    }

    public function general()
    {
        return view("setting::index");
    }

    public function email()
    {
        page_title()->setTitle("Cấu hình Email Template");
        return view("setting::email");
    }

    public function backup(BackupsTable $table)
    {
        page_title()->setTitle("Quản lý Backup website");
        return $table->renderTable();
        //return view("setting::backup");
    }

    public function backupDelete($id)
    {
        GoogleDrive::delete($id);
        return Response::json(
            [
                "success" => true,
            ],
            200
        );
    }

    public function backupGeneration($type, BaseHttpResponse $response)
    {
        try {
            if ($type == "db") {
                Artisan::call("backup:run", [
                    "--only-db" => true,
                    "--disable-notifications" => true,
                ]);
            } elseif ($type == "all") {
                Artisan::call("backup:run", [
                    "--disable-notifications" => true,
                ]);
            } else {
                abort(404);
            }
            $output = Artisan::output();
            //return redirect()->back();
            return $response
                ->setPreviousUrl(route("setting.backup"))
                ->setMessage(__("base::form-validate.add-success"));
        } catch (Exception $e) {
            return redirect()->back();
        }
    }

    public function backupDownload($fileId)
    {
        //dd(public_path());
        $file = GoogleDrive::service()->files->get($fileId);
        //dd($file);
        $content = GoogleDrive::service()->files->get($fileId, [
            "alt" => "media",
        ]);

        $pathToFile = public_path() . "/" . $file->name;
        $outHandle = fopen($pathToFile, "w+");

        while (!$content->getBody()->eof()) {
            fwrite($outHandle, $content->getBody()->read(1024));
        }

        fclose($outHandle);
        return response()
            ->download($pathToFile)
            ->deleteFileAfterSend(true);
        //echo "Done.\n";
    }

    public function cache()
    {
        page_title()->setTitle(__("base::cache.cache_management"));

        Assets::add([domain() . "/vendor/core/js/cache.js"]);
        return view("setting::cache");
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view("setting::create");
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
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit(Request $request, BaseHttpResponse $response)
    {
        $this->saveSettings($request->except(["_token"]));

        return $response
            ->setPreviousUrl(route("setting.edit"))
            ->setMessage(__("base::notices.update_success_message"));
    }

    protected function saveSettings(array $data)
    {

        foreach ($data as $settingKey => $settingValue) {
            if (is_array($settingValue)) {
                $settingValue = json_encode(array_filter($settingValue));
            }

            setting()->set($settingKey, (string)$settingValue);
        }

        setting()->save();
    }

    /**
     * @param Request $request
     * @param BaseHttpResponse $response
     * @param Filesystem $files
     * @param Application $app
     * @return BaseHttpResponse
     */
    public function postClearCache(
        Request $request,
        BaseHttpResponse $response,
        Filesystem $files,
        Application $app
    ) {
        switch ($request->input("type")) {
            case "clear_cms_cache":
                Helper::clearCache();
                break;
            case "refresh_compiled_views":
                foreach (
                    $files->glob(config("view.compiled") . "/*")
                    as $view
                ) {
                    $files->delete($view);
                }
                break;
            case "clear_config_cache":
                $files->delete($app->getCachedConfigPath());
                break;
            case "clear_route_cache":
                $files->delete($app->getCachedRoutesPath());
                break;
            case "clear_log":
                foreach (File::allFiles(storage_path("logs")) as $file) {
                    File::delete($file->getPathname());
                }
                break;
        }

        return $response->setMessage(
            __(
                "base::cache.commands." .
                    $request->input("type") .
                    ".success_msg"
            )
        );
    }

    public function getMediaSetting()
    {
        page_title()->setTitle(__('Setting::setting.media.title'));

        return view('setting::media');
    }

    public function postMediaSetting(Request $request, BaseHttpResponse $response)
    {
        // dd($request);
        $this->saveSettings($request->except(['_token']));

        return $response
            ->setPreviousUrl(route('setting.media'))
            ->setMessage(trans('Base::notices.update_success_message'));
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
