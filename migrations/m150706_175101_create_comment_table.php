<?php

use yii\db\Migration;
use yii\db\Schema;

class m150706_175101_create_comment_table extends Migration
{

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('comment', [
            'id' => 'pk',
            'model' => Schema::TYPE_STRING . '(64) NOT NULL DEFAULT ""',
            'model_id' => Schema::TYPE_INTEGER . '(11)',
            'user_id' => Schema::TYPE_INTEGER . '(11) DEFAULT NULL',
            'username' => Schema::TYPE_STRING . '(128) DEFAULT NULL',
            'email' => Schema::TYPE_STRING . '(128) DEFAULT NULL',
            'parent_id' => Schema::TYPE_INTEGER . '(11) DEFAULT NULL COMMENT "null-is not a reply, int-replied comment id"',
            'status' => Schema::TYPE_INTEGER . '(1) unsigned NOT NULL DEFAULT "1" COMMENT "0-pending,1-published,2-spam,3-deleted"',
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updated_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'content' => Schema::TYPE_TEXT . ' NOT NULL',
            'user_ip' => Schema::TYPE_STRING . '(15) DEFAULT NULL',
        ], $tableOptions);

        $this->createIndex('comment_model', 'comment', ['model']);
        $this->createIndex('comment_model_id', 'comment', ['model', 'model_id']);
        $this->createIndex('comment_status', 'comment', 'status');
        $this->createIndex('comment_reply', 'comment', 'parent_id');
    }

    public function down()
    {
        $this->dropTable('comment');
    }
}