<?php

use app\Repository\TaskRepository;
use app\Service\TaskService;

require_once __DIR__ . '/vendor/autoload.php';

$taskRepository = new TaskRepository();
$taskService = new TaskService($taskRepository);
