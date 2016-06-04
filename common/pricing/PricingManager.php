<?php
/**
 * @author Valentin Konusov <rlng-krsk@yandex.ru>
 */

namespace common\pricing;

use common\models\PricingRule;
use common\models\Product;
use common\pricing\strategies\BaseStrategy;
use yarcode\base\traits\TypeTrait;
use yii\base\BootstrapInterface;
use yii\base\Component;

/**
 * Class PricingManager
 * @package common\pricing
 */
class PricingManager extends Component implements BootstrapInterface
{
    /**
     * @var array
     */
    protected $strategies = [];

    /**
     * @param \yii\base\Application $app
     */
    public function bootstrap($app)
    {
        static::getInstance();
    }

    /**
     * @param Product $product
     * @param $quantity
     * @return string
     */
    public function calculate(Product $product, $quantity)
    {
        $rules = PricingRule::find()->orderByWeight()->andWhere([
            'product_id' => $product->id
        ])->all();

        $lowestPrice = $product->getCost() * $quantity;

        if(empty($rules)) {
            return $lowestPrice;
        }

        foreach ($rules as $rule) {
            $config = RuleConfig::obtain($rule->config);
            $strategyClass = $config->type;
            /** @var BaseStrategy $strategy */
            $strategy = $strategyClass::obtain($product, $config);
            $price = $strategy->execute($quantity);

            $lowestPrice = $lowestPrice > $price
                ? $price
                : $lowestPrice;
        }

        return $lowestPrice;
    }

    /**
     * @return null|object
     * @throws \yii\base\InvalidConfigException
     */
    public static function getInstance()
    {
        return \Yii::$app->get('pricingManager');
    }

    /**
     * @param array $strategies
     */
    public function setStrategies(array $strategies)
    {
        foreach ($strategies as $className) {
            $this->registerStrategy($className);
        }
    }

    /**
     * @param $className
     * @throws \yii\base\InvalidConfigException
     */
    protected function registerStrategy($className)
    {
        if(!class_exists($className)) {
            throw new \LogicException("Unknown strategy className {$className}");
        }

        if (isset($this->strategies[$className])) {
            return;
        }
        
        $this->strategies[] = $className;
    }
}