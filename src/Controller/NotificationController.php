<?php

namespace App\Pinnio\Controller;

use App\Pinnio\Config\Database;
use App\Pinnio\Config\View;
use App\Pinnio\Repository\NotificationRepository;
use App\Pinnio\Repository\UserRepository;
use App\Pinnio\Service\NotificationService;
use App\Pinnio\Service\UserService;

class NotificationController
{
    private NotificationService $notificationService;
    private UserService $userService;

    public function __construct()
    {
        $connDB = Database::connect();
        $this->notificationService = new NotificationService(new NotificationRepository($connDB));
        $this->userService = new UserService(new UserRepository($connDB));
    }

    public function index(): void
    {
        $currentUserId = $_SESSION['auth']['user_id'];
        $user = $this->userService->getUserById($currentUserId);
        
        $notifications = $this->notificationService->getNotifications($currentUserId);
        
        // Mark all as read when user visits the page
        $this->notificationService->markAllAsRead($currentUserId);

        View::app("notifications", [
            "title" => "Notifications — PinThread",
            "user" => $user,
            "notifications" => $notifications
        ]);
    }
}
