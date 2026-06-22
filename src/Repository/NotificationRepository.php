<?php

namespace App\Pinnio\Repository;

use PDO;

class NotificationRepository
{
    private PDO $connDB;

    public function __construct(PDO $connDB)
    {
        $this->connDB = $connDB;
    }

    public function addNotification(int $userId, int $actorId, string $type, int $referenceId = null): bool
    {
        // Don't notify if user is performing action on their own content
        if ($userId === $actorId) {
            return false;
        }

        // Check if a similar unread notification already exists to avoid spam
        if ($type !== 'message') {
            $stmt = $this->connDB->prepare("SELECT notification_id FROM notifications WHERE user_id = ? AND actor_id = ? AND type = ? AND reference_id = ?");
            $stmt->execute([$userId, $actorId, $type, $referenceId]);
            if ($stmt->fetch()) {
                return true; // Already notified
            }
        }

        $statement = $this->connDB->prepare("INSERT INTO notifications (user_id, actor_id, type, reference_id) VALUES (?, ?, ?, ?)");
        return $statement->execute([$userId, $actorId, $type, $referenceId]);
    }

    public function getNotifications(int $userId): array
    {
        $query = "
            SELECT 
                n.notification_id,
                n.type,
                n.reference_id,
                n.is_read,
                n.created_at,
                u.user_id as actor_id,
                u.username as actor_username,
                u.name as actor_name,
                u.profile_picture as actor_profile_picture
            FROM notifications n
            LEFT JOIN users u ON n.actor_id = u.user_id
            WHERE n.user_id = ?
            ORDER BY n.created_at DESC
            LIMIT 50
        ";

        $statement = $this->connDB->prepare($query);
        $statement->execute([$userId]);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function markAsRead(int $notificationId, int $userId): bool
    {
        $statement = $this->connDB->prepare("UPDATE notifications SET is_read = 1 WHERE notification_id = ? AND user_id = ?");
        return $statement->execute([$notificationId, $userId]);
    }

    public function markAllAsRead(int $userId): bool
    {
        $statement = $this->connDB->prepare("UPDATE notifications SET is_read = 1 WHERE user_id = ?");
        return $statement->execute([$userId]);
    }

    public function getUnreadCount(int $userId): int
    {
        $statement = $this->connDB->prepare("SELECT COUNT(*) FROM notifications WHERE user_id = ? AND is_read = 0");
        $statement->execute([$userId]);
        return (int) $statement->fetchColumn();
    }
}
