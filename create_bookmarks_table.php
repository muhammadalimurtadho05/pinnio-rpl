<?php
require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

use App\Pinnio\Config\Database;

try {
    $conn = Database::connect();
    
    $sql = "
    CREATE TABLE IF NOT EXISTS `bookmarks` (
      `bookmark_id` int NOT NULL AUTO_INCREMENT,
      `user_id` int DEFAULT NULL,
      `meme_id` int DEFAULT NULL,
      `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
      PRIMARY KEY (`bookmark_id`),
      UNIQUE KEY `user_id` (`user_id`,`meme_id`),
      KEY `meme_id` (`meme_id`),
      CONSTRAINT `bookmarks_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
      CONSTRAINT `bookmarks_ibfk_2` FOREIGN KEY (`meme_id`) REFERENCES `memes` (`meme_id`) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
    ";
    
    $conn->exec($sql);
    echo "Table 'bookmarks' created successfully.\n";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
