<?php

namespace App\Pinnio\Controller;

use App\Pinnio\Config\Database;
use App\Pinnio\Config\View;
use App\Pinnio\Repository\MessageRepository;
use App\Pinnio\Repository\UserRepository;
use App\Pinnio\Service\MessageService;
use App\Pinnio\Service\UserService;
use App\Pinnio\Exception\ValidationException;

class ChatController
{
    private MessageService $messageService;
    private UserService $userService;

    public function __construct()
    {
        $connDB = Database::connect();
        $this->messageService = new MessageService(new MessageRepository($connDB));
        $this->userService = new UserService(new UserRepository($connDB));
    }

    public function index(): void
    {
        $currentUserId = $_SESSION['auth']['user_id'];
        $user = $this->userService->getUserById($currentUserId);
        $conversations = $this->messageService->getConversations($currentUserId);

        View::app("chat_list", [
            "title" => "Messages — PinThread",
            "user" => $user,
            "conversations" => $conversations,
            "script" => ["chat.js"]
        ]);
    }

    public function detail(string $username): void
    {
        try {
            $currentUserId = $_SESSION['auth']['user_id'];
            $partnerUser = $this->userService->getUserByUsername($username);

            if ($partnerUser['user_id'] === $currentUserId) {
                // Cannot chat with self
                View::redirect("/chat");
                return;
            }

            $messages = $this->messageService->getMessages($currentUserId, $partnerUser['user_id']);
            $currentUser = $this->userService->getUserById($currentUserId);

            View::app("chat_detail", [
                "title" => "Chat with " . $partnerUser['name'] . " — PinThread",
                "user" => $currentUser,
                "partner" => $partnerUser,
                "messages" => $messages,
                "script" => ["chat.js"]
            ]);
        } catch (\Exception $e) {
            View::redirect("/chat");
        }
    }

    public function send(): void
    {
        header('Content-Type: application/json');

        try {
            $input = json_decode(file_get_contents('php://input'), true);
            $receiverId = $input['receiver_id'] ?? null;
            $text = $input['message_text'] ?? null;

            if (!$receiverId || !$text) {
                echo json_encode(['success' => false, 'message' => 'Missing data']);
                return;
            }

            $senderId = $_SESSION['auth']['user_id'];
            $message = $this->messageService->sendMessage($senderId, $receiverId, $text);

            echo json_encode([
                'success' => true,
                'data' => $message
            ]);
        } catch (ValidationException $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        } catch (\Exception $e) {
            echo json_encode(['success' => false, 'message' => 'An error occurred']);
        }
    }

    public function poll(string $username): void
    {
        header('Content-Type: application/json');

        try {
            $currentUserId = $_SESSION['auth']['user_id'];
            $partnerUser = $this->userService->getUserByUsername($username);
            $messages = $this->messageService->getMessages($currentUserId, $partnerUser['user_id']);

            echo json_encode([
                'success' => true,
                'data' => $messages
            ]);
        } catch (\Exception $e) {
            echo json_encode(['success' => false, 'message' => 'An error occurred']);
        }
    }
}
