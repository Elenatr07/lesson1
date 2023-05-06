<?php

namespace Geekbrains\LevelTwo\Blog;

use Geekbrains\LevelTwo\Blog\UUID;

class Comment
{ private UUID $uuid;
    private Post $post_uuid;
    private User $author_uuid;
    
    private string $text;

    public function __construct(UUID $uuid,  Post $post_uuid, User $author_uuid,string $text )
    { $this->uuid = $uuid;
     $this->post_uuid = $post_uuid;
     $this->author_uuid = $author_uuid;
     $this->text = $text;
      
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
        return $this->author_uuid;
    }

    public function setUser(User $author_uuid): void
    {
        $this->author_uuid = $author_uuid;
    }

    public function getPost_uuid(): Post
    {
        return $this->post_uuid;
    }

    public function setPost_uuid(Post $post_uuid): void
    {
        $this->post_uuid = $post_uuid;
    }

  
    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): void
    {
        $this->text = $text;
    }

    public function __toString() {
        return $this->author_uuid . " writes Commemnt: " . $this->text;
    }

}