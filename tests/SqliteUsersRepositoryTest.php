<?php
namespace Geekbrains\LevelTwo\tests;


use PDO;
use PDOStatement;
use PHPUnit\Framework\TestCase;
use Geekbrains\LevelTwo\Blog\User;
use Geekbrains\LevelTwo\Blog\UUID;
use Geekbrains\LevelTwo\Person\Name;
use Geekbrains\LevelTwo\Blog\Exceptions\UserNotFoundException;
use Geekbrains\LevelTwo\Blog\Repositories\UsersRepository\SqliteUsersRepository;

class SqliteUsersRepositoryTest extends TestCase
{
    public function testItThrowsAnExceptionWhenUserNotFound(): void
    {
        $connectionMock = $this->createStub(PDO::class);
        $statementStub = $this->createStub(PDOStatement::class);
        $statementStub->method('fetch')->willReturn(false);
        $connectionMock->method('prepare')->willReturn($statementStub);
// 1. Передаём в репозиторий стаб подключения
        $repository = new SqliteUsersRepository($connectionMock);
// Ожидаем, что будет брошено исключение
        $this->expectException(UserNotFoundException::class);
        $this->expectExceptionMessage('Cannot find user: Ivan');
// Вызываем метод получения пользователя
        $repository->getByUsername('Ivan');
}
    public function testItSavesUserToDatabase(): void
    {
// 2. Создаём стаб подключения
        $connectionStub = $this->createStub(PDO::class);
// 4. Создаём мок запроса, возвращаемый стабом подключения
        $statementMock = $this->createMock(PDOStatement::class);
// 5. Описываем ожидаемое взаимодействие
// нашего репозитория с моком запроса
        $statementMock
            ->expects($this->once()) // Ожидаем, что будет вызван один раз
            ->method('execute') // метод execute
            ->with([ // с единственным аргументом - массивом
                ':uuid' => '123e4567-e89b-12d3-a456-426614174000',
                ':username' => 'ivan123',
                ':first_name' => 'Ivan',
                ':last_name' => 'Nikitin',
        ]);
// 3. При вызове метода prepare стаб подключения возвращает мок запроса
        $connectionStub->method('prepare')->willReturn($statementMock);
// 1. Передаём в репозиторий стаб подключения
        $repository = new SqliteUsersRepository($connectionStub);
// Вызываем метод сохранения пользователя
        $repository->save(
            new User( // Свойства пользователя точно такие, как и в описании мока
            new UUID('123e4567-e89b-12d3-a456-426614174000'),
            new Name('Ivan', 'Nikitin'),
            'ivan123'
            )
        );

    }

}