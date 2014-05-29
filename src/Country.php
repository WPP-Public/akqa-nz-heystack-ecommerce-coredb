<?php

namespace Heystack\Zoning;

/**
 *
 */
class Country extends \DataObject
{
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
        'Zone' => 'EcommerceZone'
    );

    /**
     * @var array
     */
    private static $summary_fields = array(
        'Name',
        'CountryCode',
        'IsDefault'
    );
}