<?php

namespace App\Pinnio\Controller;

use App\Pinnio\Config\Database;
use App\Pinnio\Config\View;
use App\Pinnio\Repository\UserRepository;
use App\Pinnio\Service\UserService;

class SearchController
{
  protected static UserService $userService;

  public function __construct()
  {
    $connDB = Database::connect();
    $userRepository = new UserRepository($connDB);
    self::$userService = new UserService($userRepository);
  }

  public function page(?string $query = null): void
  {
    $query = $query ?? '';
    $users = [];

    if (!empty($query)) {
      $users = self::$userService->searchUsers($query);
    }

    $currentUser = self::$userService->getUserById($_SESSION['auth']["user_id"]);

    View::app("search", [
      "title" => "Search — PinThread",
      "user" => $currentUser,
      "users" => $users,
      "query" => $query
    ]);
  }
}
