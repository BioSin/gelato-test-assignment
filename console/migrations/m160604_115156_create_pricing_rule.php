<?php

use yii\db\Migration;

/**
 * Handles the creation for table `pricing_rule`.
 * Has foreign keys to the tables:
 *
 * - `product`
 */
class m160604_115156_create_pricing_rule extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%pricing_rule}}', [
            'id' => $this->primaryKey(),
            'status' => $this->integer()->notNull()->defaultValue(0),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime()->notNull(),
            'product_id' => $this->integer()->notNull(),
            'priority_weight' => $this->integer()->notNull()->defaultValue(0),
            'config' => $this->text()->notNull(),
        ]);

        // creates index for column `product_id`
        $this->createIndex(
            'idx-pricing_rule-product_id',
            '{{%pricing_rule}}',
            'product_id'
        );

        // add foreign key for table `product`
        $this->addForeignKey(
            'fk-pricing_rule-product_id',
            '{{%pricing_rule}}',
            'product_id',
            'product',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops foreign key for table `product`
        $this->dropForeignKey(
            'fk-pricing_rule-product_id',
            '{{%pricing_rule}}'
        );

        // drops index for column `product_id`
        $this->dropIndex(
            'idx-pricing_rule-product_id',
            '{{%pricing_rule}}'
        );

        $this->dropTable('{{%pricing_rule}}');
    }
}
