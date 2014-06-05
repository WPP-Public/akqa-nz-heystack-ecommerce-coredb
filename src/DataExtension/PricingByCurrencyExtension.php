<?php

namespace Heystack\DB\DataExtension;

use DataExtension;
use FieldList;
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
     * @param $class
     * @param $extension
     * @param $args
     * @return array
     */
    public static function get_extra_config($class, $extension, $args)
    {
        // Have to rely on the injector because of static method
        $extension = Injector::inst()->get(__CLASS__);

        $db = [];

        $currencyService = $extension->getCurrencyService();

        if ($currencyService instanceof CurrencyServiceInterface) {

            foreach ($currencyService->getCurrencies() as $currency) {

                $db[$currency->getCurrencyCode() . "Price"] = 'Decimal(10, 2)';

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

                $currencyCode = $currency->getCurrencyCode();

                $fields->removeByName($currencyCode . "Price");

                $fields->addFieldToTab(
                    'Root.Prices',
                    new NumericField($currencyCode . "Price", $currencyCode . " Price")
                );

            }

        }

        return $fields;
    }
}
