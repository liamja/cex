<?php declare(strict_types=1);

namespace Liamja\Cex\Models;

/**
 * Box Detail
 */
class BoxDetail
{
    /** @var string Box ID. */
    public $boxId;

    /** @var string Box name. */
    public $boxName;

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
    public $cashPrice;

    /** @var float */
    public $exchangePrice;

    /** @var float */
    public $sellPrice;

    /** @var int|null */
    public $boxRating;

    /** @var bool Is the box out of stock? */
    public $outOfStock;

    /** @var int */
    public $ecomQuantityOnHand;

    /** @var bool Is web selling allowed? */
    public $webSellAllowed;

    /** @var bool Is web buying allowed? */
    public $webBuyAllowed;

    /** @var bool Is web sell price shown? */
    public $webShowSellPrice;

    /** @var bool Is web buy price shown? */
    public $webShowBuyPrice;

    /** @var string[] URLs to images of box art. */
    public $imageUrls;

    /** @var bool Is this the master box? */
    public $isMasterBox;

    /** @var string Box description, marked up in HTML. */
    public $boxDescription;

    /** @var int|null */
    public $operatorId;

    /** @var int|null */
    public $gradeId;

    /** @var string|null */
    public $boxRatingText;

    /** @var mixed|null */
    public $attributeDetails;
}
