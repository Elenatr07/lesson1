<?php
namespace Geekbrains\LevelTwo\Blog\Commands;

use Geekbrains\LevelTwo\Blog\User;
use Geekbrains\LevelTwo\Blog\UUID;
use Geekbrains\LevelTwo\Person\Name;
use Geekbrains\LevelTwo\Blog\Commands\Arguments;
use Geekbrains\LevelTwo\Blog\Exceptions\CommandException;
use Geekbrains\LevelTwo\Blog\Exceptions\UserNotFoundException;
use Geekbrains\LevelTwo\Blog\Repositories\UsersRepository\UsersRepositoryInterface;

// php cli.php username=ivan first_name=Ivan last_name=Nikitin //код для выполнения этой команды


class CreateUserCommand
{
    public function __construct(
        private UsersRepositoryInterface $usersRepository) {
        }
    public function handle(Arguments $arguments): void
    {
        $username = $arguments-> get('username');
       
        // Проверяем, существует ли пользователь в репозитории
        if ($this->userExists($username)) {
        // Бросаем исключение, если пользователь уже существует
        throw new CommandException("User already exists: $username");
        }
        
        // Сохраняем пользователя в репозиторий
        $this->usersRepository->save(new User(
            UUID::random(),
            new Name(
                $arguments->get('first_name'),
                $arguments->get('last_name')),
            $username,
        ));
    }
        
    private function userExists(string $username): bool
    {
        try {
        // Пытаемся получить пользователя из репозитория
        $this->usersRepository->getByUsername($username);
        } catch (UserNotFoundException) {
        return false;
        }
        return true;
    }
}
