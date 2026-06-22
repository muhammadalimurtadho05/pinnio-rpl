<?php

namespace App\Pinnio\Controller;

use App\Pinnio\Config\Database;
use App\Pinnio\Repository\ReportRepository;
use App\Pinnio\Service\ReportService;
use App\Pinnio\Exception\ValidationException;

class ReportController
{
  private static ReportService $reportService;

  public function __construct()
  {
    $connDB = Database::connect();
    $reportRepository = new ReportRepository($connDB);
    self::$reportService = new ReportService($reportRepository);
  }

  public function report(): void
  {
    header('Content-Type: application/json');

    if (!isset($_SESSION['auth']["user_id"])) {
      echo json_encode(["status" => "error", "message" => "Unauthorized"]);
      http_response_code(401);
      return;
    }

    $input = json_decode(file_get_contents('php://input'), true);
    $memeID = $input['meme_id'] ?? null;
    $reason = $input['reason'] ?? '';

    if (!$memeID) {
      echo json_encode(["status" => "error", "message" => "Missing meme_id"]);
      http_response_code(400);
      return;
    }

    try {
      self::$reportService->reportMeme($_SESSION['auth']["user_id"], $memeID, $reason);
      echo json_encode(["status" => "success", "message" => "Report submitted successfully."]);
    } catch (ValidationException $e) {
      echo json_encode(["status" => "error", "message" => $e->getMessage()]);
      http_response_code(400);
    } catch (\Exception $e) {
      echo json_encode(["status" => "error", "message" => "Failed to submit report."]);
      http_response_code(500);
    }
  }
}
