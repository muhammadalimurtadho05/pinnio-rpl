<?php

namespace App\Pinnio\Service;

use App\Pinnio\Exception\ValidationException;
use App\Pinnio\Model\UserModel;
use App\Pinnio\Repository\UserRepository;

class UserService
{
  private static UserRepository $userRepository;

  public function __construct(UserRepository $userRepository)
  {
    self::$userRepository = $userRepository;
  }

  public function getUserById(int $userID): array
  {
    $result = self::$userRepository->findByID($userID)->fetch();

    if (!$result) {
      throw new ValidationException("User does not match");
    }

    return $result;
  }

  public function getUserByUsername(string $username): array
  {
    $result = self::$userRepository->findByUsername($username)->fetch();

    if (!$result) {
      throw new ValidationException("User does not match");
    }

    return $result;
  }

  public function update(UserModel $userModel, int $userID): void
  {
    $model = $userModel;

    $result = self::$userRepository->findByID($userID)->fetch();

    if (!$result) {
      throw new ValidationException("User does not match");
    }

    self::$userRepository->update($model, $userID);

    $_SESSION["auth"] = [
      "user_id" => $result["user_id"],
      "email" => $result["email"]
    ];
  }

  public function delete(int $userID): void
  {
    self::$userRepository->delete($userID);
    session_destroy();
    session_unset();
  }

  public function updatePassword(UserModel $userModel, string $old_password, string $new_password, string $confirm_password): void
  {
    require_once __DIR__ . "/../utils.php";

    if (isInputEmpty($new_password) || isInputEmpty($confirm_password)) {
      throw new ValidationException("Input password tidak boleh kosong!");
    }

    $res = self::getUserById($userModel->user_id);

    if (!password_verify($old_password, $res["password"])) {
      throw new ValidationException("Password lama salah!");
    }

    if ($new_password !== $confirm_password) {
      throw new ValidationException("Konfirmasi password tidak sama");
    }

    $userModel->password = password_hash($new_password, PASSWORD_BCRYPT);
    self::$userRepository->updatePassword($userModel->user_id, $userModel->password);
  }

  public function getUserStats(int $userID): array
  {
    return [
      "followers_count" => self::$userRepository->getFollowersCount($userID),
      "following_count" => self::$userRepository->getFollowingCount($userID),
      "posts_count" => self::$userRepository->getPostsCount($userID)
    ];
  }

  public function searchUsers(string $query): array
  {
    if (empty(trim($query))) {
      return [];
    }
    return self::$userRepository->searchUsers(trim($query));
  }
}