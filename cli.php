<?php


use Geekbrains\LevelTwo\Blog\User;
use Geekbrains\LevelTwo\Blog\UUID;
use Geekbrains\LevelTwo\Person\Name;
use Geekbrains\LevelTwo\Blog\Command\Arguments;
use Geekbrains\LevelTwo\Blog\Command\CreateUserCommand;
use Geekbrains\LevelTwo\Blog\Repositories\UsersRepository\SqliteUsersRepository;

include __DIR__ . "/vendor/autoload.php";

$connection = new PDO ('sqlite:' . __DIR__. '/blog.sqlite');
$usersRepository = new SqliteUsersRepository($connection);

//$usersRepository->save(new User(UUID::random(), new Name('Ivan', 'Ivanov'), "admin"));
//$usersRepository->save(new User (UUID::random(), new Name('Anna', 'Petrova'), "user"));

$command = new CreateUserCommand($usersRepository);

/*try {echo $usersRepository-> getByUsername ('admin1');
} catch (Exception $e) {echo $e -> getMessage();
}*/

try {$command -> handle(Arguments::fromArgv($argv));
} catch (Exception $e) { echo $e ->getMessage();
}


