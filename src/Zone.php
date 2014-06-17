<?php

namespace Heystack\DB;

use Heystack\Core\GenerateContainerDataObjectTrait;
use Heystack\Ecommerce\Currency\Interfaces\CurrencyDataProvider;
use Heystack\Ecommerce\Locale\Interfaces\ZoneDataProviderInterface;

/**
 * @package Heystack\DB
 */
class Zone extends \DataObject implements ZoneDataProviderInterface
{
    use GenerateContainerDataObjectTrait;

    /**
     * @var array
     */
    private static $db = [
        'Name'         => 'Varchar(255)'
    ];

    /**
     * @var array
     */
    private static $has_one = [
        'Currency' => 'Heystack\\DB\\Currency'
    ];

    /**
     * @var array
     */
    private static $has_many = [
        'Countries' => 'Heystack\\DB\\Country'
    ];

    /**
     * @var array
     */
    private static $summary_fields = [
        'Name' => 'Name',
        'Currency.CurrencyCode' => 'Currency'
    ];

    private static $singular_name = "Zone";

    private static $plural_name = "Zones";

    /**
     * @return \FieldList
     */
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->removeByName('Countries');

        if ($this->exists()) {
            $fields->addFieldToTab('Root.Countries', new \GridField(
                'Countries',
                'Countries in zone',
                $this->Countries(),
                new \GridfieldConfig_RelationOnlyEditor())
            );
        }

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

    /**
     * @return null|string
     */
    public function getCurrency()
    {
        $currency = $this->getComponent('Currency');
        
        return $currency instanceof CurrencyDataProvider ? $currency->getCurrencyCode() : null;
    }
}
