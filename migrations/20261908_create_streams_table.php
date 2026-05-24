<?php

class CreateStreamsTable
{
    public static function up($pdo)
    {
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS streams (
                id INT AUTO_INCREMENT PRIMARY KEY,
                user_id INT NOT NULL,
                category_id INT DEFAULT NULL,
                title VARCHAR(200) NOT NULL,
                description TEXT DEFAULT NULL,
                stream_key VARCHAR(64) DEFAULT NULL UNIQUE,
                thumbnail_url VARCHAR(255) DEFAULT NULL,
                status ENUM('scheduled','live','ended','cancelled') NOT NULL DEFAULT 'scheduled',
                viewer_count INT NOT NULL DEFAULT 0,
                peak_viewers INT NOT NULL DEFAULT 0,
                scheduled_at DATETIME DEFAULT NULL,
                started_at DATETIME DEFAULT NULL,
                ended_at DATETIME DEFAULT NULL,
                duration_seconds INT NOT NULL DEFAULT 0,
                is_featured BOOLEAN DEFAULT FALSE,
                has_replay BOOLEAN DEFAULT FALSE,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
                FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
        ");
    }

    public static function down($pdo)
    {
        $pdo->exec("DROP TABLE IF EXISTS streams");
    }
}
