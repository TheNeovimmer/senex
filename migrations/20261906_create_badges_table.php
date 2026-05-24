<?php

class CreateBadgesTable
{
    public static function up($pdo)
    {
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS badges (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(100) NOT NULL,
                slug VARCHAR(100) NOT NULL UNIQUE,
                description TEXT DEFAULT NULL,
                icon VARCHAR(255) DEFAULT NULL,
                criteria_type ENUM('xp_level','challenge_count','stream_count','follower_count','streak','special') NOT NULL,
                criteria_value INT NOT NULL DEFAULT 0,
                xp_reward INT NOT NULL DEFAULT 0,
                color VARCHAR(7) DEFAULT '#F15BB5',
                is_active BOOLEAN DEFAULT TRUE,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
        ");
    }

    public static function down($pdo)
    {
        $pdo->exec("DROP TABLE IF EXISTS badges");
    }
}
