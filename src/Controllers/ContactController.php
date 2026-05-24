<?php
namespace Controllers;

use Models\ContactModel;
use Models\ReplayModel;
use Models\ChallengeModel;
use Models\StreamModel;
use Models\UserModel;
use Services\Mailer;
use Services\AuthService;
use PDO;

class ContactController {
    private $contactModel;
    private $mailer;
    private AuthService $authService;
    private PDO $pdo;
    private ReplayModel $replayModel;
    private ChallengeModel $challengeModel;
    private StreamModel $streamModel;
    private UserModel $userModel;

    public function __construct(PDO $pdo) {
        $this->contactModel = new ContactModel($pdo);
        $this->mailer = new Mailer();
        $this->authService = new AuthService($pdo);
        $this->pdo = $pdo;
        $this->replayModel = new ReplayModel($pdo);
        $this->challengeModel = new ChallengeModel($pdo);
        $this->streamModel = new StreamModel($pdo);
        $this->userModel = new UserModel($pdo);
    }

    public function showContactPage(){
        $csrf = $this->authService->generateCsrf();
        $title = "SENEX - Contact";
        ob_start();
        require_once __DIR__ . '/../Views/contact.php';
        $content = ob_get_clean();
        require __DIR__ . '/../Views/base.php';
    }

    public function shownextpage(){
        $upcomingChallenges = $this->challengeModel->findActive();
        $title = "SENEX - Next Dare";
        ob_start();
        require_once __DIR__ . '/../Views/next.php';
        $content = ob_get_clean();
        require __DIR__ . '/../Views/base.php';
    }

    public function showreplayspage(){
        $replays = $this->replayModel->findPublished();
        if (empty($replays)) {
            $replays = [];
        }
        $title = "SENEX - Replays";
        ob_start();
        require_once __DIR__ . '/../Views/replays.php';
        $content = ob_get_clean();
        require __DIR__ . '/../Views/base.php';
    }

    public function showaboutuspage(){
        $userCount = $this->userModel->count();
        $challengeCount = $this->challengeModel->count();
        $streamCount = $this->streamModel->count();
        $title = "SENEX - About Us";
        ob_start();
        require_once __DIR__ . '/../Views/aboutus.php';
        $content = ob_get_clean();
        require __DIR__ . '/../Views/base.php';
    }

    public function showloginpage(){
        require_once __DIR__ . '/../Views/login.php';
    }

    public function showsigninpage(){
        require_once __DIR__ . '/../Views/signin.php';
    }

    public function sendMessageContact() {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                header("Location: /contact");
                exit();
            }

            if (!$this->authService->verifyCsrf($_POST['csrf_token'] ?? '')) {
                $_SESSION["error"] = "Session invalide. Veuillez réessayer.";
                header("Location: /contact");
                exit();
            }

            $nom = trim($_POST['name'] ?? '');
            $telephone = trim($_POST['phone'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $sujet = trim($_POST['subject'] ?? '');
            $message = trim($_POST['message'] ?? '');

            if (empty($nom) || empty($telephone) || empty($email) || empty($sujet) || empty($message)) {
                $_SESSION["error"] = "Tous les champs sont obligatoires.";
                header("Location: /contact");
                exit();
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION["error"] = "L'adresse e-mail n'est pas valide.";
                header("Location: /contact");
                exit();
            }

            $contenuEmail = "
                <h2>Message de contact</h2>
                <p><strong>Nom :</strong> " . htmlspecialchars($nom) . "</p>
                <p><strong>Téléphone :</strong> " . htmlspecialchars($telephone) . "</p>
                <p><strong>Email :</strong> " . htmlspecialchars($email) . "</p>
                <p><strong>Sujet :</strong> " . htmlspecialchars($sujet) . "</p>
                <p><strong>Message :</strong><br>" . nl2br(htmlspecialchars($message)) . "</p>
            ";

            $destinataire = $_ENV['MAIL_ADMIN'] ?? 'admin@monsite.com';
            $result = $this->mailer->send($destinataire, $nom, $sujet, $contenuEmail);

            if (strpos($result, "Erreur") !== false) {
                $_SESSION["error"] = "Erreur lors de l'envoi du message.";
                header("Location: /contact");
                exit();
            }

            $contactCreated = $this->contactModel->createContact($nom, $telephone, $email, $sujet, $message);
            if ($contactCreated) {
                $_SESSION["message"] = "Votre message a bien été envoyé.";
            } else {
                $_SESSION["error"] = "Erreur lors de l'enregistrement du message.";
            }

            header("Location: /contact");
            exit();

        } catch (\Exception $e) {
            $_SESSION["error"] = "Une erreur inattendue s'est produite.";
            header("Location: /contact");
            exit();
        }
    }
}