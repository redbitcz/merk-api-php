<?php

declare(strict_types=1);

use Redbitcz\MerkApi\MerkFactory;

include '../vendor/autoload.php';

$apiKey = 'lt32.................O0M0';
$ico = '1234567';

$merkFactory = new MerkFactory();
$merk = $merkFactory->create($apiKey);
$response = $merk->getCompanyByIc($ico);

if ($response->getStatusCode() === 200) {
    /** @noinspection ForgottenDebugOutputInspection */
    print_r($response->getContent());
}

