<?php

namespace Heystack\DB;

use Heystack\Core\GenerateContainerDataObjectTrait;
use Heystack\Ecommerce\Currency\Interfaces\CurrencyDataProvider;
use Heystack\Ecommerce\Currency\Traits\CurrencyTrait;

/**
 * @package Heystack\DB
 */
class Currency extends \DataObject implements CurrencyDataProvider
{
    use GenerateContainerDataObjectTrait;
    use CurrencyTrait;

    private static $db = array(
        'CurrencyCode' => 'Varchar(255)',
        'Value' => 'Decimal(10,3)',
        'Symbol' => 'Varchar(255)',
        'IsDefault' => 'Boolean'
    );

    private static $summary_fields = array(
        'CurrencyCode',
        'Symbol',
        'Value',
        'IsDefault'
    );

    private static $singular_name = "Currency";

    private static $plural_name = "Currencies";

    /**
     * Returns the Currency's code, e.g. NZD, USD
     * @return string
     */
    public function getCurrencyCode()
    {
        return $this->getField('CurrencyCode');
    }

    /**
     * Returns whether the currency is the System's default
     * @return bool
     */
    public function isDefaultCurrency()
    {
        return $this->getField('IsDefault');
    }

    /**
     * Returns the value of the currency vis-a-vis the default currency
     * @return float
     */
    public function getValue()
    {
        return $this->getField('Value');
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->getCurrencyCode();
    }
}
