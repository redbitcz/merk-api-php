# Merk.cz API client for PHP

Package for simple and safe access to [**Merk.cz API**](https://api.merk.cz/docs/).

## What is Merk.cz API?

Merk.cz API - your programmatic gateway to company data for the Czech Republic and Slovakia.

For more info about API follow [documentation](https://api.merk.cz/docs/)

## Install

```shell
composer install redbitcz/merk-api
```

## Usage 

```php
$merk = \Redbitcz\MerkApi\Factory::create('YOUR_API_KEY');
$data = $merk->getCompanyByIc('24197190');
```
This call returns array like:

```json
{
    "regno": "24197190",
    "regno_str": "0024197190",
    "vatno": "CZ24197190",
    "taxno": null,
    "databox_ids": [
        "4648cyh"
    ],
    "name": "Redbit s.r.o.",
    "legal_form": {
        "id": "7",
        "text": "společnost s ručením omezeným"
    },
    ...
}
```
