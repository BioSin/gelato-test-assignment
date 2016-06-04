<?php

use yii\db\Migration;

class m160604_101638_populate_currency_rate_table extends Migration
{
    public function safeUp()
    {
        $now = new DateTime('today', new DateTimeZone('UTC'));
        $dateString = $now->format('Y-m-d');
        $this->batchInsert('{{%currency_rate}}', ['currency_id', 'day', 'rate', 'created_at', 'updated_at'], [
            [1, $dateString, 1, $dateString, $dateString],
            [2, $dateString, 65, $dateString, $dateString],

        ]);
    }

    public function safeDown()
    {
        $this->truncateTable('{{%currency_rate}}');
    }
}
