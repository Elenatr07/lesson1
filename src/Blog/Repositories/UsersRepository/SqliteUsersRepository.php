<?php
namespace Geekbrains\LevelTwo\Blog\Repositories\UsersRepository;

use \PDO;
use Geekbrains\LevelTwo\Blog\User;

class SqliteUsersRepository {
    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function save (User $user): void 
    {
        $statement = $this->connection-> prepare(
            'INSERT INTO users (first_name, last_name) VALUES (:first_name, :last_name)'
        );
        $statement->execute([
            ':first_name' => $user->name()->getfirstName(),
            ':last_name' => $user -> name()->getlastName(),
        ]);
    }
}