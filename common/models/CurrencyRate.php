<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%currency_rate}}".
 *
 * @property integer $id
 * @property integer $currency_id
 * @property string $day
 * @property double $rate
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Currency $currency
 *
 * @mixin TimestampBehavior
 */
class CurrencyRate extends \yarcode\base\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%currency_rate}}';
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'timestamp_behavior' => TimestampBehavior::className()
        ];
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['currency_id', 'day', 'rate'], 'required'],
            [['currency_id'], 'integer'],
            [['day'], 'safe'],
            [['rate'], 'number'],
            [['currency_id', 'day'], 'unique', 'targetAttribute' => ['currency_id', 'day'], 'message' => 'The combination of Currency ID and Day has already been taken.'],
            [['currency_id'], 'exist', 'skipOnError' => true, 'targetClass' => Currency::className(), 'targetAttribute' => ['currency_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('models\currency', 'ID'),
            'currency_id' => Yii::t('models\currency', 'Currency ID'),
            'day' => Yii::t('models\currency', 'Day'),
            'rate' => Yii::t('models\currency', 'Rate'),
            'created_at' => Yii::t('models\currency', 'Created At'),
            'updated_at' => Yii::t('models\currency', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCurrency()
    {
        return $this->hasOne(Currency::className(), ['id' => 'currency_id']);
    }

    /**
     * @inheritdoc
     * @return \common\models\query\CurrencyRateQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\CurrencyRateQuery(get_called_class());
    }
}
