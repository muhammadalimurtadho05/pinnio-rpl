<?php

namespace App\Pinnio\Middleware;

use App\Pinnio\Config\View;

class AuthMiddleware
{
  public static function isAuth(): void
  {
    if (isset($_SESSION["auth"])) {
      View::redirect("/home");
    }
  }

  public static function isNotAuth(): void
  {
    if (!isset($_SESSION["auth"])) {
      View::redirect("/login");
    }
  }
}