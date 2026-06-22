<?php

require_once __DIR__ . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
require_once __DIR__ . '/src/Config/Database.php';

try {
    $conn = \App\Pinnio\Config\Database::connect();
    
    // Check if actor_id column already exists
    $stmt = $conn->query("SHOW COLUMNS FROM notifications LIKE 'actor_id'");
    $exists = $stmt->fetch();
    
    if (!$exists) {
        $conn->exec("ALTER TABLE notifications ADD COLUMN actor_id int DEFAULT NULL AFTER user_id");
        echo "Successfully added actor_id column to notifications table.\n";
    } else {
        echo "Column actor_id already exists.\n";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
