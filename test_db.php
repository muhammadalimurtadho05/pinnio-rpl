<?php
require_once __DIR__ . "/vendor/autoload.php";
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

try {
    $db_host = $_ENV["DB_HOST"];
    $db_port = $_ENV["DB_PORT"];
    $db_database = $_ENV["DB_DATABASE"];
    $db_username = $_ENV["DB_USERNAME"];
    $db_password = $_ENV["DB_PASSWORD"];

    $pdo = new \PDO("mysql:host=$db_host:$db_port;dbname=$db_database", $db_username, $db_password);
    
    $result = [];
    
    // Check tables
    $stmt = $pdo->query("SHOW TABLES");
    $result['tables'] = $stmt->fetchAll(\PDO::FETCH_COLUMN);
    
    // Check structure of likes table if exists
    if (in_array('likes', $result['tables'])) {
        $stmt = $pdo->query("DESCRIBE likes");
        $result['likes_structure'] = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    // Check procedure code for get_memes
    $stmt = $pdo->query("SHOW CREATE PROCEDURE get_memes");
    $result['get_memes_procedure'] = $stmt->fetch(\PDO::FETCH_ASSOC);

    // Check procedure code for get_meme_by_id
    $stmt = $pdo->query("SHOW CREATE PROCEDURE get_meme_by_id");
    $result['get_meme_by_id_procedure'] = $stmt->fetch(\PDO::FETCH_ASSOC);
    
    header('Content-Type: application/json');
    echo json_encode($result, JSON_PRETTY_PRINT);
} catch (\Exception $e) {
    header('Content-Type: application/json');
    echo json_encode(['error' => $e->getMessage()], JSON_PRETTY_PRINT);
}
