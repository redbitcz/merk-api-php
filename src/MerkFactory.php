<?php

declare(strict_types=1);

namespace Redbitcz\MerkApi;

class MerkFactory
{
    public function create(string $apiKey, string $url = Credentials::DEFAULT_URL): Merk
    {
        $credentials = new Credentials($apiKey, $url);
        $client = new Client($credentials);
        return new Merk($client);
    }
}
