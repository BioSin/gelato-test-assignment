<?php

namespace tests\codeception\common\fixtures;

use yii\test\ActiveFixture;

/**
 * User fixture
 */
class CurrencyFixture extends ActiveFixture
{
    public $tableName = 'currency';
    public $modelClass = 'common\models\Currency';
}
