<?php

use yii\db\Migration;

/**
 * Handles the creation for table `currency_rate`.
 * Has foreign keys to the tables:
 *
 * - `currency`
 */
class m160604_100449_create_currency_rate extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%currency_rate}}', [
            'id' => $this->primaryKey(),
            'currency_id' => $this->integer()->notNull(),
            'day' => $this->date()->notNull(),
            'rate' => $this->double(4)->notNull(),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime()->notNull(),
        ]);

        $this->createIndex('uq_currency_rate-currency_id-day', '{{%currency_rate}}', ['currency_id', 'day'], true);

        // add foreign key for table `currency`
        $this->addForeignKey(
            'fk-currency_rate-currency_id',
            '{{%currency_rate}}',
            'currency_id',
            'currency',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops foreign key for table `currency`
        $this->dropForeignKey(
            'fk-currency_rate-currency_id',
            '{{%currency_rate}}'
        );

        // drops index for column `currency_id`
        $this->dropIndex(
            'uq_currency_rate-currency_id-day',
            '{{%currency_rate}}'
        );

        $this->dropTable('{{%currency_rate}}');
    }
}
