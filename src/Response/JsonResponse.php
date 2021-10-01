<?php

declare(strict_types=1);

namespace Redbitcz\MerkApi\Response;

class JsonResponse implements IResponse
{
    /** @var array<int|string, mixed> */
    private array $content;
    /** @var array<string, array<int, string>> */
    private array $headers;
    private int $statusCode;

    /**
     * @param array<int|string, mixed> $content
     * @param array<string, array<int, string>> $headers
     */
    public function __construct(array $content, array $headers, int $statusCode)
    {
        $this->content = $content;
        $this->headers = $headers;
        $this->statusCode = $statusCode;
    }

    /** @return array<int|string, mixed> */
    public function getContent(): array
    {
        return $this->content;
    }

    /** @return array<string, array<int, string>> */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

}
