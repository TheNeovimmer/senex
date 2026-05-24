<?php

class CreateUserTables
{
    public static function up($pdo)
    {
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS user_profiles (
                id INT AUTO_INCREMENT PRIMARY KEY,
                user_id INT NOT NULL UNIQUE,
                bio TEXT DEFAULT NULL,
                skills JSON DEFAULT NULL,
                social_links JSON DEFAULT NULL,
                banner_url VARCHAR(255) DEFAULT NULL,
                experience_points INT NOT NULL DEFAULT 0,
                level INT NOT NULL DEFAULT 1,
                popularity_score DECIMAL(10,2) NOT NULL DEFAULT 0.00,
                total_challenges INT NOT NULL DEFAULT 0,
                total_streams INT NOT NULL DEFAULT 0,
                total_followers INT NOT NULL DEFAULT 0,
                streak_days INT NOT NULL DEFAULT 0,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
        ");

        $pdo->exec("
            CREATE TABLE IF NOT EXISTS user_badges (
                id INT AUTO_INCREMENT PRIMARY KEY,
                user_id INT NOT NULL,
                badge_id INT NOT NULL,
                earned_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                is_displayed BOOLEAN DEFAULT TRUE,
                UNIQUE KEY user_badge_unique (user_id, badge_id),
                FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
                FOREIGN KEY (badge_id) REFERENCES badges(id) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
        ");

        $pdo->exec("
            CREATE TABLE IF NOT EXISTS follows (
                id INT AUTO_INCREMENT PRIMARY KEY,
                follower_id INT NOT NULL,
                following_id INT NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                UNIQUE KEY follow_unique (follower_id, following_id),
                FOREIGN KEY (follower_id) REFERENCES users(id) ON DELETE CASCADE,
                FOREIGN KEY (following_id) REFERENCES users(id) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
        ");
    }

    public static function down($pdo)
    {
        $pdo->exec("DROP TABLE IF EXISTS follows");
        $pdo->exec("DROP TABLE IF EXISTS user_badges");
        $pdo->exec("DROP TABLE IF EXISTS user_profiles");
    }
}
