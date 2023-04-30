<?php
namespace Geekbrains\LevelTwo\Blog;

use Geekbrains\LevelTwo\Person\Name;

class User {
    private int $id;
    private string $username;
    private string $login;
    public function __construct(int $id, string $username, string $login) {
        $this -> id = $id;
        $this -> username = $username;
        $this -> login = $login;
    }
    public function __toString(): string {
        return "User $this->id with name $this->username and login $this->login.". PHP_EOL;
    }
    public function id(): int
    {
        return $this->id;
    }

      public function setId(int $id): void
    {
        $this->id = $id;
    }

   
    public function getUsername(): string
    {
        return $this->username;
    }

  
    public function setUsername(Name $username): void
    {
        $this->username = $username;
    }

   
    public function getLogin(): string
    {
        return $this->login;
    }

    
    public function setLogin(string $login): void
    {
        $this->login = $login;
    }
}