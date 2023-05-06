<?php
namespace Geekbrains\LevelTwo\Blog\Repositories\CommentsRepository;


use \PDO;
use Geekbrains\LevelTwo\Blog\Post;
use Geekbrains\LevelTwo\Blog\UUID;
use Geekbrains\LevelTwo\Blog\Comment;
use Geekbrains\LevelTwo\Blog\Exceptions\PostNotFoundException;
use Geekbrains\LevelTwo\Blog\Exceptions\CommentNotFoundException;
use Geekbrains\LevelTwo\Blog\Repositories\UsersRepository\SqliteUsersRepository;

class SqliteCommentsRepository implements CommentsRepositoryInterface

{
    private PDO $connection;
    public function __construct(PDO $connection) {
        $this ->connection = $connection;
    }

    public function save (Comment $comment): void 
    {$statement = $this ->connection -> prepare (
        'INSERT INTO comments (uuid, post_uuid, author_uuid, text)
        VALUES (:uuid, :post_uuid, :author_uuid, :text)'
    );

    $statement -> execute([
        ':uuid' => $comment-> getUuid(),
        ':post_uuid' => $comment ->getUuid(),
        ':author_uuid' => $comment -> getUser(),
        ':text' => $comment -> getText(),
    ]);
    }

    public function get(UUID $uuid): Comment
    {
        $statement = $this->connection->prepare(
            'SELECT * FROM comments WHERE uuid = :uuid'
        );
        $statement->execute([
            ':uuid' => (string)$uuid,
        ]);

        return $this->getComment($statement, $uuid);
    }
    private function getComment(\PDOStatement $statement, string $commentUuId): Comment
    {
        $result = $statement->fetch(\PDO::FETCH_ASSOC);
       // print_r($result);
       //die();

        if ($result === false) {
            throw new CommentNotFoundException(
                "Cannot find comment: $commentUuId"
            );
        }

       // $userRepository = new SqliteUsersRepository($this->connection);
       // $user = $userRepository->get(new UUID($result['author_uuid']));

        return new Comment(
            new UUID($result['uuid']),
            $result['post_uuid'],
            $result['author_uuid'],
            $result['text']
        );

    }
}