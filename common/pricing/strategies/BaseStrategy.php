<?php
/**
 * @author Valentin Konusov <rlng-krsk@yandex.ru>
 */

namespace common\pricing\strategies;

use common\models\Product;
use common\pricing\interfaces\PricingStrategyInterface;
use common\pricing\RuleConfig;

abstract class BaseStrategy implements PricingStrategyInterface
{
    const LABEL = null;
    
    public $manager;

    /** @var Product */
    protected $product;

    /** @var RuleConfig */
    protected $config;

    /**
     * @param Product $product
     * @param RuleConfig $config
     * @return static
     */
    public static function obtain(Product $product, RuleConfig $config)
    {
        $model = new static;
        $model->product = $product;
        $model->config = $config;

        return $model;
    }
}