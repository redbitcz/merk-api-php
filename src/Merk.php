<?php

declare(strict_types=1);

namespace Redbitcz\MerkApi;

use Redbitcz\MerkApi\Exception\NotFoundException;

class Merk
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function getCompanyByRegNo(string $regno): Response
    {
        $response = $this->client->requestGet('company/', ['regno' => $regno]);

        if ($response->isNoContent()) {
            throw new NotFoundException('No company found', 404, $response);
        }

        return $response;
    }

    public function getSuggestByRegNo(string $regno): Response
    {
        $response = $this->client->requestGet('suggest/', ['regno' => $regno]);

        if ($response->isNoContent()) {
            throw new NotFoundException('No company found', 404, $response);
        }

        return $response;
    }
}
