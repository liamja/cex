<?php declare(strict_types=1);

namespace Liamja\Cex\Models;

class Box
{
    /** @var string Box ID. */
    public $boxId;

    /** @var int|null Master Box ID. */
    public $masterBoxId;

    /** @var string Box name. */
    public $boxName;

    /** @var bool Is this the master box? */
    public $isMasterBox;

    /** @var int ID of the category this box belongs to. */
    public $categoryId;

    /** @var string Name of the category this box belongs to. */
    public $categoryName;

    /** @var string Friendly human-readable name of the category this box belongs to. */
    public $categoryFriendlyName;

    /** @var int ID of the category this box belongs to. */
    public $superCatId;

    /** @var string Name of the category this box belongs to. */
    public $superCatName;

    /** @var string Friendly human-readable name of the category this box belongs to. */
    public $superCatFriendlyName;

    /** @var bool */
    public $cannotBuy;

    /** @var bool */
    public $isNewBox;

    /** @var float */
    public $sellPrice;

    /** @var float */
    public $cashPrice;

    /** @var float */
    public $exchangePrice;

    /** @var int|null */
    public $boxRating;

    /** @var bool Is the box out of stock? */
    public $outOfStock;

    /** @var bool */
    public $outOfEcomStock;

    /** @var int */
    public $ecomQuantityOnHand;

    /** @var string[] URLs to images of box art. */
    public $imageUrls;
}
