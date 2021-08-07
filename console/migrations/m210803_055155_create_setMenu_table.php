<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%setMenu}}`.
 */
class m210803_055155_create_setMenu_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%setMenu}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(32)->notNull(),
            'price' => $this->float()->notNull(),
            'description' => $this->text()->notNull(),
            'image' => $this->string(256),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%setMenu}}');
    }
}
