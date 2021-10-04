<?php

declare(strict_types=1);

namespace Redbitcz\MerkApi;

use Redbitcz\MerkApi\Response\JsonResponse;

class Merk
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function getCompanyByRegNo(string $ic): JsonResponse
    {
        return $this->client->requestGet('company/', ['regno' => $ic]);
    }
}
