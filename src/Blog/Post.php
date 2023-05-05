<?php
namespace Geekbrains\LevelTwo\Blog;

use Geekbrains\LevelTwo\Blog\User;
use Geekbrains\LevelTwo\Blog\UUID;



class Post {
    private UUID $uuid;
    private User $user;
    private string $title;
    private string $text;
    public function __construct(UUID $uuid, User $user, string $title, string $text) {
        $this->uuid = $uuid;
        $this->user = $user;
        $this->title = $title;
        $this->text = $text;
    }

    public function __toString() {
        return $this->user . 'writes: ' . $this->text .PHP_EOL;
    }

    public function getUuid(): UUID
    {
        return $this->uuid;
    }
    public function setUuid(UUID $uuid): void
    {
    $this->uuid = $uuid;
    }
    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): void
    {
        $this->user =$user;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): Post
    {
        $this->text = $text;
        return $this;
    }

    public function getTitle(): string
    {
        return $this -> title;
    }

    public function setTitle(string $title): void 
    {
        $this-> title = $title;
    }
}