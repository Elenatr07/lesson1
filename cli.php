<?php


use Geekbrains\LevelTwo\Blog\Comment;
use Geekbrains\LevelTwo\Blog\Post;
use Geekbrains\LevelTwo\Blog\Repositories\PostRepository\SqlitePostsRepository;
use Geekbrains\LevelTwo\Blog\User;
use Geekbrains\LevelTwo\Blog\UUID;
use Geekbrains\LevelTwo\Person\Name;
use Geekbrains\LevelTwo\Blog\Command\Arguments;
use Geekbrains\LevelTwo\Blog\Command\CreateUserCommand;
use Geekbrains\LevelTwo\Blog\Repositories\UsersRepository\SqliteUsersRepository;

include __DIR__ . "/vendor/autoload.php";

$connection = new PDO ('sqlite:' . __DIR__. '/blog.sqlite');
$usersRepository = new SqliteUsersRepository($connection);
$postRepository = new SqlitePostsRepository($connection);

try {
    $user = $usersRepository->get(new UUID('c08cbba8-999a-4586-bd33-09d6e8c7f624'));
    $post = $postRepository->get(new UUID('d864a579-bedb-4ed3-af96-dc1c5ebddb77'));
    //print_r($post);
   //var_dump($user);
    /*$post = new Post(
        UUID::random(),
        $user,
        'Title',
        'Post text'
    );
    $postRepository->save($post);*/

   /* $comment = new Comment (
        UUID::random(),
        $post_uuid,
        $authot_uuid,
        'Comment Text'
    );*/
} catch (Exception $e) {
    echo $e ->getMessage();
}

//$usersRepository->save(new User(UUID::random(), new Name('Ivan', 'Ivanov'), "admin"));
//$usersRepository->save(new User (UUID::random(), new Name('Anna', 'Petrova'), "user"));

//$command = new CreateUserCommand($usersRepository);

try {echo $usersRepository-> getByUsername ('admin');
} catch (Exception $e) {echo $e -> getMessage();
}

/*try {$command -> handle(Arguments::fromArgv($argv));
} catch (Exception $e) { echo $e ->getMessage();
}*/





