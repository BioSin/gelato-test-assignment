<?php
/**
 * @author Valentin Konusov <rlng-krsk@yandex.ru>
 */

namespace common\pricing;

use yii\base\Model;
use yii\helpers\Json;

class RuleConfig extends Model
{
    public $type;
    public $quantity;
    public $price;
    /** @var boolean if true, discount should be applied only one time */
    public $oneTimeDiscount;

    /**
     * @param $config
     * @return RuleConfig
     */
    public static function obtain($config)
    {
        $config = is_array($config) ? $config : Json::decode($config);
        $model = new static;
        $model->setAttributes($config, false);

        return $model;
    }


    public function rules()
    {
        return [
            [['type', 'quantity', 'price'], 'required'],
        ];
    }
}