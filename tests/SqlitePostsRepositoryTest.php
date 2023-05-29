<?php

namespace GeekBrains\LevelTwo\tests;

use PDO;
use PDOStatement;
use PHPUnit\Framework\TestCase;
use Geekbrains\LevelTwo\Blog\Post;
use Geekbrains\LevelTwo\Blog\User;
use Geekbrains\LevelTwo\Blog\UUID;
use Geekbrains\LevelTwo\Person\Name;
use Geekbrains\Blog\UnitTests\DummyLogger;
use Geekbrains\LevelTwo\Blog\Exceptions\PostNotFoundException;
use Geekbrains\LevelTwo\Blog\Repositories\PostRepository\SqlitePostsRepository;



class SqlitePostsRepositoryTest extends TestCase
{
    public function testItThrowsAnExceptionWhenPostNotFound(): void
    {
        $connectionMock = $this->createStub(PDO::class);
        $statementStub = $this->createStub(PDOStatement::class);

        $statementStub->method('fetch')->willReturn(false);
        $connectionMock->method('prepare')->willReturn($statementStub);

        $repository = new SqlitePostsRepository($connectionMock, new DummyLogger());

        $this->expectExceptionMessage('Cannot find post: 5b2a184e-789b-4b78-8f34-eb44cdc02d06');
        $this->expectException(PostNotFoundException::class);
        $repository->get(new UUID('5b2a184e-789b-4b78-8f34-eb44cdc02d06'));
    }

    public function testItSavesPostToDatabase(): void
    {
        $connectionStub = $this->createStub(PDO::class);
        $statementMock = $this->createMock(PDOStatement::class);

        $statementMock
            ->expects($this->once()) 
            ->method('execute') 
            ->with([ 
                ':uuid' => '123e4567-e89b-12d3-a456-426614174000',
                ':author_uuid' => '123e4567-e89b-12d3-a456-426614174000',
                ':title' => 'Ivan',
                ':text' => 'Nikitin',
            ]);

        $connectionStub->method('prepare')->willReturn($statementMock);
        $repository = new SqlitePostsRepository($connectionStub, new DummyLogger());


        $user = new User(
            new UUID('123e4567-e89b-12d3-a456-426614174000'),
            new Name('first_name', 'last_name'),
            'name',
        );

        $repository->save(
            new Post(
                new UUID('123e4567-e89b-12d3-a456-426614174000'),
                $user,
                'Ivan',
                'Nikitin'
            )
        );
    }

    public function testItGetPostByUuid(): void
    {
        $connectionStub = $this->createStub(\PDO::class);
        $statementMock = $this->createMock(\PDOStatement::class);

        $statementMock->method('fetch')->willReturn([
            'uuid' => '7a832e50-78e0-4002-b0bf-f2545296c024',
            'author_uuid' => 'c08cbba8-999a-4586-bd33-09d6e8c7f624',
            'title' => 'Some title',
            'text' => 'some text',
            'username' => 'ivan123',
            'first_name' => 'Ivan',
            'last_name' => 'Nikitin',
        ]);

        $connectionStub->method('prepare')->willReturn($statementMock);

        $postRepository = new SqlitePostsRepository($connectionStub, new DummyLogger());
        $post = $postRepository->get(new UUID('7a832e50-78e0-4002-b0bf-f2545296c024'));

        $this->assertSame('7a832e50-78e0-4002-b0bf-f2545296c024', (string)$post->getUuid());
    }
}