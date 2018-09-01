<?php declare(strict_types=1);

namespace Liamja\Cex\Models;

/**
 * Store
 */
class Store
{
    /** @var int Store ID. */
    public $storeId;

    /** @var string Store name. */
    public $storeName;

    /** @var string Region the store is located. */
    public $regionName;

    /** @var float Latitude. */
    public $latitude;

    /** @var float Longitude. */
    public $longitude;
}
