<?php

namespace App\Pinnio\Controller;

use App\Pinnio\Config\Database;
use App\Pinnio\Config\View;
use App\Pinnio\Exception\ValidationException;
use App\Pinnio\Model\CommentModel;
use App\Pinnio\Repository\CommentRepository;
use App\Pinnio\Service\CommentService;

class CommentController
{
  private static CommentService $commentService;
  private static CommentModel $commentModel;
  
  public function __construct()
  {
    $connDB = Database::connect();
    $commentRepository = new CommentRepository($connDB);

    self::$commentService = new CommentService($commentRepository);
    self::$commentModel = new CommentModel();
  }

  public function saveComment($meme_id): void
  {
    try {
      self::$commentModel->user_id = $_SESSION["auth"]["user_id"];
      self::$commentModel->meme_id = $meme_id;
      self::$commentModel->content = $_POST["content"];

      var_dump(self::$commentModel);
  
      self::$commentService->saveComment(self::$commentModel);
      View::redirect("/meme/$meme_id");
    } catch (ValidationException $e) {
      View::redirect("/meme/$meme_id");
    }
  }

  public function deleteComment($comment_id): void
  {
    // Ambil meme_id dari query string (?meme_id=xxx)
    $meme_id = $_GET["meme_id"] ?? null;

    try {
      // Lakukan penghapusan
      self::$commentService->deleteCommentByID($comment_id);

      // Jika ada meme_id, balik ke postingan tersebut, jika tidak ada balik ke home
      if ($meme_id) {
        View::redirect("/meme/" . $meme_id);
      } else {
        View::redirect("/home");
      }
    } catch (\Exception $e) {
      View::redirect("/home");
    }
  }
}