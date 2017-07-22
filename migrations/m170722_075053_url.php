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
            'processed' => $this->boolean()->defaultValue(false),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('url');
    }
}
