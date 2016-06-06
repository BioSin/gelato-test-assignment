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
     * @param \DateTime|null $date
     * @return float
     */
    public static function convert(Chargeable $model, $to, $from = Currency::ID_BASE, \DateTime $date = null)
    {
        return static::convertInternal(
            Currency::resolve($from)->id,
            Currency::resolve($to)->id,
            $model->getCost(),
            $date
        );
    }

    /**
     * @param $amount
     * @param Currency|integer|string $to
     * @param Currency|integer|string|null $from
     * @param \DateTime|null $date
     * @return float
     */
    public static function convertSum($amount, $to, $from = Currency::ID_BASE, \DateTime $date = null)
    {

        if(!is_numeric($amount)) {
            throw new \LogicException("Amount should be numeric");
        }

        return static::convertInternal(
            Currency::resolve($from)->id,
            Currency::resolve($to)->id,
            (float)$amount,
            $date
        );
    }

    /**
     * @param integer $from
     * @param integer $to
     * @param $sum
     * @param \DateTime|null $date
     * @return float
     */
    protected static function convertInternal($from, $to, $sum, \DateTime $date = null)
    {
        return Currency::exchange(
            $from,
            $to,
            $sum,
            $date
        );
    }
}