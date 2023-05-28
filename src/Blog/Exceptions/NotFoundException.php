<?php

namespace Geekbrains\LevelTwo\Blog\Exceptions;

use Psr\Container\NotFoundExceptionInterface;
use Geekbrains\LevelTwo\Blog\Exceptions\AppException;

class NotFoundException extends AppException implements NotFoundExceptionInterface
{

}