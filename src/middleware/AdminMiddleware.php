<?php

namespace App\Pinnio\Middleware;

use App\Pinnio\Config\View;

class AdminMiddleware
{
  public static function isAdmin(): void
  {
    if (!isset($_SESSION["auth"]["role"]) || $_SESSION["auth"]["role"] !== 'admin') {
      View::redirect("/home");
    }
  }
}
