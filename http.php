<?php

use Psr\Log\LoggerInterface;
use Geekbrains\LevelTwo\Http\Request;
use Geekbrains\LevelTwo\Http\ErrorResponse;

use Geekbrains\LevelTwo\Blog\Exceptions\AppException;
use Geekbrains\LevelTwo\Blog\Exceptions\HttpException;
use Geekbrains\LevelTwo\Http\Actions\Posts\CreatePost;
use Geekbrains\LevelTwo\Http\Actions\Posts\DeletePost;
use Geekbrains\LevelTwo\Http\Actions\Users\CreateUser;
use Geekbrains\LevelTwo\Http\Actions\Likes\CreatePostLike;
use Geekbrains\LevelTwo\Http\Actions\Users\FindByUsername;



$container = require __DIR__ . '/bootstrap.php';
$logger = $container->get(LoggerInterface::class);

$request = new Request(
    $_GET,
    $_SERVER,
    file_get_contents('php://input'),
);

try {
    $path = $request->path();
} catch (HttpException $e) {
    $logger->warning($e->getMessage());
    (new ErrorResponse)->send();
    return;
}

try {
    $method = $request->method();
} catch (HttpException $e) {
    (new ErrorResponse)->send();
    return;
}


$routes = [
    'GET' => [
        '/users/show' => FindByUsername::class,
    ],
    'POST' => [
        '/users/create' => CreateUser::class,
        '/posts/create' => CreatePost::class,
        '/post-likes/create' => CreatePostLike::class,
    ],
    'DELETE' => [
        '/posts' => DeletePost::class,
    ],

];

if (!array_key_exists($method, $routes) || !array_key_exists($path, $routes[$method])) {
        $message = "Route not found: $method $path";
        $logger->notice($message);
        (new ErrorResponse($message))->send();
        return;
    }

$actionClassName = $routes[$method][$path];

$action = $container->get($actionClassName);

try {
    $response = $action->handle($request);
} catch (AppException $e) {
    $logger->error($e->getMessage(), ['exception' => $e]);
    (new ErrorResponse($e->getMessage()))->send();
    return;
}
$response->send();

