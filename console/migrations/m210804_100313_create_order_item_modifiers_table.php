<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%order_item_modifiers}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%orderitem}}`
 * - `{{%modifiers}}`
 */
class m210804_100313_create_order_item_modifiers_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%order_item_modifiers}}', [
            'id' => $this->primaryKey(),
            'orderitem_id' => $this->integer(),
            'modifier_id' => $this->integer(),
            'qty' => $this->integer(),
        ]);

        // creates index for column `orderitem_id`
        $this->createIndex(
            '{{%idx-order_item_modifiers-orderitem_id}}',
            '{{%order_item_modifiers}}',
            'orderitem_id'
        );

        // add foreign key for table `{{%orderitem}}`
        $this->addForeignKey(
            '{{%fk-order_item_modifiers-orderitem_id}}',
            '{{%order_item_modifiers}}',
            'orderitem_id',
            '{{%orderitem}}',
            'id',
            'CASCADE'
        );

        // creates index for column `modifier_id`
        $this->createIndex(
            '{{%idx-order_item_modifiers-modifier_id}}',
            '{{%order_item_modifiers}}',
            'modifier_id'
        );

        // add foreign key for table `{{%modifiers}}`
        $this->addForeignKey(
            '{{%fk-order_item_modifiers-modifier_id}}',
            '{{%order_item_modifiers}}',
            'modifier_id',
            '{{%modifiers}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%orderitem}}`
        $this->dropForeignKey(
            '{{%fk-order_item_modifiers-orderitem_id}}',
            '{{%order_item_modifiers}}'
        );

        // drops index for column `orderitem_id`
        $this->dropIndex(
            '{{%idx-order_item_modifiers-orderitem_id}}',
            '{{%order_item_modifiers}}'
        );

        // drops foreign key for table `{{%modifiers}}`
        $this->dropForeignKey(
            '{{%fk-order_item_modifiers-modifier_id}}',
            '{{%order_item_modifiers}}'
        );

        // drops index for column `modifier_id`
        $this->dropIndex(
            '{{%idx-order_item_modifiers-modifier_id}}',
            '{{%order_item_modifiers}}'
        );

        $this->dropTable('{{%order_item_modifiers}}');
    }
}
