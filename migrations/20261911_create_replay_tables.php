<?php

class CreateReplayTables
{
    public static function up($pdo)
    {
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS replays (
                id INT AUTO_INCREMENT PRIMARY KEY,
                stream_id INT NOT NULL,
                title VARCHAR(200) NOT NULL,
                description TEXT DEFAULT NULL,
                video_url VARCHAR(255) DEFAULT NULL,
                thumbnail_url VARCHAR(255) DEFAULT NULL,
                duration_seconds INT NOT NULL DEFAULT 0,
                view_count INT NOT NULL DEFAULT 0,
                is_published BOOLEAN DEFAULT TRUE,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (stream_id) REFERENCES streams(id) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
        ");

        $pdo->exec("
            CREATE TABLE IF NOT EXISTS highlights (
                id INT AUTO_INCREMENT PRIMARY KEY,
                stream_id INT NOT NULL,
                title VARCHAR(200) DEFAULT NULL,
                description TEXT DEFAULT NULL,
                video_url VARCHAR(255) DEFAULT NULL,
                thumbnail_url VARCHAR(255) DEFAULT NULL,
                start_time_seconds INT NOT NULL DEFAULT 0,
                end_time_seconds INT NOT NULL DEFAULT 0,
                is_ai_generated BOOLEAN DEFAULT FALSE,
                is_published BOOLEAN DEFAULT TRUE,
                view_count INT NOT NULL DEFAULT 0,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (stream_id) REFERENCES streams(id) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
        ");
    }

    public static function down($pdo)
    {
        $pdo->exec("DROP TABLE IF EXISTS highlights");
        $pdo->exec("DROP TABLE IF EXISTS replays");
    }
}
