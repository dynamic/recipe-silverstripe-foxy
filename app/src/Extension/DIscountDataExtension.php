<?php

namespace Dynamic\FoxyRecipe\Extension;

use Dynamic\Foxy\Discounts\Model\Discount;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\GridField\GridFieldAddExistingAutocompleter;
use SilverStripe\Forms\GridField\GridFieldAddNewButton;
use SilverStripe\ORM\DataExtension;
use Dynamic\Products\Page\Product;
use SilverStripe\ORM\ManyManyList;
use SilverStripe\Versioned\GridFieldArchiveAction;
use Symbiote\GridFieldExtensions\GridFieldAddExistingSearchButton;

/**
 * Class \Dynavap\Extension\DiscountDataExtension
 *
 * @property Discount|DiscountDataExtension $owner
 * @method ManyManyList|Product[] Products()
 */
class DiscountDataExtension extends DataExtension
{
    /**
     * @var array
     */
    private static $many_many = [
        'Products' => Product::class,
    ];

    /**
     * @param FieldList $fields
     */
    public function updateCMSFields(FieldList $fields)
    {
        if ($this->owner->ID) {
            // Products
            $field = $fields->dataFieldByName('Products');
            $config = $field->getConfig();
            $config
                ->removeComponentsByType([
                    GridFieldAddExistingAutocompleter::class,
                    GridFieldAddNewButton::class,
                    GridFieldArchiveAction::class,
                ])
                ->addComponents([
                    new GridFieldAddExistingSearchButton(),
                ]);
        }
    }

    /**
     * @return array
     */
    public function getRestrictions()
    {
        return $this->owner->Products()->column('ID');
    }
}
