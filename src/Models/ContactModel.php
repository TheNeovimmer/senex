<?php
namespace Models;

use PDO;

class ContactModel {
    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function createContact($nom, $telephone, $email, $sujet, $message) {
        $stmt = $this->pdo->prepare("
            INSERT INTO contacts (name , phone , email, sujet, message )
            VALUES (?, ?, ?, ?, ?
            )
        ");
        return $stmt->execute([$nom, $telephone, $email, $sujet, $message]);
    }
}
