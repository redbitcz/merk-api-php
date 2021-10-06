<?php

declare(strict_types=1);

use Redbitcz\MerkApi\Factory;

include '../vendor/autoload.php';

$apiKey = 'lt32.................O0M0';
$ico = '1234567';

$merk = Factory::createMerk($apiKey);
$response = $merk->getSuggestByRegNo($ico);

if ($response->isOk()) {
    /** @noinspection ForgottenDebugOutputInspection */
    print_r($response->getJsonContent());
} else {
    echo "Error!\n" . $response->getContent();
    exit (1);
}

