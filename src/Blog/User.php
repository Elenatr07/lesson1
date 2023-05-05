<?php
namespace Geekbrains\LevelTwo\Blog;


use Geekbrains\LevelTwo\Blog\UUID;
use Geekbrains\LevelTwo\Person\Name;

class User {
    private UUID $uuid;
    private Name $name;
    private string $username;
    public function __construct(UUID $uuid, Name $name, string $username) {
        $this -> uuid = $uuid;
        $this -> name = $name;
        $this -> username = $username;
    }
    public function __toString(): string {
        return "User $this->uuid with name $this->name and username $this->username.". PHP_EOL;
    }
    public function uuid(): UUID
    {
        return $this->uuid;
    }

      
    public function name(): Name
    {
        return $this->name;
    }

  
    public function setUsername(Name $name): void
    {
        $this->name = $name;
    }

   
    public function username(): string
    {
        return $this->username;
    }

    
   
}