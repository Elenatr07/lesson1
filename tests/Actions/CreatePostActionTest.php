<?php

namespace Geekbrains\LevelTwo\tests\Actions;



use PHPUnit\Framework\TestCase;
use Geekbrains\LevelTwo\Blog\Post;
use Geekbrains\LevelTwo\Blog\User;
use Geekbrains\LevelTwo\Blog\UUID;
use Geekbrains\LevelTwo\Person\Name;

use Geekbrains\LevelTwo\Http\Request;
use Geekbrains\Blog\UnitTests\DummyLogger;
use Geekbrains\LevelTwo\Http\ErrorResponse;
use Geekbrains\LevelTwo\Http\SuccessfulResponse;
use Geekbrains\LevelTwo\Blog\Exceptions\AuthException;
use Geekbrains\LevelTwo\Blog\Exceptions\JsonException;
use Geekbrains\LevelTwo\Http\Actions\Posts\CreatePost;

use Geekbrains\LevelTwo\Http\Auth\JsonBodyUuidIdentification;

use Geekbrains\LevelTwo\Blog\Exceptions\PostNotFoundException;
use Geekbrains\LevelTwo\Blog\Exceptions\UserNotFoundException;
use Geekbrains\LevelTwo\Http\Auth\JsonBodyUsernameIdentification;
use Geekbrains\LevelTwo\Blog\Repositories\PostRepository\PostRepositoryInterface;
use Geekbrains\LevelTwo\Blog\Repositories\UsersRepository\UsersRepositoryInterface;


class CreatePostActionTest extends TestCase
{
    private function postsRepository(): PostRepositoryInterface
    {
        return new class() implements PostRepositoryInterface {
            private bool $called = false;

            public function __construct()
            {
            }

            public function save(Post $post): void
            {
                $this->called = true;
            }

            public function get(UUID $uuid): Post
            {
                throw new PostNotFoundException('Not found');
            }

            public function getByTitle(string $title): Post
            {
                throw new PostNotFoundException('Not found');
            }

            public function getCalled(): bool
            {
                return $this->called;
            }

            public function delete(UUID $uuid): void
            {
            }
        };
    }
    private function usersRepository(array $users): UsersRepositoryInterface
    {
        return new class($users) implements UsersRepositoryInterface
        {
            public function __construct(
                private array $users
            )
            {
            }

            public function save(User $user): void
            {
            }

            public function get(UUID $uuid): User
            {
                foreach ($this->users as $user) {
                    if ($user instanceof User && (string)$uuid == $user->uuid()) {
                        return $user;
                    }
                }
                throw new UserNotFoundException('Cannot find user: ' . $uuid);
            }

            public function getByUsername(string $username): User
            {
                throw new UserNotFoundException('Not found');
            }
        };
    }

    public function testItReturnsSuccessAnswer(): void
    {
        $postsRepositoryStub = $this->createStub(PostRepositoryInterface::class);
        $authenticationStub = $this->createStub(JsonBodyUsernameIdentification::class);

        $authenticationStub
            ->method('user')
            ->willReturn(
                new User(
                    new UUID("10373537-0805-4d7a-830e-22b481b4859c"),
                    new Name('first', 'last'),
                    'username',
                )
            );

        $createPost = new CreatePost(
            $postsRepositoryStub,
            new DummyLogger(),
            $authenticationStub
        );

        $request = new Request(
            [],
            [],
            '{
                "title": "lorem",
                "text": "lorem"
                }'
        );

        $actual = $createPost->handle($request);

        $this->assertInstanceOf(
            SuccessfulResponse::class,
            $actual
        );
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testItReturnsSuccessfulResponse(): void
    {
        $request = new Request([], [], '{"author_uuid":"10373537-0805-4d7a-830e-22b481b4859c","title":"title","text":"text"}');
        $authenticationStub = $this->createStub(JsonBodyUuidIdentification::class);
        $authenticationStub
            ->method('user')
            ->willReturn(
                new User(
                    new UUID("10373537-0805-4d7a-830e-22b481b4859c"),
                    new Name('first', 'last'),
                    'username',
                )
            );

        $postsRepository = $this->postsRepository();

        $action = new CreatePost ( $postsRepository, new DummyLogger(), $authenticationStub );

        $response = $action->handle($request);

        $this->assertInstanceOf(SuccessfulResponse::class, $response);

        $this->setOutputCallback(function ($data){
            $dataDecode = json_decode(
                $data,
                associative: true,
                flags: JSON_THROW_ON_ERROR
            );

            $dataDecode['data']['uuid'] = "351739ab-fc33-49ae-a62d-b606b7038c87";
            return json_encode(
                $dataDecode,
                JSON_THROW_ON_ERROR
            );
        });

        $this->expectOutputString('{"success":true,"data":{"uuid":"351739ab-fc33-49ae-a62d-b606b7038c87"}}');


        $response->send();
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testItReturnsErrorResponseIfNotFoundUser(): void
    {
        $request = new Request([], [], '{"author_uuid":"10373537-0805-4d7a-830e-22b481b4859c","title":"title","text":"text"}');

        $postsRepositoryStub = $this->createStub(PostRepositoryInterface::class);
        $authenticationStub = $this->createStub(JsonBodyUuidIdentification::class);

        $authenticationStub
            ->method('user')
            ->willThrowException(
                new AuthException('Cannot find user: 10373537-0805-4d7a-830e-22b481b4859c')
            );

        $action = new CreatePost($postsRepositoryStub, new DummyLogger(), $authenticationStub);

        $response = $action->handle($request);
        $response->send();
        $this->assertInstanceOf(ErrorResponse::class, $response);
        $this->expectOutputString('{"success":false,"reason":"Cannot find user: 10373537-0805-4d7a-830e-22b481b4859c"}');

        
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     * @throws JsonException
     */
    public function testItReturnsErrorResponseIfNoTextProvided(): void
    {
        $request = new Request([], [], '{"author_uuid":"10373537-0805-4d7a-830e-22b481b4859c","title":"title"}');

        $postsRepository = $this->postsRepository([]);
        $authenticationStub = $this->createStub(JsonBodyUuidIdentification::class);
        $authenticationStub
            ->method('user')
            ->willReturn(
                new User(
                    new UUID("10373537-0805-4d7a-830e-22b481b4859c"),
                    new Name('first', 'last'),
                    'username',
                )
            );

        $action = new CreatePost($postsRepository,  new DummyLogger(), $authenticationStub );

        $response = $action->handle($request);

        $this->assertInstanceOf(ErrorResponse::class, $response);
        $this->expectOutputString('{"success":false,"reason":"No such field: text"}');

        $response->send();
    }
}