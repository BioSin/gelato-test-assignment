<?php
/**
 * @author Valentin Konusov <rlng-krsk@yandex.ru>
 */

namespace common\core\components;

use common\core\interfaces\Chargeable;
use common\models\Currency;
use yii\base\Component;

/**
 * Class CurrencyConverter
 * @package common\core\components
 */
class CurrencyConverter extends Component
{
    /**
     * @param Chargeable $model
     * @param Currency|integer|string $to
     * @param Currency|integer|string|null $from
     * @return float
     */
    public static function convert(Chargeable $model, $to, $from = null)
    {
        return static::convertInternal(
            Currency::resolve($from)->id,
            Currency::resolve($to)->id,
            $model->getCost()
        );
    }

    /**
     * @param $amount
     * @param Currency|integer|string $to
     * @param Currency|integer|string|null $from
     * @return float
     */
    public static function convertSum($amount, $to, $from = null)
    {
        return static::convertInternal(
            Currency::resolve($from)->id,
            Currency::resolve($to)->id,
            $amount
        );
    }

    /**
     * @param integer $from
     * @param integer $to
     * @param $sum
     * @return float
     */
    protected static function convertInternal($from, $to, $sum)
    {
        return Currency::exchange(
            $from,
            $to,
            $sum
        );
    }
}