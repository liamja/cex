#!/usr/bin/env php
<?php declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use GuzzleHttp\RequestOptions;
use NunoMaduro\Collision\Provider as CollisionProvider;
use function GuzzleHttp\json_decode;

// Use Collision for pretty-printing errors to the console.
(new CollisionProvider)->register();

// Read in the command line arguments.
$searchTerm = $argv[1] ?? '';
$searchLocation = $argv[2] ?? 'London, UK';

// Set up a Guzzle client to interact with the CeX API.
$geocodeClient = new \GuzzleHttp\Client([
    'base_uri' => 'https://geocode.xyz/',
]);

$response = $geocodeClient->get($searchLocation . '?json=1');

$results = json_decode($response->getBody());

// Location to use when searching nearest stores.
$location = [
    'latitude' => $results->latt,
    'longitude' => $results->longt,
];

// Set up a Guzzle client to interact with the CeX API.
$client = new \GuzzleHttp\Client([
    'base_uri' => 'https://wss2.cex.uk.webuy.io/v3/',
]);

// Example nearest store search request.
// curl -XGET 'https://wss2.cex.uk.webuy.io/v3/stores/nearest?latitude=52.6308859&longitude=1.2973550000000387' \
$response = $client->get('stores/nearest', [RequestOptions::QUERY => $location]);

$jsonResponse = json_decode($response->getBody());

$storeId = $jsonResponse->response->data->nearestStores[0]->storeId;

// Example search request.
// curl -XGET 'https://wss2.cex.uk.webuy.io/v3/boxes?q=ashes%20to%20ashes'
$response = $client->get('boxes', [
    RequestOptions::QUERY => [
        'q' => $searchTerm,
        'inStock' => 1,
        'storeIds' => '[' . $storeId . ']',
        //'categoryIds' => '[710, 1096]',
        'firstRecord' => 1,
        'count' => 25,
        'sortBy' => 'relevance',
        'sortOrder' => 'desc',
    ]
]);

$jsonResponse = json_decode($response->getBody());

foreach ($jsonResponse->response->data->boxes as $box) {
// Check that the search result actually contains our search term in the product name.
    if (!preg_match('/' . preg_quote($searchTerm, '/') . '/i', $box->boxName)) {
        continue;
    }

    // Example detail request.
    // curl -XGET 'https://wss2.cex.uk.webuy.io/v3/boxes/5030305620561/detail'
    $response = $client->get(sprintf('boxes/%s/detail', $box->boxId));

    $jsonResponse = json_decode($response->getBody());

    foreach ($jsonResponse->response->data->boxDetails as $boxDetail) {
        // Example "nearest store" search.
        // curl -XGET 'https://wss2.cex.uk.webuy.io/v3/boxes/5030305620561/neareststores?latitude=52.62343240000001&longitude=1.3077290999999605'
        $response = $client->get(sprintf('boxes/%s/neareststores', $boxDetail->boxId), [
            RequestOptions::QUERY => $location,
        ]);

        $jsonResponse = json_decode($response->getBody());

        foreach ($jsonResponse->response->data->nearestStores as $store) {
            if ($store->storeId === $storeId && $store->quantityOnHand > 0) {
                echo sprintf('%s has %dx "%s" in stock!', $store->storeName, $store->quantityOnHand, $box->boxName) . PHP_EOL;
            }
        }
    }
}

exit(0);

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
            RequestOptions::QUERY => $location,
        ]);

        $jsonResponse = json_decode($response->getBody());

        foreach ($jsonResponse->response->data->nearestStores as $store) {
            if ($store->storeId === $storeId && $store->quantityOnHand > 0) {
                echo sprintf('%s has %d in stock!', $store->storeName, $store->quantityOnHand) . PHP_EOL;
            }
        }
    }
}
