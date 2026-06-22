<?php

namespace App\Pinnio\Service;

use App\Pinnio\Repository\NotificationRepository;

class NotificationService
{
    private NotificationRepository $notificationRepository;

    public function __construct(NotificationRepository $notificationRepository)
    {
        $this->notificationRepository = $notificationRepository;
    }

    public function addNotification(int $userId, int $actorId, string $type, int $referenceId = null): bool
    {
        return $this->notificationRepository->addNotification($userId, $actorId, $type, $referenceId);
    }

    public function getNotifications(int $userId): array
    {
        return $this->notificationRepository->getNotifications($userId);
    }

    public function getUnreadCount(int $userId): int
    {
        return $this->notificationRepository->getUnreadCount($userId);
    }

    public function markAsRead(int $notificationId, int $userId): bool
    {
        return $this->notificationRepository->markAsRead($notificationId, $userId);
    }

    public function markAllAsRead(int $userId): bool
    {
        return $this->notificationRepository->markAllAsRead($userId);
    }
}
