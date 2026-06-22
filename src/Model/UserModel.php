<?php


namespace App\Pinnio\Model;

class UserModel
{
  public int $user_id;
  public string $username;
  public string $email;
  public ?string $name;
  public string $password;
  public string $role;
  public ?string $bio;
  public ?string $profile_picture;
}