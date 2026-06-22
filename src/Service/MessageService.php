<?php

namespace App\Pinnio\Service;

use App\Pinnio\Repository\MessageRepository;
use App\Pinnio\Exception\ValidationException;

class MessageService
{
    private MessageRepository $messageRepository;

    public function __construct(MessageRepository $messageRepository)
    {
        $this->messageRepository = $messageRepository;
    }

    public function getConversations(int $userId): array
    {
        return $this->messageRepository->getConversations($userId);
    }

    public function getMessages(int $userId, int $partnerId): array
    {
        // Mark messages from partner as read since we are viewing them
        $this->messageRepository->markMessagesAsRead($partnerId, $userId);
        return $this->messageRepository->getMessages($userId, $partnerId);
    }

    public function sendMessage(int $senderId, int $receiverId, string $text): array
    {
        if (empty(trim($text))) {
            throw new ValidationException("Message cannot be empty");
        }
        
        if ($senderId === $receiverId) {
            throw new ValidationException("Cannot send message to yourself");
        }

        $messageId = $this->messageRepository->sendMessage($senderId, $receiverId, trim($text));

        // Trigger notification
        $connDB = \App\Pinnio\Config\Database::connect();
        $notificationService = new \App\Pinnio\Service\NotificationService(new \App\Pinnio\Repository\NotificationRepository($connDB));
        $notificationService->addNotification($receiverId, $senderId, 'message', $messageId);

        return [
            'message_id' => $messageId,
            'sender_id' => $senderId,
            'receiver_id' => $receiverId,
            'message_text' => htmlspecialchars(trim($text)),
            'sent_at' => date('Y-m-d H:i:s'),
            'is_read' => 0
        ];
    }
}
