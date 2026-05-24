<?php

class CreateChallengesTable
{
    public static function up($pdo)
    {
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS challenges (
                id INT AUTO_INCREMENT PRIMARY KEY,
                user_id INT NOT NULL,
                category_id INT DEFAULT NULL,
                title VARCHAR(200) NOT NULL,
                description TEXT DEFAULT NULL,
                rules TEXT DEFAULT NULL,
                objectives JSON DEFAULT NULL,
                difficulty ENUM('easy','medium','hard','extreme') NOT NULL DEFAULT 'medium',
                type ENUM('solo','team','viewer') NOT NULL DEFAULT 'solo',
                duration_seconds INT NOT NULL DEFAULT 60,
                xp_reward INT NOT NULL DEFAULT 100,
                status ENUM('draft','pending','active','completed','cancelled') NOT NULL DEFAULT 'draft',
                is_featured BOOLEAN DEFAULT FALSE,
                thumbnail_url VARCHAR(255) DEFAULT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
                FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
        ");
    }

    public static function down($pdo)
    {
        $pdo->exec("DROP TABLE IF EXISTS challenges");
    }
}
