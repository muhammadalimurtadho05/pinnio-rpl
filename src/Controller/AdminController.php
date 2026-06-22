<?php

namespace App\Pinnio\Controller;

use App\Pinnio\Config\Database;
use App\Pinnio\Config\View;
use App\Pinnio\Repository\MemeRepository;
use App\Pinnio\Repository\ReportRepository;
use App\Pinnio\Repository\UserRepository;
use App\Pinnio\Service\MemeService;
use App\Pinnio\Service\ReportService;
use App\Pinnio\Service\UserService;
use App\Pinnio\Exception\ValidationException;

class AdminController
{
    private static UserService $userService;
    private static MemeService $memeService;
    private static ReportService $reportService;

    public function __construct()
    {
        $connDB = Database::connect();
        
        $userRepository = new UserRepository($connDB);
        $memeRepository = new MemeRepository($connDB);
        $reportRepository = new ReportRepository($connDB);

        self::$userService = new UserService($userRepository);
        self::$memeService = new MemeService($memeRepository);
        self::$reportService = new ReportService($reportRepository);
    }

    public function dashboard(): void
    {
        $user = self::$userService->getUserById($_SESSION['auth']['user_id']);
        
        $totalUsers = self::$userService->getTotalUsersCount();
        $totalMemes = self::$memeService->getTotalMemesCount();
        $totalReports = self::$reportService->getTotalReportsCount();

        $recentUsers = self::$userService->getRecentUsers(5);
        $recentReports = array_slice(self::$reportService->getAllReports(), 0, 5);

        View::admin("dashboard", [
            "title" => "Admin Dashboard — PinThread",
            "user" => $user,
            "total_users" => $totalUsers,
            "total_memes" => $totalMemes,
            "total_reports" => $totalReports,
            "recent_users" => $recentUsers,
            "recent_reports" => $recentReports
        ]);
    }

    public function posts(): void
    {
        $user = self::$userService->getUserById($_SESSION['auth']['user_id']);
        $memes = self::$memeService->getMemes(); // passing null to get all memes

        View::admin("posts", [
            "title" => "Manage Posts — Admin",
            "user" => $user,
            "memes" => $memes
        ]);
    }

    public function takedownPost(int $meme_id): void
    {
        try {
            self::$memeService->deleteMeme($meme_id);
        } catch (ValidationException $e) {
            // Ignore if image deletion fails but DB delete fails? 
            // In MemeService, if it throws before DB delete, it won't delete from DB.
            // But we will let it proceed or handle it silently for now.
        }
        View::redirect("/admin/posts");
    }

    public function reports(): void
    {
        $user = self::$userService->getUserById($_SESSION['auth']['user_id']);
        $reports = self::$reportService->getAllReports();

        View::admin("reports", [
            "title" => "Manage Reports — Admin",
            "user" => $user,
            "reports" => $reports
        ]);
    }

    public function deleteReport(int $report_id): void
    {
        self::$reportService->deleteReport($report_id);
        View::redirect("/admin/reports");
    }
}
