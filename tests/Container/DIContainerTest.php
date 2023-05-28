<?php

namespace Geekbrains\Blog\UnitTests\Container;

use PHPUnit\Framework\TestCase;
use Geekbrains\LevelTwo\Blog\Container\DIContainer;
use Geekbrains\LevelTwo\Blog\Exceptions\NotFoundException;
use Geekbrains\Blog\UnitTests\Container\SomeClassWithParameter;
use Geekbrains\Blog\UnitTests\Container\ClassDependingOnAnother;
use Geekbrains\LevelTwo\Blog\Repositories\UsersRepository\InMemoryUsersRepository;
use Geekbrains\LevelTwo\Blog\Repositories\UsersRepository\UsersRepositoryInterface;





class DIContainerTest extends TestCase
{

    public function testItResolvesClassWithDependencies(): void
    {

        $container = new DIContainer();
        $container->bind(
            SomeClassWithParameter::class,
            new SomeClassWithParameter(42)
        );

        $object = $container->get(ClassDependingOnAnother::class);
        $this->assertInstanceOf(
            ClassDependingOnAnother::class,
            $object
        );
    }

    public function testItReturnsPredefinedObject(): void
    {

        $container = new DIContainer();
        $container->bind(
            SomeClassWithParameter::class,
            new SomeClassWithParameter(42)
        );

        $object = $container->get(SomeClassWithParameter::class);
        $this->assertInstanceOf(
            SomeClassWithParameter::class,
            $object
        );

        $this->assertSame(42, $object->value());
    }

    public function testItResolvesClassByContract(): void
    {
        $container = new DIContainer();
        $container->bind(
            UsersRepositoryInterface::class,
            InMemoryUsersRepository::class
        );

       $object = $container->get(UsersRepositoryInterface::class);
        $this->assertInstanceOf(
            InMemoryUsersRepository::class,
            $object
        );
    }

    public function testItResolvesClassWithoutDependencies(): void
    {
        $container = new DIContainer();
        $object = $container->get(SomeClassWithoutDependencies::class);


        $this->assertInstanceOf(
            SomeClassWithoutDependencies::class,
            $object
        );
    }


    public function testItThrowsAnExceptionIfCannotResolveType(): void
    {
        $container = new DIContainer();
        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage(
            'Cannot resolve type: Geekbrains\Blog\UnitTests\Container\SomeClass'
        );
        $container->get(SomeClass::class);

    }
}