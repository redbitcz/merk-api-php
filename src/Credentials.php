<?php

declare(strict_types=1);

namespace Redbitcz\MerkApi;

class Credentials
{
    public const DEFAULT_URL = 'https://api.merk.cz';

    private string $apiKey;
    private string $url;

    public function __construct(string $apiKey, string $url = self::DEFAULT_URL)
    {
        $this->apiKey = $apiKey;
        $this->url = $url;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getApiKey(): string
    {
        return $this->apiKey;
    }
}
