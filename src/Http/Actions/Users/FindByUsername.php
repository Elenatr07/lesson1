<?php
namespace Geekbrains\LevelTwo\Http\Actions\Users;

use Geekbrains\LevelTwo\Http\Request;
use Geekbrains\LevelTwo\Http\Response;
use Geekbrains\LevelTwo\Http\ErrorResponse;
use Geekbrains\LevelTwo\Http\SuccessfulResponse;
use Geekbrains\LevelTwo\Http\Actions\ActionInterface;
use Geekbrains\LevelTwo\Blog\Exceptions\HttpException;
use Geekbrains\LevelTwo\Blog\Exceptions\UserNotFoundException;
use Geekbrains\LevelTwo\Blog\Repositories\UsersRepository\UsersRepositoryInterface;

class FindByUsername implements ActionInterface
{
    public function __construct(
    private UsersRepositoryInterface $usersRepository
    ) {
    }
    public function handle(Request $request): Response
    {
        try {
        $username = $request->query('username');
    } catch (HttpException $e) {
        return new ErrorResponse($e->getMessage());
    }
    try {

        $user = $this->usersRepository->getByUsername($username);
    } catch (UserNotFoundException $e) {

return new ErrorResponse($e->getMessage());
    }

        return new SuccessfulResponse([
            'username' => $user->username(),
            'name' => $user->name()->getFirstName() . ' ' . $user->name()->getLastName(),
        ]);
    }
}