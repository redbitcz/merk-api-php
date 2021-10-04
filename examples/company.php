<?php

declare(strict_types=1);

use Redbitcz\MerkApi\Factory;

include '../vendor/autoload.php';

$apiKey = 'lt32.................O0M0';
$ico = '1234567';

$merk = Factory::createMerk($apiKey);
$response = $merk->getCompanyByRegNo($ico);

if ($response->getStatusCode() === 200) {
    /** @noinspection ForgottenDebugOutputInspection */
    print_r($response->getJson());
} else {
    echo "Error!\n" . $response->getContent();
    exit (1);
}

