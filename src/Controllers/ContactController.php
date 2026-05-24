<?php
namespace Controllers;

use Models\ContactModel;
use Services\Mailer;

class ContactController {
    private $contactModel;
    private $mailer;

    public function __construct($pdo) {
        $this->contactModel = new ContactModel($pdo);
        $this->mailer = new Mailer();
    }
    public function showContactPage(){
        require_once __DIR__ . '/../Views/contact.php';
    }
    public function shownextpage(){
        require_once __DIR__ . '/../Views/next.php';
    }
    public function showreplayspage(){
        require_once __DIR__ . '/../Views/replays.php';
    }
    public function showaboutuspage(){
        require_once __DIR__ . '/../Views/aboutus.php';
    }
    public function showloginpage(){
        require_once __DIR__ . '/../Views/login.php';
    }
    public function showsigninpage(){
        require_once __DIR__ . '/../Views/signin.php';
    }
    public function sendMessageContact() {
        session_start();

        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                header("Location: /contact");
                exit();
            }

            if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                $_SESSION["error"] = "CSRF token invalide. Veuillez réessayer.";
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
                $_SESSION["message"] = "Votre message a bien été envoyé. Nous vous répondrons dès que possible.";
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