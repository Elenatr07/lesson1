<?php

use Geekbrains\LevelTwo\Blog\User;
use Geekbrains\LevelTwo\Blog\UUID;
use Geekbrains\LevelTwo\Person\Name;
use Geekbrains\LevelTwo\Blog\Repositories\UsersRepository\SqliteUsersRepository;
include __DIR__ . "/vendor/autoload.php";

$connection = new PDO ('sqlite:' . __DIR__ . '/blog.sqlite');
$usersRepository = new SqliteUsersRepository($connection);

$usersRepository->save(new User(UUID::random(), new Name('Ivan', 'Ivanov'), "admin"));
$usersRepository->save(new User (UUID::random(), new Name('Anna', 'Petrova'), "user"));


