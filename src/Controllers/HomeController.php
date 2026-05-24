<?php
namespace Controllers;


use PDO;

class HomeController
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function showhomepage(): void
    {

        require_once __DIR__ . '/../Views/home.php';
    
    }
        public function showcontactpage(): void
    {

        ob_start();
        require_once __DIR__ . '/../Views/contact.php';
        $content = ob_get_clean();
        require __DIR__ . '/../Views/base.php';
    }
}