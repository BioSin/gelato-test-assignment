<?php

namespace common\models;

use yarcode\base\helpers\DateTimeHelper;
use Yii;

/**
 * This is the model class for table "{{%currency}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $system_name
 * @property integer $is_base
 *
 * @property CurrencyRate[] $currencyRates
 */
class Currency extends \yarcode\base\ActiveRecord
{
    const ID_BASE = self::ID_USD;

    const ID_USD = 1;
    const ID_RUB = 2;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%currency}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'system_name'], 'required'],
            [['is_base'], 'integer'],
            [['name', 'system_name'], 'string', 'max' => 255],
            [['system_name'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('models\currency', 'ID'),
            'name' => Yii::t('models\currency', 'Name'),
            'system_name' => Yii::t('models\currency', 'System Name'),
            'is_base' => Yii::t('models\currency', 'Is Base'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCurrencyRates()
    {
        return $this->hasMany(CurrencyRate::className(), ['currency_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return \common\models\query\CurrencyQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\CurrencyQuery(get_called_class());
    }

    /**
     * Exchange currencies
     * @param $from
     * @param $to
     * @param $amount
     * @param $date
     * @return float
     */
    public static function exchange($from, $to, $amount, \DateTime $date = null)
    {
        if ($to == $from) {
            return $amount;
        }

        $rates = (null === $date)
            ? static::getTodayRates()
            : static::getRates($date);

        if (!array_key_exists($from, $rates) || !array_key_exists($to, $rates)) {
            throw new \LogicException("Unknown currency or no rate for date: from({$from}) or to ({$to})");
        }

        return $amount * $rates[$to] / $rates[$from];
    }

    /**
     * @return array
     */
    public static function getTodayRates()
    {
        $today = DateTimeHelper::getNow();
        return static::getRates($today);
    }

    /**
     * Return rates for specified date
     *
     * @param \DateTime $date
     * @return array
     */
    public static function getRates(\DateTime $date)
    {
        return CurrencyRate::find()->indexBy('currency_id')->select('rate')->andWhere([
            'day' => $date->format(DateTimeHelper::FORMAT_SQL_DATE)
        ])->asArray()->column();
    }

    /**
     * @param $systemName
     * @return null|static
     */
    public static function findBySystemName($systemName)
    {
        return static::findOne(['system_name' => $systemName]);
    }

    /**
     * @param $currency
     * @return Currency
     */
    public static function resolve($currency)
    {
        if($currency instanceof static) {
            return $currency;
        }

        $model = null;

        if(is_integer($currency)) {
            $model = static::findOne($currency);
        }

        if(is_string($currency)) {
            $model = static::findBySystemName($currency);
        }
        
        if(null === $model) {
            throw new \InvalidArgumentException(Yii::t('app', 'Invalid currency'));
        }
        
        return $model;
    }
}
