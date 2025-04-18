<?php

namespace app\Http;

class JsonResponse
{
    /**
     * @param array $data
     * @param int $statusCode
     * @param bool $wrap
     * @return void
     */
    public static function success(array $data = [], int $statusCode = 200, bool $wrap = true): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');

        echo json_encode($wrap ? [
            'success' => true,
            'data' => $data
        ] : $data);
    }

    /**
     * @param array|string $errors
     * @param int $statusCode
     * @return void
     */
    public static function error(array|string $errors, int $statusCode = 400): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode([
            'success' => false,
            'errors' => is_array($errors) ? $errors : ['message' => $errors]
        ]);
    }
}
