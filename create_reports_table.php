<?php
require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

use App\Pinnio\Config\Database;

try {
    $conn = Database::connect();
    
    $sql = "
    CREATE TABLE IF NOT EXISTS `reports` (
      `report_id` int NOT NULL AUTO_INCREMENT,
      `reporter_id` int NOT NULL,
      `target_meme_id` int NOT NULL,
      `reason` varchar(255) NOT NULL,
      `status` enum('pending','reviewed','dismissed') DEFAULT 'pending',
      `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
      PRIMARY KEY (`report_id`),
      KEY `reporter_id` (`reporter_id`),
      KEY `target_meme_id` (`target_meme_id`),
      CONSTRAINT `reports_ibfk_1` FOREIGN KEY (`reporter_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
      CONSTRAINT `reports_ibfk_2` FOREIGN KEY (`target_meme_id`) REFERENCES `memes` (`meme_id`) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
    ";
    
    $conn->exec($sql);
    echo "Table 'reports' created successfully.\n";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
