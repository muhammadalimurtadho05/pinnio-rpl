<?php

namespace App\Pinnio\Repository;

class ReportRepository
{
  private static \PDO $connDB;

  public function __construct(\PDO $connDB)
  {
    self::$connDB = $connDB;
  }

  public function addReport(int $reporterID, int $memeID, string $reason): \PDOStatement
  {
    $statement = self::$connDB->prepare("INSERT INTO reports (reporter_id, target_meme_id, reason) VALUES (?, ?, ?)");
    $statement->execute([$reporterID, $memeID, $reason]);
    return $statement;
  }
}
