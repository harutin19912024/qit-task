<?php

namespace app\Router;

class Route
{
    private array $routes = [];

    public function add(string $method, string $path, callable $handler): void
    {
        $this->routes[] = compact('method', 'path', 'handler');
    }

    /**
     * @return void
     */
    public function dispatch(): void
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'];

        foreach ($this->routes as $route) {
            $pattern = preg_replace('#\{[\w]+\}#', '([\w\-]+)', $route['path']);
            $pattern = "#^" . $pattern . "$#";

            if ($method === $route['method'] && preg_match($pattern, $uri, $matches)) {
                array_shift($matches);
                call_user_func_array($route['handler'], $matches);
                return;
            }
        }

        http_response_code(404);
        echo json_encode(['error' => 'Route not found']);
    }
}
