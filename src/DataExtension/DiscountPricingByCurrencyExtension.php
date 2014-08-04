<?php

namespace Heystack\DB\DataExtension;

use Injector;
use FieldList;
use NumericField;
use Heystack\Ecommerce\Currency\Interfaces\CurrencyServiceInterface;

/**
 * @package Heystack\DB\DataExtension
 */
class DiscountPricingByCurrencyExtension extends PricingByCurrencyExtension
{
    /**
     * @param string $class
     * @param string $extension
     * @param array $args
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

                $db[$currency->getCurrencyCode() . "PriceDiscounted"] = 'Decimal(10, 2)';

            }

        }

        return [
            'db' => $db
        ];
    }

    /**
     * @param \FieldList $fields
     * @return \FieldList
     */
    public function updateCMSFields(FieldList $fields)
    {
        foreach ($this->currencyService->getCurrencies() as $currency) {

            $currencyCode = $currency->getCurrencyCode();

            $fields->removeByName($currencyCode . "PriceDiscounted");

            $fields->addFieldToTab(
                'Root.Prices',
                new NumericField($currencyCode . "PriceDiscounted", $currencyCode . " Discounted Price")
            );

        }

        return $fields;
    }
}