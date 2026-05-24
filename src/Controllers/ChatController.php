<?php
namespace Controllers;
use PDO;
use Services\ChatService;
use Services\AuthService;

class ChatController {
    private ChatService $chatService;
    private AuthService $authService;

    public function __construct(PDO $pdo) {
        $this->chatService = new ChatService($pdo);
        $this->authService = new AuthService($pdo);
    }

    public function getMessages(): void {
        $streamId = (int)($_GET['stream_id'] ?? 0);
        $after = (int)($_GET['after'] ?? 0);
        if (!$streamId) {
            echo json_encode(['error' => 'stream_id required']);
            return;
        }
        $messages = $this->chatService->getMessages($streamId, 50);
        $lastId = 0;
        $filtered = [];
        foreach ($messages as $m) {
            if ($m['id'] > $after) {
                $filtered[] = $m;
            }
            $lastId = max($lastId, (int)$m['id']);
        }
        header('Content-Type: application/json');
        echo json_encode(['messages' => $filtered, 'last_id' => $lastId]);
    }

    public function sendMessage(): void {
        header('Content-Type: application/json');
        $user = $this->authService->getCurrentUser();
        if (!$user) {
            http_response_code(401);
            echo json_encode(['error' => 'Non authentifié']);
            return;
        }
        $input = json_decode(file_get_contents('php://input'), true);
        $streamId = (int)($input['stream_id'] ?? 0);
        $message = trim($input['message'] ?? '');
        if (!$streamId || empty($message)) {
            http_response_code(400);
            echo json_encode(['error' => 'stream_id et message requis']);
            return;
        }
        $id = $this->chatService->send($streamId, $user['id'], $message);
        if ($id) {
            echo json_encode(['success' => true, 'id' => $id]);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Erreur lors de l\'envoi']);
        }
    }
}
