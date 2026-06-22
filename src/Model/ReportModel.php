<?php

namespace App\Pinnio\Model;

class ReportModel
{
    public int $report_id;
    public ?int $reporter_id = null;
    public ?int $target_meme_id = null;
    public ?int $target_user_id = null;
    public string $reason;
    public string $status = 'pending';
    public string $created_at;
}
