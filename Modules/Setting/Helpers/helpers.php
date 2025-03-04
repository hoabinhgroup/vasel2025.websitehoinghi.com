<?php
use Modules\Setting\Supports\SettingStore;
use Modules\Setting\Facades\SettingFacade;

if (!function_exists("setting")) {
  /**
   * Get the setting instance.
   *
   * @param $key
   * @param $default
   * @author Tuan Louis
   */
  function setting($key = null, $default = null)
  {
	//  dd(SettingFacade::getFacadeRoot());
	if (!empty($key)) {
	  // dd(Setting::get($key, $default));
	  try {
		// return Setting::get($key, $default);
		return app(SettingStore::class)->get($key, $default);
		//return \Setting::get($key);
		// return Setting::where("key", $key)->first()->value;
	  } catch (Exception $exception) {
		info($exception->getMessage());
		return $default;
	  }
	}
	return SettingFacade::getFacadeRoot();
  }
}