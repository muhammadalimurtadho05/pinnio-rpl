<?php

use App\Pinnio\Config\Router;
use App\Pinnio\Controller\AuthController;
use App\Pinnio\Controller\CommentController;
use App\Pinnio\Controller\HomeController;
use App\Pinnio\Controller\MemeController;
use App\Pinnio\Controller\ProfileController;
use App\Pinnio\Controller\SettingController;
use App\Pinnio\Controller\SignupController;
use App\Pinnio\Middleware\AuthMiddleware;
use App\Pinnio\Controller\LikeController;
use App\Pinnio\Controller\SearchController;

require_once __DIR__ . "/vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

$home = new HomeController();
$signup = new SignupController();
$auth = new AuthController();
$profile = new ProfileController();
$meme = new MemeController();
$comment = new CommentController();
$setting = new SettingController();
$like = new LikeController();
$search = new SearchController();
$bookmark = new \App\Pinnio\Controller\BookmarkController();
$report = new \App\Pinnio\Controller\ReportController();

Router::add("/", "GET", fn() => $home->landing(), [
  fn() => AuthMiddleware::isAuth()
]);
Router::add("/home", "GET", fn() => $home->home(), [
  fn() => AuthMiddleware::isNotAuth()
]);

Router::add("/search", "GET", fn() => $search->page(), [
  fn() => AuthMiddleware::isNotAuth()
]);

Router::add("/search/([0-9a-zA-Z\-_]+)", "GET", fn($query) => $search->page($query), [
  fn() => AuthMiddleware::isNotAuth()
]);

Router::add("/pengaturan", "GET", fn() => $setting->index(), [
  fn() => AuthMiddleware::isNotAuth()
]);


Router::add("/profile", "GET", fn() => $profile->page(), [
  fn() => AuthMiddleware::isNotAuth()
]);
Router::add("/profile/bookmarks", "GET", fn() => $profile->bookmarks(), [
  fn() => AuthMiddleware::isNotAuth()
]);
Router::add("/profile/update", "POST", fn() => $profile->update(), [
  fn() => AuthMiddleware::isNotAuth()
]);
Router::add("/profile/delete", "GET", fn() => $profile->delete(), [
  fn() => AuthMiddleware::isNotAuth()
]);
Router::add("/profile/update-password", "POST", fn() => $profile->updatePassword(), [
  fn() => AuthMiddleware::isNotAuth()
]);


Router::add("/signup", "GET", fn() => $signup->page(), [
  fn() => AuthMiddleware::isAuth()
]);
Router::add("/signup", "POST", fn() => $signup->save(), [
  fn() => AuthMiddleware::isAuth()
]);


Router::add("/login", "GET", fn() => $auth->page(), [
  fn() => AuthMiddleware::isAuth()
]);
Router::add("/login", "POST", fn() => $auth->auth(), [
  fn() => AuthMiddleware::isAuth()
]);


Router::add("/logout", "GET", fn() => $auth->logout(), [
  fn() => AuthMiddleware::isNotAuth()
]);

Router::add("/meme/like", "POST", fn() => $like->toggle(), [
  fn() => AuthMiddleware::isNotAuth()
]);

Router::add("/meme/bookmark", "POST", fn() => $bookmark->toggle(), [
  fn() => AuthMiddleware::isNotAuth()
]);

Router::add("/meme/report", "POST", fn() => $report->report(), [
  fn() => AuthMiddleware::isNotAuth()
]);

Router::add("/meme/create", "POST", fn() => $meme->createMeme(), [
  fn() => AuthMiddleware::isNotAuth()
]);
Router::add("/meme/([0-9a-zA-Z]*)", "GET", fn($meme_id) => $meme->viewMeme($meme_id), [
  fn() => AuthMiddleware::isNotAuth()
]);
Router::add("/meme/([0-9a-zA-Z]*)/delete", "GET", fn($meme_id) => $meme->deleteMeme($meme_id), [
  fn() => AuthMiddleware::isNotAuth()
]);
Router::add("/meme/([0-9a-zA-Z]*)/edit", "GET", fn($meme_id) => $meme->editMeme($meme_id), [
  fn() => AuthMiddleware::isNotAuth()
]);
Router::add("/meme/([0-9a-zA-Z]*)/edit", "POST", fn($meme_id) => $meme->updateMeme($meme_id), [
  fn() => AuthMiddleware::isNotAuth()
]);


Router::add("/comment/([0-9a-zA-Z]*)", "POST", fn($meme_id) => $comment->saveComment($meme_id), [
  fn() => AuthMiddleware::isNotAuth()
]);
Router::add("/comment/([0-9a-zA-Z]*)/delete", "GET", fn($comment_id) => $comment->deleteComment($comment_id), [
  fn() => AuthMiddleware::isNotAuth()
]);

Router::execute();
