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
 * @property Discount|\Dynavap\Extension\DiscountDataExtension $owner
 * @method ManyManyList|Product[] Products()
 * @method ManyManyList|Product[] ExcludeProducts()
 */
class DiscountDataExtension extends DataExtension
{
    /**
     * @var array
     */
    private static $many_many = [
        'Products' => Product::class,
        'ExcludeProducts' => Product::class,
    ];

    /**
     * @param FieldList $fields
     */
    public function updateCMSFields(FieldList $fields)
    {
        if ($this->owner->ID) {
            // Products
            $field = $fields->dataFieldByName('Products');
            $fields->removeByName('Products');
            $fields->addFieldToTab('Root.Included', $field);
            $field->setDescription('Limit the discount to these products. If no products specified, all 
                products will receive the discount');
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

            $exclusions = $fields->dataFieldByName('ExcludeProducts');
            $fields->removeByName('ExcludeProducts');
            $fields->addFieldToTab('Root.Excluded', $exclusions);
            $exclusions->setDescription('Products in this list will ALWAYS be excluded from the discount, 
                even if added to the "Included" tab.');
            $excludeConfig = $exclusions->getConfig();
            $excludeConfig
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
        if ($this->owner->Products()->count() == 0) {
            $products = Product::get()->column();
        } else {
            $products = $this->Products()->column();
        }

        foreach ($this->owner->ExcludeProducts()->column() as $id) {
            if (in_array($id, $products)) {
                $key = array_search($id, $products);
                unset($products[$key]);
            }
        }

        return $products;
    }
}
