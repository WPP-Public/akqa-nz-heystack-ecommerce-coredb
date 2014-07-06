<?php

namespace Heystack\DB\DataExtension;

use DataExtension;
use FieldList;
use Heystack\Ecommerce\Currency\Interfaces\CurrencyInterface;
use Heystack\Ecommerce\Currency\Interfaces\CurrencyServiceInterface;
use Heystack\Ecommerce\Currency\Traits\HasCurrencyServiceTrait;
use Injector;
use NumericField;

/**
 * Pricing by currency extension
 *
 * Adds additional pricing fields based on the configured countries in the Locale Service
 * 
 * @package Heystack\DB\DataExtension
 */
class PricingByCurrencyExtension extends DataExtension
{
    use HasCurrencyServiceTrait;

    /**
     * @var string|null
     */
    protected $suffix;

    /**
     * @var string|null
     */
    protected $prefix;

    /**
     * Optionally provide a prefix
     * @param string|null $prefix
     */
    public function __construct($suffix = 'Price', $prefix = '')
    {
        $this->suffix = $suffix;
        $this->prefix = $prefix;
        parent::__construct();
    }

    /**
     * @param $class
     * @param $extension
     * @param $args
     * @return array
     */
    public static function get_extra_config($class, $extension, $args)
    {
        $suffix = $args && isset($args[0]) ? $args[0] : 'Price';
        $prefix = $args && isset($args[1]) ? $args[1] : '';

        // Have to rely on the injector because of static method
        $extension = Injector::inst()->create(__CLASS__, $suffix, $prefix);

        $db = [];

        $currencyService = $extension->getCurrencyService();

        if ($currencyService instanceof CurrencyServiceInterface) {
            foreach ($currencyService->getCurrencies() as $currency) {
                $db[$extension->getColumnName($currency)] = 'Decimal(10,2)';
            }
        }

        return [
            'db' => $db
        ];
    }

    /**
     * @param FieldList $fields
     * @return FieldList
     */
    public function updateCMSFields(FieldList $fields)
    {
        if ($this->currencyService instanceof CurrencyServiceInterface) {

            foreach ($this->currencyService->getCurrencies() as $currency) {
                $columnName = $this->getColumnName($currency);

                $fields->removeByName($columnName);
                $fields->addFieldToTab(
                    'Root.Prices',
                    new NumericField($columnName, \FormField::name_to_label($columnName))
                );

            }

        }

        return $fields;
    }
    
    public function getColumnName(CurrencyInterface $currency)
    {
        return sprintf(
            "%s%s%s",
            $this->prefix,
            $currency->getCurrencyCode(),
            $this->suffix
        );
    }
}
