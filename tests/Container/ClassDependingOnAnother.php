<?php

namespace Geekbrains\Blog\UnitTests\Container;

use Geekbrains\Blog\UnitTests\Container\SomeClassWithParameter;
use Geekbrains\Blog\UnitTests\Container\SomeClassWithoutDependencies;

class ClassDependingOnAnother
{
    public function __construct(
        private SomeClassWithoutDependencies $one,
        private SomeClassWithParameter $two,
    )
    {

    }
}