# CeX API Client

PHP client for CeX UK's internal Ajax API.

This client was created from reverse engineering the Ajax responses
when browsing the website, so it assumes a lot.

## License

Licensed under MIT - see [LICENSE.md]() for more info.


## Installation

```shell
composer require liamja/cex
```


## Testing

```shell
vendor/bin/phpunit
```


## Getting Started

Create a new instance of the CeX Client:

```php
$cex = new CexClient();
```


## Searching for Products / Boxes

Individual products are referred to as _Boxes_.

```php
// Specify a new set of search parameters.
$searchParameters = new SearchParameters();
$searchParameters->setSearchTerm('Super Mario Bros');

// Search for boxes that match our parameters.
$boxes = $cex->searchBoxes($searchParameters);

// CexClient::searchBoxes() returns an array of \Liamja\Cex\Models\Box
foreach ($boxes as $box) {
    // Get the box's unique ID.
    echo $box->boxId;          // 045496901738
        
    // Get the box's name.
    echo $box->boxName;        // New Super Mario Bros. Wii
       
    // Get the category the box belongs to.
    echo $box->categoryName;   // Wii Software  
         
    // Get the cash price.
    echo $box->cashPrice;      // 5.00   
          
    // Get the trade-in / exchange price.
    echo $box->exchangePrice;  // 8.00    
          
    // Get the sale price.
    echo $box->salePrice;      // 12.00
}
```


## Searching for Stores

To search for stock near a location, you'll first need to search for the store.

The API will return a set of stores closest to a given latitude and longitude.

Geocoding isn't in the scope of this package, but you can lookup a location's
approximate latitude and longitude using a geocoding service such as http://geocode.xyz:

```php
// Set up a new Guzzle client solely for geocoding.
$geocodeClient = new \GuzzleHttp\Client([
    'base_uri' => 'https://geocode.xyz/',
]);

$response = $geocodeClient->get('Manchester, UK' . '?json=1');
$results  = json_decode($response->getBody()->getContent());

// Use the geocoding results to find stores closest to Manchester.
$stores = $cex->nearestStores($results->latt, $results->longt);
```

To find stores closest to a longitude and latitude:

```php
// First, you'll need the lat/long of the location you want to search.
$latitude  = 52.62343240000001;
$longitude = 1.3077290999999605;

// Search for stores closest to a given location.
$stores = $cex->nearestStores($latitude, $longitude);

// CexClient::nearestStores() returns an array of \Liamja\Cex\Models\NearestStore
foreach ($stores as $store) {
    // Get the store's unique ID.
    echo $store->storeId;                   // 168
        
    // Get the store's name.
    echo $stores->storeName;                // Norwich
           
    // How far away the store is from the given location, in miles.
    echo $stores->distance;                 // 0.47
       
    // Opening days and times.
    echo $box->timings['open']['monday'];   //  9:00
    echo $box->timings['close']['friday'];  // 18:00
}
```


## Get All Stores

```php
$stores = $cex->getStores();

// CexClient::getStores() returns an array of \Liamja\Cex\Models\Store
foreach ($stores as $store) {
    // Get the store's unique ID.
    echo $store->storeId;     // 168
        
    // Get the store's name.
    echo $stores->storeName;  // Norwich  
          
    // Get the store's region.
    echo $stores->storeName;  // East Anglia
}
```


### Searching for Products at a Given Store

```php
// Search for stores closest to a given location.
$stores = $cex->nearestStores(52.62343240000001, 1.3077290999999605);

// Get the nearest store's ID.
$storeId = $stores[0]->storeId

// Search for stocked Battletoads at our nearest store.
$searchParameters = new SearchParameters();
$searchParameters
    ->setSearchTerm('Battletoads')
    ->setStoreId($storeId)
    ->isInStock();

$boxes = $cex->searchBoxes($searchParameters);
```


## Handling Errors

If the API returns an error, a FailureException will be thrown:

```php
try {
    $boxes = $cex->searchBoxes($searchParameters);
} catch (\Liamja\Cex\FailureException $e) {
    echo $e->getMessage();   // "Missing search text"
    echo $e->getCode();      // 
    echo $e->getMoreInfo();  // []
}
```


## Cheatsheet

```php
$cex = new CexClient();

// Search for 'Battleloads' titles that are in stock.
$searchParameters = new SearchParameters();
$searchParameters
    ->setSearchTerm('Battletoads')
    ->isInStock();

$boxes = $cex->searchBoxes($searchParameters);

var_dump($boxes);

// Search using their predictive search (seems better at sorting by relevancy.)
$searchParameters = new SearchParameters();
$searchParameters->setSearchTerm('Super Mario Bros');

$results = $cex->predictiveSearch($searchParameters);

var_dump($results);

// Search for stores closest to a given location.
$stores = $cex->nearestStores(52.62343240000001, 1.3077290999999605);

var_dump($stores);

// Show all stores in the country.
$stores = $cex->getStores();

var_dump($stores);

```
