<?php

namespace App\Pinnio\Repository;

use App\Pinnio\Model\CommentModel;

class CommentRepository
{
  static private \PDO $connDB;

  public function __construct(\PDO $connDB)
  {
    self::$connDB = $connDB;
  }

  public function saveComment(CommentModel $commentModel): bool
  {
    $query = "INSERT INTO comments (user_id, meme_id, content) VALUES (?, ?, ?)";
    $stmt = self::$connDB->prepare($query);
    return $stmt->execute([$commentModel->user_id, $commentModel->meme_id, $commentModel->content]);
  }

  public function getCommentsByMemeId(int $meme_id): array
  {
    $statement = self::$connDB->prepare("SELECT c.*, u.username, u.name FROM comments c LEFT JOIN users u ON c.user_id = u.user_id WHERE c.meme_id = ? ORDER BY c.created_at DESC");
    $statement->execute([$meme_id]);
    return $statement->fetchAll(\PDO::FETCH_ASSOC);
  }

  public function deleteCommentByID(int $comment_id): bool
  {
    $statement = self::$connDB->prepare("DELETE FROM comments WHERE comment_id = ?");
    return $statement->execute([$comment_id]);
  }

  public function getCommentByID(int $comment_id): array
  {
    $statement = self::$connDB->prepare("SELECT * FROM comments WHERE comment_id = ?");
    $statement->execute([$comment_id]);
    return $statement->fetch(\PDO::FETCH_ASSOC) ?: [];
  }
}