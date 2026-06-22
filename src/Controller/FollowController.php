<?php

namespace App\Pinnio\Controller;

use App\Pinnio\Config\Database;
use App\Pinnio\Repository\FollowRepository;
use App\Pinnio\Service\FollowService;
use App\Pinnio\Exception\ValidationException;

class FollowController
{
    private FollowService $followService;

    public function __construct()
    {
        $connDB = Database::connect();
        $this->followService = new FollowService(new FollowRepository($connDB));
    }

    public function toggle(): void
    {
        header('Content-Type: application/json');

        try {
            $input = json_decode(file_get_contents('php://input'), true);
            $following_id = $input['user_id'] ?? null;

            if (!$following_id) {
                echo json_encode(['success' => false, 'message' => 'Missing user ID']);
                return;
            }

            $follower_id = $_SESSION['auth']['user_id'];
            
            $result = $this->followService->toggleFollow($follower_id, $following_id);
            
            echo json_encode([
                'success' => true,
                'status' => $result['status']
            ]);
            
        } catch (ValidationException $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        } catch (\Exception $e) {
            echo json_encode(['success' => false, 'message' => 'An error occurred while processing your request.']);
        }
    }
}
