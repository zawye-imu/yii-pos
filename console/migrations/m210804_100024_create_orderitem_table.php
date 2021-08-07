<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%orderitem}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%product}}`
 * - `{{%setmenu}}`
 * - `{{%order}}`
 */
class m210804_100024_create_orderitem_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%orderitem}}', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer(),
            'set_id' => $this->integer(),
            'order_id' => $this->integer()->notNull(),
            'qty' => $this->integer(),
        ]);

        // creates index for column `product_id`
        $this->createIndex(
            '{{%idx-orderitem-product_id}}',
            '{{%orderitem}}',
            'product_id'
        );

        // add foreign key for table `{{%product}}`
        $this->addForeignKey(
            '{{%fk-orderitem-product_id}}',
            '{{%orderitem}}',
            'product_id',
            '{{%product}}',
            'id',
            'CASCADE'
        );

        // creates index for column `set_id`
        $this->createIndex(
            '{{%idx-orderitem-set_id}}',
            '{{%orderitem}}',
            'set_id'
        );

        // add foreign key for table `{{%setmenu}}`
        $this->addForeignKey(
            '{{%fk-orderitem-set_id}}',
            '{{%orderitem}}',
            'set_id',
            '{{%setmenu}}',
            'id',
            'CASCADE'
        );

        // creates index for column `order_id`
        $this->createIndex(
            '{{%idx-orderitem-order_id}}',
            '{{%orderitem}}',
            'order_id'
        );

        // add foreign key for table `{{%order}}`
        $this->addForeignKey(
            '{{%fk-orderitem-order_id}}',
            '{{%orderitem}}',
            'order_id',
            '{{%order}}',
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
            '{{%fk-orderitem-product_id}}',
            '{{%orderitem}}'
        );

        // drops index for column `product_id`
        $this->dropIndex(
            '{{%idx-orderitem-product_id}}',
            '{{%orderitem}}'
        );

        // drops foreign key for table `{{%setmenu}}`
        $this->dropForeignKey(
            '{{%fk-orderitem-set_id}}',
            '{{%orderitem}}'
        );

        // drops index for column `set_id`
        $this->dropIndex(
            '{{%idx-orderitem-set_id}}',
            '{{%orderitem}}'
        );

        // drops foreign key for table `{{%order}}`
        $this->dropForeignKey(
            '{{%fk-orderitem-order_id}}',
            '{{%orderitem}}'
        );

        // drops index for column `order_id`
        $this->dropIndex(
            '{{%idx-orderitem-order_id}}',
            '{{%orderitem}}'
        );

        $this->dropTable('{{%orderitem}}');
    }
}
