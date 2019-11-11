<?php

namespace Dynamic\FoxyRecipe\TestOnly\Model;

use Dynamic\Foxy\Discounts\Model\Discount;
use Dynamic\FoxyRecipe\Extension\DiscountDataExtension;

class TestDiscount extends Discount
{
    /**
     * @var array
     */
    private static $extensions = [
        DiscountDataExtension::class,
    ];
}
