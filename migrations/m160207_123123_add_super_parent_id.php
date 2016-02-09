<?php

use yii\db\Migration;
use yii\db\Schema;

class m160207_123123_add_super_parent_id extends Migration
{

    public function up()
    {
        $this->addColumn('comment', 'super_parent_id', Schema::TYPE_INTEGER . '(11) DEFAULT NULL COMMENT "null-has no parent, int-1st level parent id" AFTER `email`');
        $this->createIndex('comment_super_parent_id', 'comment', 'super_parent_id');
    }

    public function down()
    {
        $this->dropIndex('comment_super_parent_id', 'comment');
        $this->dropColumn('comment', 'super_parent_id');
    }
}