<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\PricingRule]].
 *
 * @see \common\models\PricingRule
 */
class PricingRuleQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    public function orderByWeight()
    {
        return $this->orderBy(['priority_weight' => SORT_DESC]);
    }

    /**
     * @inheritdoc
     * @return \common\models\PricingRule[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\PricingRule|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
