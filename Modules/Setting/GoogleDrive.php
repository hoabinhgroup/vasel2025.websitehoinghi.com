<?php

namespace Modules\Setting;
use Modules\Base\Traits\CommonFunctions;

class GoogleDrive
{
  use CommonFunctions;
  protected $_service;

  public function __construct()
  {
    $client = new \Google_Client();
    $client->setClientId(env("GOOGLE_DRIVE_CLIENT_ID"));
    $client->setClientSecret(env("GOOGLE_DRIVE_CLIENT_SECRET"));
    $client->refreshToken(env("GOOGLE_DRIVE_REFRESH_TOKEN"));
    $service = new \Google_Service_Drive($client);
    $this->_service = $service;
  }

  public function service()
  {
    return $this->_service;
  }

  public function delete($id)
  {
    try {
      $this->_service->files->delete($id);
    } catch (Exception $e) {
      return "Error: " . $e->getMessage();
    }
  }
}
