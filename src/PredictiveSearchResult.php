<?php

namespace Liamja\Cex;

class PredictiveSearchResult
{
    /** @var string */
    public $boxId;

    /** @var string */
    public $boxName;

    /** @var int|null */
    public $masterBoxId;

    /** @var string */
    public $categoryFriendlyName;

    /** @var int */
    public $superCatId;

    /** @var string */
    public $superCatName;

    /** @var string */
    public $superCatFriendlyName;

    /** @var float */
    public $sellPrice;

    /** @var float */
    public $cashPrice;

    /** @var float */
    public $exchangePrice;
}
