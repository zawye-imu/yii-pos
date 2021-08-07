<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%modifiers}}`.
 */
class m210802_093103_create_modifiers_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%modifiers}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(64)->notNull(),
            'price' => $this->float()->notNull(),
            'image' => $this->string(256),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%modifiers}}');
    }
}
