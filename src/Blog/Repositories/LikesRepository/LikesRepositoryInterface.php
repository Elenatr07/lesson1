<?php

namespace Geekbrains\LevelTwo\Blog\Repositories\LikesRepository;

use Geekbrains\LevelTwo\Blog\Like;
use Geekbrains\LevelTwo\Blog\UUID;



interface LikesRepositoryInterface
{
    public function save(Like $like) : void;
    public function getByPostUuid(UUID $uuid) : array;
}