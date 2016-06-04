<?php

namespace common\models;

use yarcode\base\ActiveRecord;
use Yii;

/**
 * This is the model class for table "{{%product}}".
 *
 * @property integer $id
 * @property string $name
 * @property double $weight
 * @property integer $measure_unit
 * @property string $price
 */
class Product extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%product}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'weight', 'measure_unit'], 'required'],
            [['weight', 'price'], 'number'],
            [['measure_unit'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('models\product', 'ID'),
            'name' => Yii::t('models\product', 'Name'),
            'weight' => Yii::t('models\product', 'Weight'),
            'measure_unit' => Yii::t('models\product', 'Measure Unit'),
            'price' => Yii::t('models\product', 'Price'),
        ];
    }

    /**
     * @inheritdoc
     * @return ProductQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProductQuery(get_called_class());
    }
}
