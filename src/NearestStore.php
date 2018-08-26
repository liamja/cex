<?php declare(strict_types=1);

namespace Liamja\Cex;

/**
 * Nearest Store
 */
class NearestStore
{
    /** @var int */
    public $storeId;

    /** @var string */
    public $storeName;

    /** @var string[] */
    public $storeImageUrls = [];

    /** @var float */
    public $latitude;

    /** @var float */
    public $longitude;

    /** @var float */
    public $distance;

    /** @var array */
    public $timings;
}
