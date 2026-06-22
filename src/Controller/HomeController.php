<?php

namespace App\Pinnio\Controller;

use App\Pinnio\Config\Database;
use App\Pinnio\Config\View;
use App\Pinnio\Model\UserModel;
use App\Pinnio\Repository\MemeRepository;
use App\Pinnio\Repository\UserRepository;
use App\Pinnio\Service\MemeService;
use App\Pinnio\Service\UserService;

class HomeController
{
  protected static UserModel $userModel;
  protected static UserService $userService;

  protected static MemeService $memeService;

  public function __construct()
  {
    $connDB = Database::connect();
    $userRepository = new UserRepository($connDB);
    $memeRepository = new MemeRepository($connDB);

    self::$userModel = new UserModel();
    self::$userService = new UserService($userRepository);
    self::$memeService = new MemeService($memeRepository);
  }

  public function landing(): void
  {
    View::render("landing", [
      "title" => "PinThread — Say it. Thread it.",
      "style" => "landing.css"
    ]);
  }

  public function home(string $activeTab = 'forYou'): void
  {
    $user = self::$userService->getUserById($_SESSION['auth']["user_id"]);
    
    if ($activeTab === 'following') {
      $memes = self::$memeService->getFollowingMemes($_SESSION['auth']["user_id"]);
    } else {
      $memes = self::$memeService->getMemes();
    }

    $connDB = Database::connect();
    $likeRepository = new \App\Pinnio\Repository\LikeRepository($connDB);
    $likedMemeIds = $likeRepository->getLikedMemeIds($_SESSION['auth']["user_id"]);
    
    $bookmarkRepository = new \App\Pinnio\Repository\BookmarkRepository($connDB);
    $bookmarkedMemeIds = $bookmarkRepository->getBookmarkedMemeIds($_SESSION['auth']["user_id"]);

    foreach ($memes as &$meme) {
      $meme['is_liked'] = in_array($meme['meme_id'], $likedMemeIds);
      $meme['is_bookmarked'] = in_array($meme['meme_id'], $bookmarkedMemeIds);
    }

    View::app("home", [
      "title" => "Home — PinThread",
      "user" => $user,
      "memes" => $memes,
      "script" => ["home.js"],
      "active_tab" => $activeTab
    ]);
  }
}