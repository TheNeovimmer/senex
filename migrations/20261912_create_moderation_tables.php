<?php

class CreateModerationTables
{
    public static function up($pdo)
    {
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS reports (
                id INT AUTO_INCREMENT PRIMARY KEY,
                reporter_id INT NOT NULL,
                reported_user_id INT DEFAULT NULL,
                stream_id INT DEFAULT NULL,
                challenge_id INT DEFAULT NULL,
                reason ENUM('inappropriate_content','harassment','spam','cheating','impersonation','other') NOT NULL,
                description TEXT DEFAULT NULL,
                status ENUM('pending','reviewed','dismissed','action_taken') NOT NULL DEFAULT 'pending',
                reviewed_by INT DEFAULT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                FOREIGN KEY (reporter_id) REFERENCES users(id) ON DELETE CASCADE,
                FOREIGN KEY (reported_user_id) REFERENCES users(id) ON DELETE SET NULL,
                FOREIGN KEY (stream_id) REFERENCES streams(id) ON DELETE SET NULL,
                FOREIGN KEY (challenge_id) REFERENCES challenges(id) ON DELETE SET NULL,
                FOREIGN KEY (reviewed_by) REFERENCES users(id) ON DELETE SET NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
        ");

        $pdo->exec("
            CREATE TABLE IF NOT EXISTS notifications (
                id INT AUTO_INCREMENT PRIMARY KEY,
                user_id INT NOT NULL,
                type VARCHAR(50) NOT NULL,
                title VARCHAR(200) NOT NULL,
                message TEXT DEFAULT NULL,
                link VARCHAR(255) DEFAULT NULL,
                is_read BOOLEAN DEFAULT FALSE,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
        ");
    }

    public static function down($pdo)
    {
        $pdo->exec("DROP TABLE IF EXISTS notifications");
        $pdo->exec("DROP TABLE IF EXISTS reports");
    }
}
