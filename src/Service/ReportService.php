<?php

namespace App\Pinnio\Service;

use App\Pinnio\Repository\ReportRepository;
use App\Pinnio\Exception\ValidationException;

class ReportService
{
    private ReportRepository $reportRepository;

    public function __construct(ReportRepository $reportRepository)
    {
        $this->reportRepository = $reportRepository;
    }

    public function getAllReports(): array
    {
        return $this->reportRepository->findAll()->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function deleteReport(int $report_id): void
    {
        $this->reportRepository->delete($report_id);
    }

    public function getTotalReportsCount(): int
    {
        return $this->reportRepository->getTotalReportsCount();
    }

    public function reportMeme(int $reporterID, int $memeID, string $reason): void
    {
        if (empty(trim($reason))) {
            throw new ValidationException("Reason cannot be empty.");
        }

        $this->reportRepository->addReport($reporterID, $memeID, trim($reason));
    }
}
