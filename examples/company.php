<?php

declare(strict_types=1);

use Redbitcz\MerkApi\Factory;

include '../vendor/autoload.php';

$apiKey = 'lt32.................O0M0';
$ico = '1234567';

$merk = Factory::create($apiKey);
$response = $merk->getCompanyByIc($ico);

if ($response->getStatusCode() === 200) {
    /** @noinspection ForgottenDebugOutputInspection */
    print_r($response->getContent());
}

