<?php
namespace Geekbrains\LevelTwo\Blog\Repositories\PostRepository;


use \PDO;
use Geekbrains\LevelTwo\Blog\Post;
use Geekbrains\LevelTwo\Blog\UUID;
use Geekbrains\LevelTwo\Blog\Exceptions\PostNotFoundException;
use Geekbrains\LevelTwo\Blog\Repositories\UsersRepository\SqliteUsersRepository;

class SqlitePostsRepository implements PostRepositoryInterface

{
    private PDO $connection;
    public function __construct(PDO $connection) {
        $this ->connection = $connection;
    }

    public function save (Post $post): void 
    {$statement = $this ->connection -> prepare (
        'INSERT INTO posts (uuid, author_uuid, title, text)
        VALUES (:uuid, :author_uuid, :title, :text)'
    );

    $statement -> execute([
        ':uuid' => $post-> getUuid(),
        ':author_uuid' => $post ->getUser()->uuid(),
        ':title' => $post -> getTitle(),
        ':text' => $post -> getText(),
    ]);
    }

    public function get(UUID $uuid): Post
    {
        $statement = $this->connection->prepare(
            'SELECT * FROM posts WHERE uuid = :uuid'
        );
        $statement->execute([
            ':uuid' => (string)$uuid,
        ]);

        return $this->getPost($statement, $uuid);
    }
    private function getPost(\PDOStatement $statement, string $postUuId): Post
    {
        $result = $statement->fetch(\PDO::FETCH_ASSOC);
       // print_r($result);
       //die();

        if ($result === false) {
            throw new PostNotFoundException(
                "Cannot find post: $postUuId"
            );
        }

        $userRepository = new SqliteUsersRepository($this->connection);
        $user = $userRepository->get(new UUID($result['author_uuid']));

        return new Post(
            new UUID($result['uuid']),
            $user,
            $result['title'],
            $result['text']
        );

    }
}