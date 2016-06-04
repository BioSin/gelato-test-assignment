<?php

use yii\db\Migration;

/**
 * Handles the creation for table `product`.
 */
class m160604_081806_create_product extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('product', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'weight' => $this->double()->notNull(),
            'measure_unit' => $this->integer()->notNull(),
            'price' => $this->money(19,4)
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('product');
    }
}
