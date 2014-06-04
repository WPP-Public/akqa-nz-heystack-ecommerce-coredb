<?php

namespace Heystack\DB;

use Heystack\Core\GenerateContainerDataObjectTrait;
use Heystack\Ecommerce\Locale\Interfaces\CountryDataProviderInterface;

/**
 * @package Heystack\DB
 */
class Country extends \DataObject implements CountryDataProviderInterface
{
    use GenerateContainerDataObjectTrait;

    /**
     * @var array
     */
    private static $db = array(
        'Name' => 'Varchar(255)',
        'CountryCode' => 'Varchar(255)',
        'IsDefault' => 'Boolean'
    );

    /**
     * @var array
     */
    private static $has_one = array(
        'Zone' => 'Heystack\\DB\\Zone'
    );

    /**
     * @var array
     */
    private static $summary_fields = array(
        'Name',
        'CountryCode',
        'IsDefault'
    );

    private static $singular_name = "Country";
    private static $plural_name = "Countries";

    /**
     * Returns the name of the country object
     * @return string
     */
    public function getName()
    {
        return $this->getField('Name');
    }

    /**
     * Returns the country code of the country object
     * @return string
     */
    public function getCountryCode()
    {
        return $this->getField('CountryCode');
    }

    /**
     * Returns a boolean indicating whether this is the default country
     * @return bool
     */
    public function isDefault()
    {
        return (bool) $this->getField('IsDefault');
    }
}