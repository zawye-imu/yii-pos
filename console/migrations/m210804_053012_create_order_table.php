<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%order}}`.
 */
class m210804_053012_create_order_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%order}}', [
            'id' => $this->primaryKey(),
            'payment' => $this->string(32),
            'shift' => $this->string(32),
            'dine' => $this->string(32),
            'cashier' => $this->string(32),
            'discount' => $this->float(),
            'subtotal' => $this->float(),
            'grandtotal' => $this->float(),
            'status' => $this->integer(1),
            'created_at' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%order}}');
    }
}
