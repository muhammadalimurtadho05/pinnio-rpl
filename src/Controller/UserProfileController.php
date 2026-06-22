<?php

namespace App\Pinnio\Controller;

use App\Pinnio\Config\Database;
use App\Pinnio\Config\View;
use App\Pinnio\Repository\MemeRepository;
use App\Pinnio\Repository\UserRepository;
use App\Pinnio\Service\MemeService;
use App\Pinnio\Service\UserService;
use App\Pinnio\Repository\FollowRepository;
use App\Pinnio\Service\FollowService;

class UserProfileController
{
    private static UserService $userService;
    private static MemeService $memeService;
    private static FollowService $followService;

    public function __construct()
    {
        $connDB = Database::connect();
        $userRepository = new UserRepository($connDB);
        $memeRepository = new MemeRepository($connDB);
        $followRepository = new FollowRepository($connDB);

        self::$userService = new UserService($userRepository);
        self::$memeService = new MemeService($memeRepository);
        self::$followService = new FollowService($followRepository);
    }

    private function enrichMemesWithLikedStatus(array $memes): array
    {
        if (!isset($_SESSION['auth']['user_id'])) {
            foreach ($memes as &$meme) {
                $meme['is_liked'] = false;
                $meme['is_bookmarked'] = false;
            }
            return $memes;
        }

        $connDB = Database::connect();
        $likeRepository = new \App\Pinnio\Repository\LikeRepository($connDB);
        $likedMemeIds = $likeRepository->getLikedMemeIds($_SESSION['auth']["user_id"]);

        $bookmarkRepository = new \App\Pinnio\Repository\BookmarkRepository($connDB);
        $bookmarkedMemeIds = $bookmarkRepository->getBookmarkedMemeIds($_SESSION['auth']["user_id"]);

        foreach ($memes as &$meme) {
            $meme['is_liked'] = in_array($meme['meme_id'], $likedMemeIds);
            $meme['is_bookmarked'] = in_array($meme['meme_id'], $bookmarkedMemeIds);
        }
        return $memes;
    }

    public function view(string $username): void
    {
        try {
            $user = self::$userService->getUserByUsername($username);
            
            // Redirect to own profile if searching for oneself
            if (isset($_SESSION['auth']['user_id']) && $user['user_id'] === $_SESSION['auth']["user_id"]) {
                View::redirect("/profile");
                return;
            }

            $memes = self::$memeService->getMemes($user['user_id']);
            $memes = $this->enrichMemesWithLikedStatus($memes);
            $stats = self::$userService->getUserStats($user['user_id']);
            $isFollowing = isset($_SESSION['auth']['user_id']) 
                ? self::$followService->isFollowing($_SESSION['auth']['user_id'], $user['user_id']) 
                : false;

            View::app("user_profile", [
                "title" => $user['name'] . " (@" . $user['username'] . ") — PinThread",
                "style" => "profile.css",
                "script" => ["profile.js"], // Using profile.js for interactions
                "user" => $user,
                "memes" => $memes,
                "stats" => $stats,
                "is_following" => $isFollowing,
                "active_tab" => "postingan"
            ]);
        } catch (\Exception $e) {
            // User not found or other error
            View::redirect("/search");
        }
    }
}
