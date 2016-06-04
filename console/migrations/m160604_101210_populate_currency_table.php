<?php

use yii\db\Migration;

class m160604_101210_populate_currency_table extends Migration
{
    public function safeUp()
    {
        $this->batchInsert('{{%currency}}', ['id', 'name', 'system_name', 'is_base'], [
            [1, 'US Dollar', 'USD', 1],
            [2, 'Russian Ruble', 'RUB', 0]
        ]);
    }

    public function safeDown()
    {
        $this->delete('{{%currency}}', ['id' => [1,2]]);
    }
}
