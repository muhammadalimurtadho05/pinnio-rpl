<?php

namespace App\Pinnio\Repository;

class FollowRepository
{
    private \PDO $connDB;

    public function __construct(\PDO $connDB)
    {
        $this->connDB = $connDB;
    }

    public function isFollowing(int $follower_id, int $following_id): bool
    {
        $statement = $this->connDB->prepare("SELECT COUNT(*) FROM follows WHERE follower_id = ? AND following_id = ?");
        $statement->execute([$follower_id, $following_id]);
        return (int) $statement->fetchColumn() > 0;
    }

    public function follow(int $follower_id, int $following_id): bool
    {
        if ($this->isFollowing($follower_id, $following_id)) {
            return false;
        }
        $statement = $this->connDB->prepare("INSERT INTO follows (follower_id, following_id) VALUES (?, ?)");
        return $statement->execute([$follower_id, $following_id]);
    }

    public function unfollow(int $follower_id, int $following_id): bool
    {
        $statement = $this->connDB->prepare("DELETE FROM follows WHERE follower_id = ? AND following_id = ?");
        return $statement->execute([$follower_id, $following_id]);
    }
}
