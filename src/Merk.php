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

    /**
     * @param string $countryCode 'cz' value is default by Merk API
     */
    public function getCompanyByRegNo(string $regno, string $countryCode = 'cz'): Response
    {
        $response = $this->client->requestGet(
            'company/',
            ['regno' => $regno, 'country_code' => $countryCode]
        );

        if ($response->isNoContent()) {
            throw new NotFoundException('No company found', 404, $response);
        }

        return $response;
    }

    /**
     * @param string $countryCode 'cz' value is default by Merk API
     */
    public function getSuggestByRegNo(string $regno, string $countryCode = 'cz'): Response
    {
        $response = $this->client->requestGet(
            'suggest/',
            ['regno' => $regno, 'country_code' => $countryCode]
        );

        if ($response->isNoContent()) {
            throw new NotFoundException('No company found', 404, $response);
        }

        return $response;
    }
}
