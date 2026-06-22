<?php

namespace App\Pinnio\Controller;

use App\Pinnio\Config\Database;
use App\Pinnio\Config\View;
use App\Pinnio\Exception\ValidationException;
use App\Pinnio\Model\UserModel;
use App\Pinnio\Repository\MemeRepository;
use App\Pinnio\Repository\UserRepository;
use App\Pinnio\Service\MemeService;
use App\Pinnio\Service\UserService;

class ProfileController
{
  private static UserModel $userModel;
  private static UserService $userService;
  private static MemeService $memeService;

  public function __construct()
  {
    $connDB = Database::connect();
    $userRepository = new UserRepository($connDB);
    $memeRepository = new MemeRepository($connDB);

    self::$userModel = new UserModel();
    self::$userService = new UserService($userRepository);
    self::$memeService = new MemeService($memeRepository);
  }

  private function enrichMemesWithLikedStatus(array $memes): array
  {
    $connDB = Database::connect();
    $likeRepository = new \App\Pinnio\Repository\LikeRepository($connDB);
    $likedMemeIds = $likeRepository->getLikedMemeIds($_SESSION['auth']["user_id"]);

    foreach ($memes as &$meme) {
      $meme['is_liked'] = in_array($meme['meme_id'], $likedMemeIds);
    }
    return $memes;
  }

  public function page(): void
  {
    $user = self::$userService->getUserById($_SESSION['auth']["user_id"]);
    $memes = self::$memeService->getMemes($_SESSION['auth']["user_id"]);
    $memes = $this->enrichMemesWithLikedStatus($memes);

    View::app("profile", [
      "title" => "Profil — PinThread",
      "style" => "profile.css",
      "script" => ["profile.js"],
      "user" => $user,
      "memes" => $memes
    ]);
  }

  // File: ProfileController.php

  public function update(): void
  {
    $user = self::$userService->getUserById($_SESSION['auth']["user_id"]);
    $memes = self::$memeService->getMemes($_SESSION['auth']["user_id"]);
    $memes = $this->enrichMemesWithLikedStatus($memes);

    try {
      self::$userModel->name = $_POST["name"] ?? null; // Gunakan null coalescing
      self::$userModel->bio = $_POST["bio"] ?? null;

      self::$userService->update(self::$userModel, $_SESSION['auth']["user_id"]);
      View::redirect("/profile");
    } catch (ValidationException $e) {
      // PERBAIKAN: Gunakan View::app, bukan View::render
      View::app("profile", [
        "title" => "Profil — PinThread",
        "style" => "profile.css",
        "script" => ["profile.js"],
        "user" => $user,
        "memes" => $memes,
        "error_message" => $e->getMessage()
      ]);
    }
  }

  public function delete(): void
  {
    $user = self::$userService->getUserById($_SESSION['auth']["user_id"]);
    $memes = self::$memeService->getMemes($_SESSION['auth']["user_id"]);
    $memes = $this->enrichMemesWithLikedStatus($memes);

    try {
      self::$userService->delete($_SESSION['auth']["user_id"]);
      View::redirect("/");
    } catch (ValidationException $e) {
      View::render("profile", [
        "title" => "Profil — PinThread",
        "style" => "profile.css",
        "script" => ["profile.js"],
        "user" => $user,
        "memes" => $memes,
        "error_message" => $e->getMessage()
      ]);
    }
  }

  public function updatePassword(): void
  {
    try {
      self::$userModel->user_id = $_SESSION["auth"]["user_id"];
      $old_password = $_POST["old_password"];
      $new_password = $_POST["new_password"];
      $confirm_password = $_POST["confirm_password"];

      self::$userService->updatePassword(self::$userModel, $old_password, $new_password, $confirm_password);
      View::redirect("/logout");
    } catch (ValidationException $e) {
      $user = self::$userService->getUserById($_SESSION['auth']["user_id"]);
      View::app("setting/setting", [
        "title" => "Pengaturan",
        "user" => $user,
        "script" => ["setting.js"],
        "elements" => ["setting/setting_modal"],
        "error_message" => $e->getMessage()
      ]);
    }
  }
}
