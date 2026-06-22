<?php

namespace App\Pinnio\Repository;

use App\Pinnio\Model\MemeModel;

class MemeRepository
{
    static private \PDO $connDB;

    public function __construct(\PDO $connDB)
    {
        self::$connDB = $connDB;
    }

    public function saveMeme(MemeModel $memeModel): bool
    {
        $query = "INSERT INTO memes (user_id, image_url, caption) VALUES (?, ?, ?)";
        $stmt = self::$connDB->prepare($query);
        return $stmt->execute([$memeModel->user_id, $memeModel->image_path, $memeModel->caption]);
    }

    public function getMemes(?int $user_id = null): array
    {
        $statement = self::$connDB->prepare("CALL get_memes(?)");
        $statement->execute([$user_id]);
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getMemeById(int $meme_id): array
    {
        $statement = self::$connDB->prepare("CALL get_meme_by_id(?)");
        $statement->execute([$meme_id]);
        $result = $statement->fetch(\PDO::FETCH_ASSOC);
        return $result;
    }

    public function deleteMeme(int $meme_id): bool
    {
        $statement = self::$connDB->prepare("DELETE FROM memes WHERE meme_id = ?");
        return $statement->execute([$meme_id]);
    }

    public function updateMeme(int $meme_id, string $caption): bool
    {
        $statement = self::$connDB->prepare("UPDATE memes SET caption = ? WHERE meme_id = ?");
        return $statement->execute([$caption, $meme_id]);
    }

    public function getTotalMemesCount(): int
    {
        $statement = self::$connDB->query("SELECT COUNT(*) FROM memes");
        return (int) $statement->fetchColumn();
    }
}
