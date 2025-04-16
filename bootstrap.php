<?php

require_once __DIR__ . '/vendor/autoload.php';

use app\Controller\TaskController;
use app\Repository\InMemoryTaskRepository;
use app\Service\TaskService;


$repository = new InMemoryTaskRepository();
$service = new TaskService($repository);
$controller = new TaskController($service);

$controller->create([
    'title' => 'Implement login',
    'description' => 'Add login form and logic',
    'assigneeId' => 'user_1'
]);

$controller->create([
    'title' => 'Fix logout bug',
    'description' => 'Logout throws 500 error',
]);


echo "\n All Tasks:\n";
$controller->list([]);


echo "\n Tasks assigned to user_1:\n";
$controller->list(['assigneeId' => 'user_1']);


$allTasks = $repository->findAll();
$firstTask = array_values($allTasks)[0];

$controller->updateStatus([
    'id' => (string) $firstTask->getId(),
    'status' => 'done'
]);


echo "\n Tasks after status update:\n";
$controller->list([]);
