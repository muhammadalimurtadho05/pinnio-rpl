<?php

namespace App\Pinnio\Service;

use App\Pinnio\Model\SignupModel;
use App\Pinnio\Repository\UserRepository;
use App\Pinnio\Exception\ValidationException;

class SignupService
{
  private static UserRepository $userRepository;

  public function __construct(UserRepository $userRepository)
  {
    self::$userRepository = $userRepository;
  }

  public function save(SignupModel $signupModel): void
  {
    $model = $signupModel;
    $result = self::$userRepository->findByUsername($model->username)->fetch();

    if ($result) {
      throw new ValidationException("User sudah ada, silakan pilih username lain");
    }

    self::signupValidation($model);

    $model->password = password_hash($model->password, PASSWORD_BCRYPT);
    self::$userRepository->save($model);
  }

  private static function signupValidation(SignupModel $signupModel): void
  {
    require_once __DIR__ . "/../utils.php";

    if (isInputEmpty($signupModel->username)) {
      throw new ValidationException("Username tidak boleh kosong");
    }

    if (isInputEmpty($signupModel->email)) {
      throw new ValidationException("Email tidak boleh kosong");
    }

    if (isInputEmpty($signupModel->password)) {
      throw new ValidationException("Kata sandi tidak boleh kosong");
    }
  }
}