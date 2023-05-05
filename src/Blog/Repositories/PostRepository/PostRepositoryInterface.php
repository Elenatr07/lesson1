<?php 
namespace Geekbrains\LevelTwo\Blog\Repositories\PostRepository;
use Geekbrains\LevelTwo\Blog\Post;
use Geekbrains\LevelTwo\Blog\UUID;

interface PostRepositoryInterface
{
    public function save (Post $post): void;
    public function get (UUID $uuid): Post;
}