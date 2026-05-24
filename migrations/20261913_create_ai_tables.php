<?php

class CreateAiTables
{
    public static function up($pdo)
    {
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS ai_suggestions (
                id INT AUTO_INCREMENT PRIMARY KEY,
                type ENUM('challenge','highlight','recommendation','subtitle') NOT NULL,
                content JSON NOT NULL,
                source_stream_id INT DEFAULT NULL,
                target_user_id INT DEFAULT NULL,
                status ENUM('pending','approved','rejected') NOT NULL DEFAULT 'pending',
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (source_stream_id) REFERENCES streams(id) ON DELETE SET NULL,
                FOREIGN KEY (target_user_id) REFERENCES users(id) ON DELETE SET NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
        ");

        $pdo->exec("
            CREATE TABLE IF NOT EXISTS subtitles (
                id INT AUTO_INCREMENT PRIMARY KEY,
                stream_id INT NOT NULL,
                language VARCHAR(10) NOT NULL DEFAULT 'en',
                content JSON NOT NULL,
                is_ai_generated BOOLEAN DEFAULT FALSE,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (stream_id) REFERENCES streams(id) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
        ");

        $pdo->exec("
            CREATE TABLE IF NOT EXISTS stream_challenges (
                id INT AUTO_INCREMENT PRIMARY KEY,
                stream_id INT NOT NULL,
                challenge_id INT NOT NULL,
                is_active BOOLEAN DEFAULT FALSE,
                started_at DATETIME DEFAULT NULL,
                ended_at DATETIME DEFAULT NULL,
                FOREIGN KEY (stream_id) REFERENCES streams(id) ON DELETE CASCADE,
                FOREIGN KEY (challenge_id) REFERENCES challenges(id) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
        ");
    }

    public static function down($pdo)
    {
        $pdo->exec("DROP TABLE IF EXISTS stream_challenges");
        $pdo->exec("DROP TABLE IF EXISTS subtitles");
        $pdo->exec("DROP TABLE IF EXISTS ai_suggestions");
    }
}
