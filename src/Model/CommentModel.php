<?php

namespace App\Pinnio\Model;

class CommentModel
{
  public int $comment_id;
  public int $user_id;
  public int $meme_id;
  public string $content;
  public string $created_at;
}