<?php 
namespace Geekbrains\LevelTwo\Blog\Repositories\CommentsRepository;
use Geekbrains\LevelTwo\Blog\Comment;

use Geekbrains\LevelTwo\Blog\UUID;

interface CommentsRepositoryInterface
{
    public function save (Comment $comment): Comment;
    public function get (UUID $uuid): Comment;
}