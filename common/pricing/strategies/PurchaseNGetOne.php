<?php
/**
 * @author Valentin Konusov <rlng-krsk@yandex.ru>
 */

namespace common\pricing\strategies;

/**
 * Class FixedPriceForQty
 * @package common\pricing\strategies
 */
class PurchaseNGetOne extends BaseStrategy
{
    const LABEL = 'Purchase N, get N for free';
    
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
        
        $overallSum = $product->getCost() * $quantity;
        
        // How many time we will apply this discount
        $times = (int)($quantity / $this->config->quantity);

        if ($this->config->oneTimeDiscount === true) {
            $times = 1;
        }

        return $overallSum - ($times * $product->getCost());
    }
}