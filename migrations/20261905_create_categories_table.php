<?php

class CreateCategoriesTable
{
    public static function up($pdo)
    {
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS categories (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(100) NOT NULL,
                slug VARCHAR(100) NOT NULL UNIQUE,
                type ENUM('stream','challenge','both') NOT NULL DEFAULT 'both',
                icon VARCHAR(50) DEFAULT NULL,
                color VARCHAR(7) DEFAULT '#F15BB5',
                description TEXT DEFAULT NULL,
                is_active BOOLEAN DEFAULT TRUE,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
        ");
    }

    public static function down($pdo)
    {
        $pdo->exec("DROP TABLE IF EXISTS categories");
    }
}
