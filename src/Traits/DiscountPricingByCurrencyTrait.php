<?php

namespace Heystack\DB\Traits;

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
        return \Heystack\Ecommerce\convertStringToMoney($this->{$currency->getCurrencyCode() . 'PriceDiscounted'}, $currency);
    }

    /**
     * @return \Heystack\Ecommerce\Currency\Interfaces\CurrencyServiceInterface
     */
    abstract function getCurrencyService();
}