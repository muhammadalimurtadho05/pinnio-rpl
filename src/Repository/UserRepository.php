<?php

namespace App\Pinnio\Repository;

use App\Pinnio\Model\UserModel;
use App\Pinnio\Model\SignupModel;

class UserRepository
{
  private static \PDO $connDB;

  public function __construct(\PDO $connDB)
  {
    self::$connDB = $connDB;
  }

  public function findByID(int $userID): \PDOStatement
  {
    $statement = self::$connDB->prepare("SELECT * FROM users WHERE user_id = ?");
    $statement->execute([$userID]);
    return $statement;
  }

  public function findByUsername(string $username): \PDOStatement
  {
    $statement = self::$connDB->prepare("SELECT * FROM users WHERE username = ?");
    $statement->execute([$username]);
    return $statement;
  }

  public function save(SignupModel $signupModel): \PDOStatement
  {
    $statement = self::$connDB->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $statement->execute([$signupModel->username, $signupModel->email, $signupModel->password]);
    return $statement;
  }

  public function update(UserModel $userModel, int $userID): \PDOStatement
  {
    $statement = self::$connDB->prepare("UPDATE users SET name = ?, bio = ? WHERE user_id = ?");
    $statement->execute([$userModel->name, $userModel->bio, $userID]);
    return $statement;
  }

  public function delete(int $userID): \PDOStatement
  {
    $statement = self::$connDB->prepare("DELETE FROM users WHERE user_id = ?");
    $statement->execute([$userID]);
    return $statement;
  }

  public function updatePassword(int $userID, string $new_password): \PDOStatement
  {
    $statement = self::$connDB->prepare("UPDATE users SET password = ? WHERE user_id = ?");
    $statement->execute([$new_password, $userID]);
    return $statement;
  }

  public function getFollowersCount(int $userID): int
  {
    $statement = self::$connDB->prepare("SELECT COUNT(*) FROM follows WHERE following_id = ?");
    $statement->execute([$userID]);
    return (int)$statement->fetchColumn();
  }

  public function getFollowingCount(int $userID): int
  {
    $statement = self::$connDB->prepare("SELECT COUNT(*) FROM follows WHERE follower_id = ?");
    $statement->execute([$userID]);
    return (int)$statement->fetchColumn();
  }

  public function getPostsCount(int $userID): int
  {
    $statement = self::$connDB->prepare("SELECT COUNT(*) FROM memes WHERE user_id = ?");
    $statement->execute([$userID]);
    return (int)$statement->fetchColumn();
  }

  public function searchUsers(string $query): array
  {
    $searchTerm = "%" . $query . "%";
    $statement = self::$connDB->prepare("SELECT user_id, username, name, profile_picture FROM users WHERE username LIKE ? OR name LIKE ? LIMIT 20");
    $statement->execute([$searchTerm, $searchTerm]);
    return $statement->fetchAll(\PDO::FETCH_ASSOC);
  }
}