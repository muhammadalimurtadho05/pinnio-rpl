<?php

namespace App\Pinnio\Controller;

use App\Pinnio\Config\Database;
use App\Pinnio\Repository\LikeRepository;

class LikeController
{
  private static LikeRepository $likeRepository;
  private static \App\Pinnio\Repository\MemeRepository $memeRepository;
  private static \App\Pinnio\Service\NotificationService $notificationService;
  
  public function __construct()
  {
    $connDB = Database::connect();
    self::$likeRepository = new LikeRepository($connDB);
    self::$memeRepository = new \App\Pinnio\Repository\MemeRepository($connDB);
    self::$notificationService = new \App\Pinnio\Service\NotificationService(new \App\Pinnio\Repository\NotificationRepository($connDB));
  }

  public function toggle(): void
  {
    header('Content-Type: application/json');

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION["auth"]["user_id"])) {
        http_response_code(401);
        echo json_encode(['error' => 'Silakan login terlebih dahulu']);
        return;
    }

    $input = json_decode(file_get_contents('php://input'), true);
    $memeId = $input['meme_id'] ?? null;

    if (!$memeId) {
        http_response_code(400);
        echo json_encode(['error' => 'Meme ID tidak ditemukan']);
        return;
    }

    $userId = $_SESSION["auth"]["user_id"];

    $result = self::$likeRepository->toggleLike($userId, $memeId);

    // If liked, trigger a notification
    if ($result['status'] === 'liked') {
        $meme = self::$memeRepository->getMemeById($memeId);
        if ($meme && isset($meme['user_id'])) {
            self::$notificationService->addNotification($meme['user_id'], $userId, 'like', $memeId);
        }
    }

    echo json_encode($result);
  }
}
