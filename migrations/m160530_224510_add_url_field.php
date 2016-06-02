<?php

use yii\db\Migration;

class m160530_224510_add_url_field extends Migration
{
    const TABLE_NAME = '{{%comment}}';
    
    public function up()
    {
        $this->addColumn(self::TABLE_NAME, 'url', $this->string(255));
    }

    public function down()
    {
        $this->dropColumn(self::TABLE_NAME, 'url');
    }
}