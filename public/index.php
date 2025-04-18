<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../bootstrap.php';

use app\Controller\TaskController;
use app\Router\Route;
use app\Http\Request;

header('Content-Type: application/json');

$request = Request::capture();
$controller = new TaskController($taskService);
$route = new Route();

$route->add('POST', '/task', fn() => $controller->create($request));
$route->add('GET', '/tasks', fn() => $controller->list($request));
$route->add('PATCH', '/task/{id}/status', fn($id) => $controller->updateStatus($id, $request));
$route->add('PATCH', '/task/{id}/assign', fn($id) => $controller->assignTask($id, $request));
$route->add('DELETE', '/task/{id}', fn($id) => $controller->delete($id));

$route->dispatch();
