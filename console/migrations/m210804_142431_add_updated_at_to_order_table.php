<?php

use yii\db\Migration;

/**
 * Class m210804_142431_add_updated_at_to_order_table
 */
class m210804_142431_add_updated_at_to_order_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210804_142431_add_updated_at_to_order_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210804_142431_add_updated_at_to_order_table cannot be reverted.\n";

        return false;
    }
    */
}
