<?php
use Geekbrains\LevelTwo\Http\Request;
use Geekbrains\LevelTwo\Http\SuccessfulResponse;
require_once __DIR__ . '/vendor/autoload.php';

$request = new Request($_GET, $_SERVER);
/*$parameter = $request->query('some_parameter');
$header = $request->header('Some-Header');
$path = $request->path();*/
// Создаём объект ответа
$response = new SuccessfulResponse([
'message' => 'Hello from PHP',
]);
// Отправляем ответ
$response->send();

