<?php
namespace Geekbrains\LevelTwo\Blog\Commands;

use Psr\Log\LoggerInterface;
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
        private UsersRepositoryInterface $usersRepository,
        private LoggerInterface $logger,) {
        }
    public function handle(Arguments $arguments): void
    {
        $this->logger->info("Create user command started");
        $username = $arguments-> get('username');
       
       
        if ($this->userExists($username)) {
            $this->logger->warning("User already exists: $username");
        throw new CommandException("User already exists: $username");
        }
        
        $uuid = UUID::random();
        $this->usersRepository->save(new User(
            $uuid,
            new Name(
                $arguments->get('first_name'),
                $arguments->get('last_name')),
            $username,
        ));
        $this->logger->info("User created: $uuid");
    }
        
    private function userExists(string $username): bool
    {
        try {
        
        $this->usersRepository->getByUsername($username);
        } catch (UserNotFoundException) {
        return false;
        }
        return true;
    }
}
