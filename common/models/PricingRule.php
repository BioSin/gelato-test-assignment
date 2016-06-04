<?php

namespace common\models;

use common\pricing\RuleConfig;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "pricing_rule".
 *
 * @property integer $id
 * @property integer $status
 * @property string $created_at
 * @property string $updated_at
 * @property integer $product_id
 * @property integer $priority_weight
 * @property string $config
 *
 * @property Product $product
 * 
 * @mixin TimestampBehavior
 */
class PricingRule extends \yarcode\base\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%pricing_rule}}';
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
            [['status', 'product_id', 'priority_weight'], 'integer'],
            [['product_id', 'config'], 'required'],
            [['config'], 'string'],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
            ['config', 'validateConfig']
        ];
    }

    /**
     * @param $attribute
     * @param $params
     */
    public function validateConfig($attribute, $params)
    {
        if($this->hasErrors($attribute)) {
            return;
        }
        
        if(isset($config['type'], $config['quantity'], $config['price'], $config['oneTimeDicount'])) {
            $config = RuleConfig::obtain($this->config);
            if(!$config->validate()) {
                $errors = $config->getFirstErrors();
                foreach ($errors as $configParam => $message) {
                    $this->addError($attribute, "{$configParam}: $message");
                }
            }
        }
        
        
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('models\pricingRule', 'ID'),
            'status' => Yii::t('models\pricingRule', 'Status'),
            'created_at' => Yii::t('models\pricingRule', 'Created At'),
            'updated_at' => Yii::t('models\pricingRule', 'Updated At'),
            'product_id' => Yii::t('models\pricingRule', 'Product ID'),
            'priority_weight' => Yii::t('models\pricingRule', 'Priority Weight'),
            'config' => Yii::t('models\pricingRule', 'Config'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    /**
     * @inheritdoc
     * @return \common\models\query\PricingRuleQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\PricingRuleQuery(get_called_class());
    }
}
