#!/usr/bin/env php
<?php declare(strict_types=1);

require 'vendor/autoload.php';

use function \GuzzleHttp\json_decode;

// Read in the command line arguments.
$searchTerm = $argv[1] ?? '';
$storeName = $arg[2] ?? '';

// Location to use when searching nearest stores.
$location = [
    'latitude' => 52.62343240000001,
    'longitude' => 1.3077290999999605,
];

// Set up a Guzzle client to interact with the CeX API.
$client = new \GuzzleHttp\Client([
    'base_uri' => 'https://wss2.cex.uk.webuy.io/v3/',
]);

// Example predictive search request.
// curl -XGET 'https://wss2.cex.uk.webuy.io/v3/boxes/predictivesearch?q=ashes%20to%20ashes'
$response = $client->get(sprintf('boxes/predictivesearch?q=%s', rawurlencode($searchTerm)));

$jsonResponse = json_decode($response->getBody());

foreach ($jsonResponse->response->data->results as $result) {
    // Check that the search result actually contains our search term in the product name.
    if (!preg_match('/' . preg_quote($searchTerm, '/') . '/i', $result->boxName)) {
        echo sprintf('"%s" doesn\'t look like "%s", skipping...', $result->boxName, $searchTerm) . PHP_EOL;
        continue;
    }

    // Example detail request.
    // curl -XGET 'https://wss2.cex.uk.webuy.io/v3/boxes/5030305620561/detail'
    $response = $client->get(sprintf('boxes/%s/detail', $result->boxId));

    $jsonResponse = json_decode($response->getBody());

    foreach ($jsonResponse->response->data->boxDetails as $box) {
        echo sprintf('Searching for "%s" at nearest stores...', $box->boxName) . PHP_EOL;

        // Example "nearest store" search.
        // curl -XGET 'https://wss2.cex.uk.webuy.io/v3/boxes/5030305620561/neareststores?latitude=52.62343240000001&longitude=1.3077290999999605'
        $response = $client->get(sprintf('boxes/%s/neareststores', $box->boxId), [
            'query' => $location,
        ]);

        $jsonResponse = json_decode($response->getBody());

        foreach ($jsonResponse->response->data->nearestStores as $store) {
            if ($store->storeName === $storeName && $store->quantityOnHand > 0) {
                echo sprintf('%s has %d in stock!', $store->storeName, $store->quantityOnHand) . PHP_EOL;
            }
        }
    }
}
