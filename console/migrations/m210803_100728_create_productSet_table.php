<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%productSet}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%product}}`
 * - `{{%setmenu}}`
 */
class m210803_100728_create_productSet_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%productSet}}', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer()->notNull(),
            'set_id' => $this->integer()->notNull(),
            'qty' => $this->integer(),
        ]);

        // creates index for column `product_id`
        $this->createIndex(
            '{{%idx-productSet-product_id}}',
            '{{%productSet}}',
            'product_id'
        );

        // add foreign key for table `{{%product}}`
        $this->addForeignKey(
            '{{%fk-productSet-product_id}}',
            '{{%productSet}}',
            'product_id',
            '{{%product}}',
            'id',
            'CASCADE'
        );

        // creates index for column `set_id`
        $this->createIndex(
            '{{%idx-productSet-set_id}}',
            '{{%productSet}}',
            'set_id'
        );

        // add foreign key for table `{{%setmenu}}`
        $this->addForeignKey(
            '{{%fk-productSet-set_id}}',
            '{{%productSet}}',
            'set_id',
            '{{%setmenu}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%product}}`
        $this->dropForeignKey(
            '{{%fk-productSet-product_id}}',
            '{{%productSet}}'
        );

        // drops index for column `product_id`
        $this->dropIndex(
            '{{%idx-productSet-product_id}}',
            '{{%productSet}}'
        );

        // drops foreign key for table `{{%setmenu}}`
        $this->dropForeignKey(
            '{{%fk-productSet-set_id}}',
            '{{%productSet}}'
        );

        // drops index for column `set_id`
        $this->dropIndex(
            '{{%idx-productSet-set_id}}',
            '{{%productSet}}'
        );

        $this->dropTable('{{%productSet}}');
    }
}
