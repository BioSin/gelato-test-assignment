<?php

namespace tests\codeception\common\fixtures;

use yii\test\ActiveFixture;

/**
 * User fixture
 */
class CurrencyRateFixture extends ActiveFixture
{
    public $modelClass = 'common\models\CurrencyRate';
    public $depends = [
        'tests\codeception\common\fixtures\CurrencyFixture'
    ];
}
