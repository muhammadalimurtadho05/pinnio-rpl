<?php

namespace App\Pinnio\Controller;

use App\Pinnio\Config\Database;
use App\Pinnio\Repository\LikeRepository;

class LikeController
{
  private static LikeRepository $likeRepository;
  
  public function __construct()
  {
    // Menginisialisasi koneksi database dan repository persis seperti di CommentController
    $connDB = Database::connect();
    self::$likeRepository = new LikeRepository($connDB);
  }

  public function toggle(): void
  {
    // Mengatur header agar browser tahu ini balasan untuk JavaScript (AJAX)
    header('Content-Type: application/json');

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Menyesuaikan pemanggilan session dengan struktur auth kamu
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

    // Memanggil fungsi dari repository yang sudah diinisialisasi di __construct
    $result = self::$likeRepository->toggleLike($userId, $memeId);

    // Mengembalikan hasil ke browser (JavaScript)
    echo json_encode($result);
  }
}
