<?php

namespace App\Pinnio\Repository;

class LikeRepository
{
    static private \PDO $connDB;

    public function __construct(\PDO $connDB)
    {
        self::$connDB = $connDB;
    }

    // Mengecek apakah user sudah me-like meme tertentu
    public function checkLikeExists(int $user_id, int $meme_id): bool
    {
        $stmt = self::$connDB->prepare("SELECT like_id FROM likes WHERE user_id = ? AND meme_id = ?");
        $stmt->execute([$user_id, $meme_id]);
        return (bool) $stmt->fetch();
    }

    // Mendapatkan semua meme_id yang di-like oleh user tertentu
    public function getLikedMemeIds(int $user_id): array
    {
        $stmt = self::$connDB->prepare("SELECT meme_id FROM likes WHERE user_id = ?");
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(\PDO::FETCH_COLUMN);
    }

    // Menambahkan data like
    public function addLike(int $user_id, int $meme_id): bool
    {
        $stmt = self::$connDB->prepare("INSERT INTO likes (user_id, meme_id) VALUES (?, ?)");
        return $stmt->execute([$user_id, $meme_id]);
    }

    // Menghapus data like (Unlike)
    public function removeLike(int $user_id, int $meme_id): bool
    {
        $stmt = self::$connDB->prepare("DELETE FROM likes WHERE user_id = ? AND meme_id = ?");
        return $stmt->execute([$user_id, $meme_id]);
    }

    // Mengambil total like pada satu meme
    public function getLikeCount(int $meme_id): int
    {
        $stmt = self::$connDB->prepare("SELECT COUNT(*) as total FROM likes WHERE meme_id = ?");
        $stmt->execute([$meme_id]);
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return (int) $result['total'];
    }

    // Fungsi utama yang dipanggil oleh Controller untuk Toggle Like
    public function toggleLike(int $user_id, int $meme_id): array
    {
        $likeExists = $this->checkLikeExists($user_id, $meme_id);

        if ($likeExists) {
            $this->removeLike($user_id, $meme_id);
            $action = 'unliked';
        } else {
            $this->addLike($user_id, $meme_id);
            $action = 'liked';
        }

        $totalLikes = $this->getLikeCount($meme_id);

        return [
            'status' => $action, 
            'likes_count' => $totalLikes
        ];
    }
}