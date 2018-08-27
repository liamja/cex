<?php declare(strict_types=1);

namespace Liamja\Cex\Models;

/**
 * Nearest Store
 */
class NearestStore
{
    /** @var int Store ID. */
    public $storeId;

    /** @var string Store name. */
    public $storeName;

    /** @var string[] URLs to photos of the store. */
    public $storeImageUrls = [];

    /** @var float Latitude. */
    public $latitude;

    /** @var float Longitude. */
    public $longitude;

    /** @var float Distance in miles from the specified search location. */
    public $distance;

    /** @var array Opening and closing times by day-of-week. */
    public $timings;
}
