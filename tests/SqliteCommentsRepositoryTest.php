<?php

namespace GeekBrains\LevelTwo\tests;

use PDO;
use PDOStatement;
use PHPUnit\Framework\TestCase;
use Geekbrains\LevelTwo\Blog\Post;
use Geekbrains\LevelTwo\Blog\User;
use Geekbrains\LevelTwo\Blog\UUID;
use Geekbrains\LevelTwo\Person\Name;
use Geekbrains\LevelTwo\Blog\Comment;
use Geekbrains\LevelTwo\Blog\Exceptions\CommentNotFoundException;
use Geekbrains\LevelTwo\Blog\Repositories\CommentsRepository\SqliteCommentsRepository;



/*class SqliteCommentsRepositoryTest extends TestCase
{
    public function testItThrowsAnExceptionWhenCommentNotFound(): void
    {
        $connectionMock = $this->createStub(PDO::class);
        $statementStub = $this->createStub(PDOStatement::class);

        $statementStub->method('fetch')->willReturn(false);
        $connectionMock->method('prepare')->willReturn($statementStub);

        $repository = new SqliteCommentsRepository($connectionMock);

        $this->expectExceptionMessage('Cannot find post: 5b2a184e-789b-4b78-8f34-eb44cdc02d06');
        $this->expectException(CommentNotFoundException::class);
        $repository->get(new UUID('5b2a184e-789b-4b78-8f34-eb44cdc02d06'));
    }

    public function testItSavesCommentToDatabase(): void
    {
        $connectionStub = $this->createStub(PDO::class);
        $statementMock = $this->createMock(PDOStatement::class);

        $statementMock
            ->expects($this->once()) 
            ->method('execute') 
            ->with([ 
                ':uuid' => '123e4567-e89b-12d3-a456-426614174000',
                ':post_uuid' => '123e4567-e89b-12d3-a456-426614174000',
                ':author_uuid' => '1234567',
                ':text' => 'some text',
            ]);

        $connectionStub->method('prepare')->willReturn($statementMock);
        $repository = new SqliteCommentsRepository($connectionStub);


        $user = new User(
            new UUID('123e4567-e89b-12d3-a456-426614174000'),
            new Name('first_name', 'last_name'),
            'name'
        );

     

        $repository->save(
            new Comment(
                new UUID('123e4567-e89b-12d3-a456-426614174000'),
                'post_uuid'('7a832e50-78e0-4002-b0bf-f2545296c024'),
                $user,
                'Nikitin'
            )
        );
    }

    public function testItGetCommentByUuid(): void
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

        $postRepository = new SqliteCommentsRepository($connectionStub);
        $comment = $postRepository->get(new UUID('7a832e50-78e0-4002-b0bf-f2545296c024'));

        $this->assertSame('7a832e50-78e0-4002-b0bf-f2545296c024', (string)$comment->getPost_uuid());
    }
}*/