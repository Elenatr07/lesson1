<?php

use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Application;

use GeekBrains\LevelTwo\Blog\Commands\Posts\DeletePost;
use GeekBrains\LevelTwo\Blog\Commands\Users\CreateUser;
use GeekBrains\LevelTwo\Blog\Commands\Users\UpdateUser;
use GeekBrains\LevelTwo\Blog\Commands\FakeData\PopulateDB;


$container = require __DIR__ . '/bootstrap.php';

$logger = $container->get(LoggerInterface::class);

$application = new Application();

$commandsClasses = [
    CreateUser::class,
    DeletePost::class,
   
];

foreach ($commandsClasses as $commandClass) {
    $command = $container->get($commandClass);
    $application->add($command);
}

try {

    $application->run();

} catch (Exception $e) {
    $logger->error($e->getMessage(), ['exception' => $e]);
    echo $e->getMessage();
}
