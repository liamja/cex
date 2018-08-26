<?php

namespace Liamja\Cex;

//                     "boxId": "045496901738",
//                    "boxName": "New Super Mario Bros. Wii",
//                    "masterBoxId": null,
//                    "categoryFriendlyName": "Wii Games",
//                    "superCatId": 1,
//                    "superCatName": "Gaming",
//                    "superCatFriendlyName": "Gaming",
//                    "sellPrice": 12,
//                    "cashPrice": 5,
//                    "exchangePrice": 8

class Box
{
    /** @var string */
    public $boxId;

    /** @var int|null */
    public $masterBoxId;

    /** @var string */
    public $boxName;

    /** @var bool */
    public $isMasterBox;

    /** @var int */
    public $categoryId;

    /** @var string */
    public $categoryName;

    /** @var string */
    public $categoryFriendlyName;

    /** @var int */
    public $superCatId;

    /** @var string */
    public $superCatName;

    /** @var string */
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

    /** @var bool */
    public $outOfStock;

    /** @var bool */
    public $outOfEcomStock;

    /** @var int */
    public $ecomQuantityOnHand;

    /** @var string[] */
    public $imageUrls;
}
