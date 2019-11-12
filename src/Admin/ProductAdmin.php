<?php

namespace Dynamic\FoxyRecipe\Admin;

use Dynamic\Foxy\Products\Page\ShippableProduct;
use LittleGiant\CatalogManager\ModelAdmin\CatalogPageAdmin;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldFilterHeader;
use SilverStripe\Forms\GridField\GridFieldImportButton;

/**
 * Class ProductAdmin
 * @package Dynamic\FoxyRecipe\Admin
 */
class ProductAdmin extends CatalogPageAdmin
{
    /**
     * @var string
     */
    private static $url_segment = 'product-admin';

    /**
     * @var string
     */
    private static $menu_title = 'Products';

    /**
     * @var array
     */
    private static $managed_models = [
        ShippableProduct::class,
    ];

    public function getEditForm($id = null, $fields = null)
    {
        $form = parent::getEditForm($id, $fields);

        /** @var GridField $grid */
        $grid = $form->Fields()->fieldByName($this->sanitiseClassName($this->modelClass));
        $config = $grid->getConfig();

        $config->removeComponentsByType(GridFieldImportButton::class);

        if ($this->modelClass === ShippableProduct::class) {
            /** @var \SilverStripe\Forms\GridField\GridField $grid */
            /*
            $config
                ->addComponents(
                    new GridFieldFilterHeader()
                );
            */
        }

        return $form;
    }
}
