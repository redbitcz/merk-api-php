<?php

declare(strict_types=1);

namespace Redbitcz\MerkApi;

use JsonException;
use Redbitcz\MerkApi\Exception\InvalidResponseAccessException;
use Redbitcz\MerkApi\Exception\InvalidResponseException;

class Response
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
     * @return array<int|string, mixed>
     */
    public function getJson(): array
    {
        if($this->isEmpty()) {
            return [];
        }

        if ($this->isJson() === false) {
            $type = $this->getHeaderValue('content-type') ?? 'undefined';
            throw new InvalidResponseAccessException(
                "Unable to access JSON from non-JSON response, requires 'application/json' type, got '{$type}' type",
                $this
            );
        }

        try {
            return json_decode($this->getContent(), true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            throw new InvalidResponseException($e->getMessage(), $e->getCode(), $this, $e);
        }
    }

    public function isJson(): bool
    {
        [$contentType] = explode(';', $this->getHeaderValue('content-type') ?? '');
        return strcasecmp(trim($contentType), 'application/json') === 0;
    }

    public function isEmpty(): bool
    {
        return $this->statusCode === 204;
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
        return $this->headers[mb_strtolower($name)][0] ?? null;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
}
