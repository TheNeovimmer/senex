<?php
namespace Services;
use PDO;
use Models\AiSuggestionModel;
use Models\ChallengeModel;
use Models\HighlightModel;

class AIService {
    private AiSuggestionModel $suggestionModel;
    private ChallengeModel $challengeModel;
    private HighlightModel $highlightModel;

    public function __construct(PDO $pdo) {
        $this->suggestionModel = new AiSuggestionModel($pdo);
        $this->challengeModel = new ChallengeModel($pdo);
        $this->highlightModel = new HighlightModel($pdo);
    }

    public function generateChallengeSuggestion(int $streamId, array $context = []): int|false {
        $prompt = "Génère un défi pour un stream gaming. Contexte: " . json_encode($context);
        $suggestion = $this->callOpenAI($prompt);
        return $this->suggestionModel->insert([
            'type' => 'challenge',
            'content' => json_encode($suggestion),
            'source_stream_id' => $streamId,
            'status' => 'pending'
        ]);
    }

    public function generateHighlights(int $streamId): array {
        $prompt = "Analyse ce stream et identifie les meilleurs moments pour des highlights.";
        $result = $this->callOpenAI($prompt);
        $this->suggestionModel->insert([
            'type' => 'highlight',
            'content' => json_encode($result),
            'source_stream_id' => $streamId,
            'status' => 'pending'
        ]);
        return $result;
    }

    public function getRecommendations(int $userId): array {
        $prompt = "Recommande des streams à un utilisateur basé sur son historique.";
        $result = $this->callOpenAI($prompt);
        $this->suggestionModel->insert([
            'type' => 'recommendation',
            'content' => json_encode($result),
            'target_user_id' => $userId,
            'status' => 'pending'
        ]);
        return $result;
    }

    public function moderateContent(string $content): array {
        $result = $this->callOpenAI("Analyse ce contenu pour modération: " . $content);
        return [
            'is_appropriate' => !str_contains($result, 'inapproprié'),
            'reason' => $result
        ];
    }

    public function generateSubtitles(int $streamId, string $language, string $audioText): int|false {
        $prompt = "Traduis ce texte en $language: $audioText";
        $translation = $this->callOpenAI($prompt);
        return $this->suggestionModel->insert([
            'type' => 'subtitle',
            'content' => json_encode(['language' => $language, 'text' => $translation]),
            'source_stream_id' => $streamId,
            'status' => 'approved'
        ]);
    }

    private function callOpenAI(string $prompt): string {
        $apiKey = $_ENV['OPENAI_API_KEY'] ?? '';
        if (empty($apiKey)) {
            return "Fonctionnalité AI simulée. Configurez OPENAI_API_KEY dans .env";
        }
        $ch = curl_init('https://api.openai.com/v1/chat/completions');
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => [
                'Authorization: Bearer ' . $apiKey,
                'Content-Type: application/json'
            ],
            CURLOPT_POSTFIELDS => json_encode([
                'model' => 'gpt-3.5-turbo',
                'messages' => [['role' => 'user', 'content' => $prompt]],
                'max_tokens' => 500
            ])
        ]);
        $response = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($response, true);
        return $data['choices'][0]['message']['content'] ?? 'Pas de réponse disponible.';
    }
}
