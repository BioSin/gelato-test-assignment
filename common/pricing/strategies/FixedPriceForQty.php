<?php
/**
 * @author Valentin Konusov <rlng-krsk@yandex.ru>
 */

namespace common\pricing\strategies;

/**
 * Class FixedPriceForQty
 * @package common\pricing\strategies
 */
class FixedPriceForQty extends BaseStrategy
{
    const LABEL = 'Fixed price for each quantity';
    
    /**
     * @param $quantity
     * @return int|string
     */
    public function execute($quantity)
    {
        $product = $this->product;

        if ($this->config->quantity > $quantity) {
            return $product->getCost() * $quantity;
        }

        // How many time we will apply this discount
        $times = (int)($quantity / $this->config->quantity);

        if ($this->config->oneTimeDiscount === true) {
            $times = 1;
        }

        $sumByRule = $times * $this->config->price;
        $restSum = ($quantity - ($times * $this->config->quantity)) * $product->getCost();

        return $sumByRule + $restSum;
    }
}