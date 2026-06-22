<?php

namespace App\Pinnio\Controller;

use App\Pinnio\Config\Database;
use App\Pinnio\Repository\BookmarkRepository;
use App\Pinnio\Service\BookmarkService;

class BookmarkController
{
  private static BookmarkService $bookmarkService;

  public function __construct()
  {
    $connDB = Database::connect();
    $bookmarkRepository = new BookmarkRepository($connDB);
    self::$bookmarkService = new BookmarkService($bookmarkRepository);
  }

  public function toggle(): void
  {
    header('Content-Type: application/json');

    if (!isset($_SESSION['auth']["user_id"])) {
      echo json_encode(["status" => "error", "message" => "Unauthorized"]);
      http_response_code(401);
      return;
    }

    $input = json_decode(file_get_contents('php://input'), true);
    $memeID = $input['meme_id'] ?? null;

    if (!$memeID) {
      echo json_encode(["status" => "error", "message" => "Missing meme_id"]);
      http_response_code(400);
      return;
    }

    try {
      $result = self::$bookmarkService->toggleBookmark($_SESSION['auth']["user_id"], $memeID);
      echo json_encode($result);
    } catch (\Exception $e) {
      echo json_encode(["status" => "error", "message" => $e->getMessage()]);
      http_response_code(500);
    }
  }
}
