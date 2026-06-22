<?php

namespace App\Pinnio\Repository;

use PDO;

class MessageRepository
{
    private PDO $connDB;

    public function __construct(PDO $connDB)
    {
        $this->connDB = $connDB;
    }

    public function getConversations(int $userId): array
    {
        // Get the latest message for each conversation
        $query = "
            SELECT 
                u.user_id,
                u.username,
                u.name,
                u.profile_picture,
                m.message_text as last_message,
                m.sent_at as last_message_time,
                m.is_read
            FROM users u
            JOIN (
                SELECT 
                    CASE 
                        WHEN sender_id = ? THEN receiver_id 
                        ELSE sender_id 
                    END AS partner_id,
                    MAX(message_id) AS max_message_id
                FROM messages
                WHERE sender_id = ? OR receiver_id = ?
                GROUP BY partner_id
            ) AS latest_msg ON u.user_id = latest_msg.partner_id
            JOIN messages m ON m.message_id = latest_msg.max_message_id
            ORDER BY m.sent_at DESC
        ";

        $statement = $this->connDB->prepare($query);
        $statement->execute([$userId, $userId, $userId]);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getMessages(int $user1, int $user2): array
    {
        $query = "
            SELECT 
                m.message_id,
                m.sender_id,
                m.receiver_id,
                m.message_text,
                m.sent_at,
                m.is_read
            FROM messages m
            WHERE (m.sender_id = ? AND m.receiver_id = ?) 
               OR (m.sender_id = ? AND m.receiver_id = ?)
            ORDER BY m.sent_at ASC
        ";

        $statement = $this->connDB->prepare($query);
        $statement->execute([$user1, $user2, $user2, $user1]);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function sendMessage(int $senderId, int $receiverId, string $text): int
    {
        $statement = $this->connDB->prepare("INSERT INTO messages (sender_id, receiver_id, message_text) VALUES (?, ?, ?)");
        $statement->execute([$senderId, $receiverId, $text]);
        return (int) $this->connDB->lastInsertId();
    }

    public function markMessagesAsRead(int $senderId, int $receiverId): bool
    {
        $statement = $this->connDB->prepare("UPDATE messages SET is_read = 1 WHERE sender_id = ? AND receiver_id = ?");
        return $statement->execute([$senderId, $receiverId]);
    }

    public function getUnreadCount(int $userId): int
    {
        $statement = $this->connDB->prepare("SELECT COUNT(*) FROM messages WHERE receiver_id = ? AND is_read = 0");
        $statement->execute([$userId]);
        return (int) $statement->fetchColumn();
    }
}
