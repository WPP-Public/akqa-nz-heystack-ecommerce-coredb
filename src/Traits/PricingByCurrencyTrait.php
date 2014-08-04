<?php

namespace Heystack\DB\Traits;

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
        return \Heystack\Ecommerce\convertStringToMoney($this->getField($currency->getCurrencyCode() . 'Price'), $currency);
    }

    /**
     * @return \Heystack\Ecommerce\Currency\Interfaces\CurrencyServiceInterface
     */
    abstract function getCurrencyService();

    /**
     * @param string $field
     * @return mixed
     */
    abstract function getField($field);
}