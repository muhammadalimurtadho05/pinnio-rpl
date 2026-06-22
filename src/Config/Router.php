<?php

namespace App\Pinnio\Config;

class Router
{
  private static array $routes = [];

  public static function add(string $path, string $http_method, callable $method, ?array $middlewares = null): void
  {
    self::$routes[] = [
      "path" => $path,
      "http_method" => $http_method,
      "method" => $method,
      "middlewares" => $middlewares,
    ];
  }

  public static function execute(): void
  {
    foreach (self::$routes as $route) {
      $pattern = "#^" . $route["path"] . "$#";

      if (
        preg_match($pattern, $_SERVER['REQUEST_URI'], $variables)
        && $route["http_method"] === $_SERVER['REQUEST_METHOD']
      ) {

        if (session_status() === PHP_SESSION_NONE) {
          session_start();
        }

        if (isset($route["middlewares"])) {
          foreach ($route["middlewares"] as $middleware) {
            call_user_func($middleware);
          }
        }

        array_shift($variables);

        call_user_func_array($route["method"], $variables);

        return;
      }
    }

    http_response_code(404);
    View::notFound();
  }
}