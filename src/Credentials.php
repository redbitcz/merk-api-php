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
        $this->url = $this->getAbsoluteUrl($url);
    }

    /**
     * Make absolute Endpoint URL, with back compatibility
     *
     * @param string $url
     * @return string
     */
    private function getAbsoluteUrl(string $url): string
    {
        if (preg_match('~^https?://~', $url) === 1) {
            return $url;
        }

        trigger_error('Use absolute URL with https://', E_USER_DEPRECATED);
        return 'https://' . $url;
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
