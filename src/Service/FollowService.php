<?php

namespace App\Pinnio\Service;

use App\Pinnio\Repository\FollowRepository;
use App\Pinnio\Exception\ValidationException;

class FollowService
{
    private FollowRepository $followRepository;

    public function __construct(FollowRepository $followRepository)
    {
        $this->followRepository = $followRepository;
    }

    public function toggleFollow(int $follower_id, int $following_id): array
    {
        if ($follower_id === $following_id) {
            throw new ValidationException("You cannot follow yourself.");
        }

        $isFollowing = $this->followRepository->isFollowing($follower_id, $following_id);

        if ($isFollowing) {
            $this->followRepository->unfollow($follower_id, $following_id);
            return ['status' => 'unfollowed'];
        } else {
            $this->followRepository->follow($follower_id, $following_id);
            return ['status' => 'followed'];
        }
    }

    public function isFollowing(int $follower_id, int $following_id): bool
    {
        return $this->followRepository->isFollowing($follower_id, $following_id);
    }
}
