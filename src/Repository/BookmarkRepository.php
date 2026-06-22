<?php

namespace App\Pinnio\Repository;

class BookmarkRepository
{
  private static \PDO $connDB;

  public function __construct(\PDO $connDB)
  {
    self::$connDB = $connDB;
  }

  public function addBookmark(int $userID, int $memeID): \PDOStatement
  {
    $statement = self::$connDB->prepare("INSERT INTO bookmarks (user_id, meme_id) VALUES (?, ?)");
    $statement->execute([$userID, $memeID]);
    return $statement;
  }

  public function removeBookmark(int $userID, int $memeID): \PDOStatement
  {
    $statement = self::$connDB->prepare("DELETE FROM bookmarks WHERE user_id = ? AND meme_id = ?");
    $statement->execute([$userID, $memeID]);
    return $statement;
  }

  public function getBookmarkedMemeIds(int $userID): array
  {
    $statement = self::$connDB->prepare("SELECT meme_id FROM bookmarks WHERE user_id = ?");
    $statement->execute([$userID]);
    $results = $statement->fetchAll(\PDO::FETCH_ASSOC);
    
    $memeIds = [];
    foreach ($results as $row) {
      $memeIds[] = $row['meme_id'];
    }
    return $memeIds;
  }

  public function getBookmarkedMemes(int $userID): array
  {
    // Fetches the full memes that the user bookmarked
    $statement = self::$connDB->prepare("
      SELECT 
        m.meme_id, m.image_url, m.caption, m.created_at,
        u.user_id, u.username, u.name, u.profile_picture,
        (SELECT COUNT(*) FROM likes l WHERE l.meme_id = m.meme_id) as likes_count,
        (SELECT COUNT(*) FROM comments c WHERE c.meme_id = m.meme_id) as comments_count
      FROM bookmarks b
      JOIN memes m ON b.meme_id = m.meme_id
      LEFT JOIN users u ON m.user_id = u.user_id
      WHERE b.user_id = ?
      ORDER BY b.created_at DESC
    ");
    $statement->execute([$userID]);
    return $statement->fetchAll(\PDO::FETCH_ASSOC);
  }
}
