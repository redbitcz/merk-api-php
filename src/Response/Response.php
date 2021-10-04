<?php

declare(strict_types=1);

namespace Redbitcz\MerkApi\Response;

class Response implements IResponse
{
    private string $content;

    /** @var array<string, array<int, string>> */
    private array $headers;
    private int $statusCode;

    /**
     * @param array<string, array<int, string>> $headers
     */
    public function __construct(string $content, array $headers, int $statusCode)
    {
        $this->content = $content;
        $this->headers = $headers;
        $this->statusCode = $statusCode;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @return array<string, array<int, string>>
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function getHeaderValue(string $name): ?string
    {
        return $this->headers[$name][0] ?? null;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
}
