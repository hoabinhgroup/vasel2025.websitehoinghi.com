<?php

namespace Modules\Setting\Supports;

use Illuminate\Support\Manager;

class SettingsManager extends Manager
{
  /**
   * @return string
   */
  public function getDefaultDriver()
  {
    return config("setting.driver");
  }

  /**
   * @return JsonSettingStore
   */
  public function createJsonDriver()
  {
    return new JsonSettingStore(app("files"));
  }

  /**
   * @return DatabaseSettingStore
   */
  public function createDatabaseDriver()
  {
    return new DatabaseSettingStore();
  }
}
