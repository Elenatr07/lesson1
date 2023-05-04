<?php
namespace Geekbrains\LevelTwo\Blog;


use Geekbrains\LevelTwo\Blog\UUID;
use Geekbrains\LevelTwo\Person\Name;

class User {
    private UUID $uuid;
    private Name $username;
    private string $login;
    public function __construct(UUID $uuid, Name $username, string $login) {
        $this -> uuid = $uuid;
        $this -> username = $username;
        $this -> login = $login;
    }
    public function __toString(): string {
        return "User $this->uuid with name $this->username and login $this->login.". PHP_EOL;
    }
    public function uuid(): UUID
    {
        return $this->uuid;
    }

      
    public function name(): Name
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