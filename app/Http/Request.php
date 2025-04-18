<?php

namespace app\Http;

class Request
{
    public function __construct(
        public readonly string $method,
        public readonly string $uri,
        public readonly array $query = [],
        public readonly array $body = []
    ) {}

    public static function capture(): self
    {
        return new self(
            method: $_SERVER['REQUEST_METHOD'],
            uri: parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH),
            query: $_GET,
            body: json_decode(file_get_contents('php://input'), true) ?? []
        );
    }

    public function input(string $key, mixed $default = null): mixed
    {
        return $this->body[$key] ?? $default;
    }

    public function query(string $key, mixed $default = null): mixed
    {
        return $this->query[$key] ?? $default;
    }

    public function all(): array
    {
        return array_merge($this->query, $this->body);
    }
}
