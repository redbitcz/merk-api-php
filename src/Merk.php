<?php

declare(strict_types=1);

namespace Redbitcz\MerkApi;

use Redbitcz\MerkApi\Response\IResponse;

class Merk
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function getCompanyByIc(string $ic): IResponse
    {
        return $this->client->requestGet('company/', ['regno'=> $ic]);
    }
}
