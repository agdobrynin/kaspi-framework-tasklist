<?php

namespace Core;

class ResponseHeaders
{
    protected $headers;

    public function __clone()
    {
        $this->headers = clone $this->headers;
    }

    public function set(string $header, string $value): void
    {
        $this->headers[$header] = $value;
    }

    public function get(): array
    {
        return $this->headers;
    }
}
