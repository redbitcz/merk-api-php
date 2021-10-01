<?php

declare(strict_types=1);

namespace Redbitcz\MerkApi\Response;

interface IResponse
{
    /** @return string|array<int, mixed> */
    public function getContent();

    /** @return array<string, array<int, string>> */
    public function getHeaders(): array;

    public function getStatusCode(): int;
}
