<?php

namespace App\Pinnio\Service;

use App\Pinnio\Repository\ReportRepository;
use App\Pinnio\Exception\ValidationException;

class ReportService
{
  private static ReportRepository $reportRepository;

  public function __construct(ReportRepository $reportRepository)
  {
    self::$reportRepository = $reportRepository;
  }

  public function reportMeme(int $reporterID, int $memeID, string $reason): void
  {
    if (empty(trim($reason))) {
      throw new ValidationException("Reason cannot be empty.");
    }

    self::$reportRepository->addReport($reporterID, $memeID, trim($reason));
  }
}
