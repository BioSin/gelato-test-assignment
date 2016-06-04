<?php
/**
 * @author Valentin Konusov <rlng-krsk@yandex.ru>
 */

namespace common\pricing\interfaces;


interface PricingStrategyInterface
{
    /**
     * @param $quantity
     * @return mixed
     */
    public function execute($quantity);
}