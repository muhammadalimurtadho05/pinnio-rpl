<?php

namespace App\Pinnio\Controller;

use App\Pinnio\Config\View;
use App\Pinnio\Config\Database;
use App\Pinnio\Model\AuthModel;
use App\Pinnio\Repository\UserRepository;
use App\Pinnio\Service\AuthService;
use App\Pinnio\Exception\ValidationException;

class AuthController
{
  private static AuthModel $authModel;
  private static AuthService $authService;
  private static array $display = [
    "title" => "Log in",
    "style" => "login.css",
    "script" => ["login.js"]
  ];

  public function __construct()
  {
    $connDB = Database::connect();
    $userRepository = new UserRepository($connDB);

    self::$authModel = new AuthModel();
    self::$authService = new AuthService($userRepository);
  }

  public function page(): void
  {
    View::render("login", self::$display);
  }

  public function auth(): void
  {
    try {
      self::$authModel->username = $_POST["username"];
      self::$authModel->password = $_POST["password"];

      self::$authService->auth(self::$authModel);
      
      if (isset($_SESSION["auth"]["role"]) && $_SESSION["auth"]["role"] === 'admin') {
        View::redirect("/admin");
      } else {
        View::redirect("/home");
      }
    } catch (ValidationException $e) {
      self::$display["error_message"] = $e->getMessage();
      View::render("login", self::$display);
    }
  }

  public function logout(): void
  {
    session_destroy();
    session_unset();
    View::redirect("/login");
  }
}