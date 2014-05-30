<?php

namespace Heystack\Zoning;

use Heystack\Core\GenerateContainerDataObjectTrait;

/**
 * @package Heystack\Zoning
 */
class Country extends \DataObject
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
        'Zone' => 'Heystack\\Zoning\\Zone'
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