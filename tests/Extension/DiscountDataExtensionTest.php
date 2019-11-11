<?php

namespace Dynamic\Foxy\Recipe\Test\Extension;

use Dynamic\FoxyRecipe\TestOnly\Model\TestDiscount;
use SilverStripe\Dev\SapphireTest;
use SilverStripe\Forms\FieldList;

class DiscountDataExtensionTest extends SapphireTest
{
    protected static $fixture_file = '../fixtures.yml';

    protected static $extra_dataobjects = [
        TestDiscount::class,
    ];

    public function testGetCMSFields()
    {
        $object = singleton(TestDiscount::class);
        $fields = $object->getCMSFields();
        $this->assertInstanceOf(FieldList::class, $fields);
    }
}
