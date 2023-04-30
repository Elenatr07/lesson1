<?php
use Faker\Factory;
use Geekbrains\LevelTwo\Blog\Comment;
use Geekbrains\LevelTwo\Blog\Exceptions\UserNotFoundException;
use Geekbrains\LevelTwo\Blog\Post;
use Geekbrains\LevelTwo\Blog\Repositories\InMemoryUsersRepository;
use Geekbrains\LevelTwo\Blog\User;
use Geekbrains\LevelTwo\Person\Name;


/*require_once "User.php";
require_once "Name.php";
require_once "Person.php";*/ /* ручная загрузка классов*/

/* автоматическая загрузка классов*/
//spl_autoload_register('load');
include __DIR__ ."/vendor/autoload.php";
function load($className) 
{
    $file = $className . ".php";
    $file = str_replace("\\", "/", $file);
    $file = str_replace("Geekbrains/LevelTwo/", "src/", $file);
    if (file_exists($file)) {
        include $file;
    }
}
$faker = Factory::create('ru_RU'); /* ru_Ru для генерации на русском*/

$name = new Name(
    $faker->firstName('female'),
    $faker->lastName('female')

);
$user = new User (
    $faker->randomDigitNotNull(),
    $name,
    $faker->email(),
);


$route = $argv[1] ?? null;

switch ($route) {
    case "user": echo $user;
    break;
    case "post": 
        $post = new Post (
            $faker->randomDigitNotNull(),
            $user,
            $faker->text(100)
        );
        echo $post;
        break;
    case "comment":
        $post = new Post (
            $faker->randomDigitNotNull(),
            $user,
            $faker->text(100)
        );
      
        $comment = new Comment (
        $faker->randomDigitNotNull(),
        $user,
        $post,
        $faker->text(100)
    );
    echo $comment;
        break;
    default: echo "Error comment";
}



