<?php

namespace App\Pinnio\Service;

use App\Pinnio\Model\CommentModel;
use App\Pinnio\Repository\CommentRepository;
use App\Pinnio\Utils\CensorString;

class CommentService
{
  private static CommentRepository $commentRepository;

  public function __construct(CommentRepository $commentRepository)
  {
    self::$commentRepository = $commentRepository;
  }

  public function saveComment(CommentModel $commentModel): bool
  {
    // ===== PROSES SENSOR ISI KOMENTAR =====
    $commentModel->content = CensorString::filter($commentModel->content);

    return self::$commentRepository->saveComment($commentModel);
  }

  public function getCommentsByMemeId(int $meme_id): array
  {
    return self::$commentRepository->getCommentsByMemeId($meme_id);
  }

  public function deleteCommentByID(int $comment_id): bool
  {
    return self::$commentRepository->deleteCommentByID($comment_id);
  }

  public function getCommentByID(int $comment_id): array
  {
    return self::$commentRepository->getCommentByID($comment_id);
  }
}
