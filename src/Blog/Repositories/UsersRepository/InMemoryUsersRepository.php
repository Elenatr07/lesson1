<?php

namespace Geekbrains\LevelTwo\Blog\Repositories\UsersRepository;



use Geekbrains\LevelTwo\Blog\User;
use Geekbrains\LevelTwo\Blog\UUID;
use Geekbrains\LevelTwo\Blog\Exceptions\UserNotFoundException;

use Geekbrains\LevelTwo\Blog\Repositories\UsersRepository\UsersRepositoryInterface;


class InMemoryUsersRepository implements UsersRepositoryInterface
{

    private array $users = [];


    public function save(User $user): void
    {
        $this->users[] = $user;
    }

   
    public function get(UUID $id): User
    {
        foreach ($this->users as $user) {
            if ($user->id() === $id) {
                return $user;
            }
        }
        throw new UserNotFoundException ("User not found: $id");
    }
    public function getByUsername(string $username): User
    {
       
    }
}