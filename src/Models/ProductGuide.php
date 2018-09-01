<?php declare(strict_types=1);

namespace Liamja\Cex\Models;

/**
 * Product Guide
 */
class ProductGuide
{
    /** @var int Product line ID. */
    public $productLineId;

    /** @var string Product line description, marked up in HTML. */
    public $productGuideDescription;

    /** @var mixed|null */
    public $globalGuide;
}
