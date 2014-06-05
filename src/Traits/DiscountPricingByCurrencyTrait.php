<?php

namespace Heystack\DB\Traits;

use SebastianBergmann\Money\Money;

/**
 * @package Heystack\DB\Traits
 */
trait DiscountPricingByCurrencyTrait
{
    /**
     * @return \SebastianBergmann\Money\Money
     */
    public function getDiscountPrice()
    {
        $currency = $this->getCurrencyService()->getActiveCurrency();
        return new Money(intval($currency->getSubUnit() * $this->{$currency->getCurrencyCode() . 'PriceDiscounted'}), $currency);
    }

    /**
     * @return \Heystack\Ecommerce\Currency\Interfaces\CurrencyServiceInterface
     */
    abstract function getCurrencyService();
}