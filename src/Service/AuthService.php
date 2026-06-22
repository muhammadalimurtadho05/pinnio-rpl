<?php

namespace App\Pinnio\Service;

use App\Pinnio\Model\AuthModel;
use App\Pinnio\Repository\UserRepository;
use App\Pinnio\Exception\ValidationException;

class AuthService
{
  private static UserRepository $userRepository;

  public function __construct(UserRepository $userRepository)
  {
    self::$userRepository = $userRepository;
  }

  public function auth(AuthModel $authModel): void
  {
    $model = $authModel;

    self::authValidation($model);

    $result = self::$userRepository->findByUsername($model->username)->fetch();

    if (!$result) {
      throw new ValidationException("Username gak ada yang cocok");
    }

    if (!password_verify($model->password, $result["password"])) {
      throw new ValidationException("Password salah");
    }

    $_SESSION["auth"] = [
      "user_id" => $result["user_id"],
      "email" => $result["email"],
      "role" => $result["role"]
    ];
  }

  private static function authValidation(AuthModel $authModel): void
  {
    require_once __DIR__ . "/../utils.php";

    if (isInputEmpty($authModel->username)) {
      throw new ValidationException("Username gak boleh kosong");
    }

    if (isInputEmpty($authModel->password)) {
      throw new ValidationException("Password gak boleh kosong");
    }
  }
}