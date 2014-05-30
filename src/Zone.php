<?php

namespace Heystack\Zoning;

use Heystack\Core\GenerateContainerDataObjectTrait;
use Heystack\Ecommerce\Locale\Interfaces\ZoneDataProviderInterface;

/**
 * @package Heystack\Zoning
 */
class Zone extends \DataObject implements ZoneDataProviderInterface
{
    use GenerateContainerDataObjectTrait;

    /**
     * @var array
     */
    private static $db = array(
        'Name' => 'Varchar(255)'
    );

    /**
     * @var array
     */
    private static $has_many = array(
        'Countries' => 'Heystack\\Zoning\\Country'
    );

    /**
     * @var array
     */
    private static $summary_fields = array(
        'Name'
    );

    /**
     * @return FieldList
     */
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->removeByName('Countries');

        $fields
            ->tab("Countries")
            ->hasManyGrid(
                "Countries",
                "Countries",
                $this->Countries()->filter("ZoneID", $this->ID)
            )
        ;

        return $fields;
    }

    /**
     * Returns the name of the Zone object
     * @return string
     */
    public function getName()
    {
        return $this->getField('Name');
    }

    /**
     * An array of strings
     * @return array
     */
    public function getCountryCodes()
    {
        $countries = [];
        
        foreach ($this->Countries() as $country) {
            $countries[] = $country->CountryCode;
        }
        
        return $countries;
    }
}
