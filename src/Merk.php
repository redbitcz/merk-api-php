<?php

declare(strict_types=1);

namespace Redbitcz\MerkApi;

use Redbitcz\MerkApi\Response\IResponse;

/**
 * @package Redbitcz\MerkApi
 * @license MIT
 * @copyright 2016-2021 Redbit s.r.o.
 * @author Redbit s.r.o. <info@redbit.cz>
 */
class Merk
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function getCompanyByIc(string $string): IResponse
    {
        return $this->client->requestGet('company/?regno=' . $string);
    }
}

