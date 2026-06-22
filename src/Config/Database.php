<?php

namespace App\Pinnio\Config;

class Database
{
  public static function connect(): \PDO
  {
    $db_host = $_ENV["DB_HOST"];
    $db_port = $_ENV["DB_PORT"];
    $db_database = $_ENV["DB_DATABASE"];
    $db_username = $_ENV["DB_USERNAME"];
    $db_password = $_ENV["DB_PASSWORD"];

    return new \PDO("mysql:host=$db_host:$db_port;dbname=$db_database", $db_username, $db_password);
  }
}