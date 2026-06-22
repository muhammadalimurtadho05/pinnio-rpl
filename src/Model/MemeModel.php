<?php

namespace App\Pinnio\Model;

class MemeModel
{
    public int $meme_id;
    public int $user_id;
    public ?string $image_path;
    public ?string $caption;
    public string $created_at;
    public string $updated_at;
}
