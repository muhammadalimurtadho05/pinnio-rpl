<?php

namespace App\Pinnio\Repository;

use App\Pinnio\Model\ReportModel;

class ReportRepository
{
    private \PDO $connDB;

    public function __construct(\PDO $connDB)
    {
        $this->connDB = $connDB;
    }

    public function findAll(): \PDOStatement
    {
        $statement = $this->connDB->prepare("
            SELECT r.*, 
                   u.username as reporter_username,
                   t_user.username as target_username
            FROM reports r
            LEFT JOIN users u ON r.reporter_id = u.user_id
            LEFT JOIN users t_user ON r.target_user_id = t_user.user_id
            ORDER BY r.created_at DESC
        ");
        $statement->execute();
        return $statement;
    }

    public function delete(int $report_id): \PDOStatement
    {
        $statement = $this->connDB->prepare("DELETE FROM reports WHERE report_id = ?");
        $statement->execute([$report_id]);
        return $statement;
    }

    public function save(ReportModel $model): \PDOStatement
    {
        $statement = $this->connDB->prepare("
            INSERT INTO reports (reporter_id, target_meme_id, target_user_id, reason, status) 
            VALUES (?, ?, ?, ?, ?)
        ");
        $statement->execute([
            $model->reporter_id, 
            $model->target_meme_id, 
            $model->target_user_id, 
            $model->reason, 
            $model->status
        ]);
        return $statement;
    }

    public function getTotalReportsCount(): int
    {
        $statement = $this->connDB->query("SELECT COUNT(*) FROM reports");
        return (int) $statement->fetchColumn();
    }
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
