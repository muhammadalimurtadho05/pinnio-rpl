<?php

namespace App\Pinnio\Config;

class View
{
  public static function render(string $src_path, array $data = []): void
  {
    require_once __DIR__ . "/../View/header.php";
    require_once __DIR__ . "/../View/$src_path.php";
    require_once __DIR__ . "/../View/footer.php";
  }

  public static function app(string $src_path, array $data = []): void
  {
    $data["navigation"] = [
      [
        "name" => "Home",
        "path" => "/home",
        "icon" => "house-fill"
      ],
      [
        "name" => "Profile",
        "path" => "/profile",
        "icon" => "person-fill"
      ],
      [
        "name" => "Pengaturan",
        "path" => "/pengaturan",
        "icon" => "gear-fill"
      ]
    ];

    if (isset($_SESSION["auth"]["role"]) && $_SESSION["auth"]["role"] === 'admin') {
      $data["navigation"][] = [
        "name" => "Admin Dashboard",
        "path" => "/admin",
        "icon" => "shield-lock-fill"
      ];
    }

    require_once __DIR__ . "/../View/app/header.php";
    require_once __DIR__ . "/../View/app/$src_path.php";
    require_once __DIR__ . "/../View/app/footer.php";
  }

  public static function admin(string $src_path, array $data = []): void
  {
    $data["navigation"] = [
      [
        "name" => "Dashboard",
        "path" => "/admin",
        "icon" => "speedometer2"
      ],
      [
        "name" => "Manage Posts",
        "path" => "/admin/posts",
        "icon" => "images"
      ],
      [
        "name" => "Manage Reports",
        "path" => "/admin/reports",
        "icon" => "flag"
      ]
    ];

    require_once __DIR__ . "/../View/admin/header.php";
    require_once __DIR__ . "/../View/admin/$src_path.php";
    require_once __DIR__ . "/../View/admin/footer.php";
  }

  public static function notFound(): void
  {
    require_once __DIR__ . "/../View/header.php";
    require_once __DIR__ . "/../View/404.php";
    require_once __DIR__ . "/../View/footer.php";
  }

  public static function redirect(string $path): void
  {
    header("Location: $path");
    exit();
  }
}