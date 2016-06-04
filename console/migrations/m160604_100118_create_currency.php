<?php

use yii\db\Migration;

/**
 * Handles the creation for table `currency`.
 */
class m160604_100118_create_currency extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('currency', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'system_name' => $this->string()->unique()->notNull(),
            'is_base' => $this->integer()->notNull()->defaultValue(0),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('currency');
    }
}
