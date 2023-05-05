<?php
namespace Geekbrains\LevelTwo\Blog\Repositories\UsersRepository;

use \PDO;
use PDOStatement;
use Geekbrains\LevelTwo\Blog\User;
use Geekbrains\LevelTwo\Blog\UUID;
use Geekbrains\LevelTwo\Person\Name;
use Geekbrains\LevelTwo\Blog\Exceptions\UserNotFoundException;
use Geekbrains\LevelTwo\Blog\Repositories\UsersRepository\UsersRepositoryInterface;


class SqliteUsersRepository implements UsersRepositoryInterface
 {
    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function save (User $user): void 
    {
        $statement = $this->connection-> prepare(
            'INSERT INTO users (first_name, last_name, uuid, username) VALUES (:first_name, :last_name, :uuid, :username)'
        );
        $statement->execute([
            ':first_name' => $user->name()->getfirstName(),
            ':last_name' => $user -> name()->getlastName(),
            ':uuid' => (string)$user->uuid(),
            ':username' => $user->username(),
        ]);
    }
    public function get(UUID $uuid): User
    {
        $statement = $this -> connection -> prepare(
            'SELECT * FROM users WHERE uuid =?'
        );
        $statement -> execute([(string)$uuid]);
        $result = $statement -> fetch(PDO::FETCH_ASSOC);
        if ($result === false) {
            throw new UserNotFoundException ("Cannot get user: $uuid");
        }
        return $this ->getUser($statement, $uuid);
        
    }

    public function getByUsername(string $username ): User
    {
        $statement = $this ->connection -> prepare(
            'SELECT * FROM users WHERE username = :username');
            $statement -> execute([':username' => $username]);
            return $this -> getUser ($statement, $username);
    }
    public function getUser (PDOStatement $statement, string $username): User
    {
        $result = $statement -> fetch(\PDO::FETCH_ASSOC);
        if ($result === false) {
            throw new UserNotFoundException ("Cannot find user: $username");
        }
        return new User( 
            new UUID ($result ['uuid']),
            new Name ($result['first_name'], 
            $result ['last_name'],),
            $result ['username'],
        );
    }
}