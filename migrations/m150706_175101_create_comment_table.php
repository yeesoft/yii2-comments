<?php

class m150706_175101_create_comment_table extends yii\db\Migration
{
    
    const TABLE_NAME = '{{%comment}}';
    
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable(self::TABLE_NAME, [
            'id' => $this->primaryKey(),
            'model' => $this->string(64)->notNull()->defaultValue(''),
            'model_id' => $this->integer(),
            'user_id' => $this->integer(),
            'username' => $this->string(128),
            'email' => $this->string(128),
            'parent_id' => $this->integer()->comment('null-is not a reply, int-replied comment id'),
            'content' => $this->text(),
            'status' => $this->integer(1)->unsigned()->notNull()->defaultValue(1)->comment('0-pending,1-published,2-spam,3-deleted'),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'updated_by' => $this->integer(),
            'user_ip' => $this->string(15),
        ], $tableOptions);

        $this->createIndex('comment_model', self::TABLE_NAME, 'model');
        $this->createIndex('comment_model_id', self::TABLE_NAME, ['model', 'model_id']);
        $this->createIndex('comment_status', self::TABLE_NAME, 'status');
        $this->createIndex('comment_reply', self::TABLE_NAME, 'parent_id');
    }

    public function down()
    {
        $this->dropTable(self::TABLE_NAME);
    }
}