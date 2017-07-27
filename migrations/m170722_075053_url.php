<?php

use yii\db\Migration;

class m170722_075053_url extends Migration
{
    public function safeUp()
    {
        $this->createTable('url', [
            'id' => $this->primaryKey()->notNull(),
            'url' => $this->string(250)->notNull(),
            'title' => $this->string(150)->defaultValue('Not set'),
            'status_code' => $this->integer(3)->defaultValue(0),
            'check_time' => $this->timestamp()->defaultExpression('NOW()'),
        ],'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');
    }

    public function safeDown()
    {
        $this->dropTable('url');
    }
}
