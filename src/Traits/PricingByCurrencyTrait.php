<?php

namespace Heystack\DB\Traits;

use SebastianBergmann\Money\Money;

/**
 * @package Heystack\DB\Traits
 */
trait PricingByCurrencyTrait
{
    /**
     * @return \SebastianBergmann\Money\Money
     */
    public function getPrice()
    {
        $currency = $this->getCurrencyService()->getActiveCurrency();
        return new Money(intval($currency->getSubUnit() * $this->getField($currency->getCurrencyCode() . 'Price')), $currency);
    }

    /**
     * @return \Heystack\Ecommerce\Currency\Interfaces\CurrencyServiceInterface
     */
    abstract function getCurrencyService();
    
    abstract function getField($field);
}