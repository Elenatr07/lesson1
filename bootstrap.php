<?php


use Dotenv\Dotenv;
use Monolog\Logger;
use Psr\Log\LoggerInterface;
use Monolog\Handler\StreamHandler;
use Geekbrains\LevelTwo\Blog\Container\DIContainer;
use Geekbrains\LevelTwo\Http\Auth\IdentificationInterface;
use Geekbrains\LevelTwo\Http\Auth\JsonBodyUsernameIdentification;
use Geekbrains\LevelTwo\Blog\Repositories\PostRepository\SqlitePostsRepository;
use Geekbrains\LevelTwo\Blog\Repositories\LikesRepository\SqliteLikesRepository;
use Geekbrains\LevelTwo\Blog\Repositories\UsersRepository\SqliteUsersRepository;
use Geekbrains\LevelTwo\Blog\Repositories\PostRepository\PostRepositoryInterface;
use Geekbrains\LevelTwo\Blog\Repositories\LikesRepository\LikesRepositoryInterface;
use Geekbrains\LevelTwo\Blog\Repositories\UsersRepository\UsersRepositoryInterface;



require_once __DIR__ . '/vendor/autoload.php';
Dotenv::createImmutable(__DIR__)->safeLoad();
$container = new DIContainer();

$container->bind(
    PDO::class,
    new PDO('sqlite:' . __DIR__ . '/' . $_ENV['SQLITE_DB_PATH'])
);

$logger = (new Logger('blog'));

if ('yes' === $_ENV['LOG_TO_FILES']) {
    $logger->pushHandler(new StreamHandler(
        __DIR__ . '/logs/blog.log'
    ))
        ->pushHandler(new StreamHandler(
            __DIR__ . '/logs/blog.error.log',
            level: Logger::ERROR,
            bubble: false,
        ));
}

if ('yes' === $_ENV['LOG_TO_CONSOLE']) {
    $logger->pushHandler(
        new StreamHandler("php://stdout")
    );
}

$container->bind(
    IdentificationInterface::class,
    JsonBodyUsernameIdentification::class
);
$container->bind(
    LoggerInterface::class,
    $logger

);

$container->bind(
    LikesRepositoryInterface::class,
    SqliteLikesRepository::class
);

$container->bind(
    PostRepositoryInterface::class,
    SqlitePostsRepository::class
);

$container->bind(
    UsersRepositoryInterface::class,
    SqliteUsersRepository::class
);

return $container;