<?php

namespace App\Pinnio\Controller;

use App\Pinnio\Config\View;

class SettingController extends HomeController
{
  public function index()
  {
    $user = self::$userService->getUserById($_SESSION['auth']["user_id"]);
    View::app("setting/setting", [
      "title" => "Pengaturan",
      "user" => $user,
      "elements" => ["setting/setting_modal"]
    ]);
  }
}