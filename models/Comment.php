<?php

namespace yeesoft\comments\models;

/**
 * This is the model class for table "comment".
 *
 * @property integer $id
 * @property string $model
 * @property integer $model_id
 * @property integer $user_id
 * @property string $username
 * @property string $email
 * @property integer $replied_to
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $content
 * @property string $user_ip
 */

/**
 * Description of Comment
 *
 * @author User
 */
class Comment extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['model_id', 'created_at', 'updated_at', 'content'], 'required'],
            [['model_id', 'user_id', 'replied_to', 'status', 'created_at', 'updated_at'],
                'integer'],
            [['content'], 'string'],
            [['model'], 'string', 'max' => 64],
            [['username'], 'string', 'max' => 128],
            [['email'], 'string', 'max' => 254],
            [['user_ip'], 'string', 'max' => 15]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'model' => 'Model',
            'model_id' => 'Model ID',
            'user_id' => 'User ID',
            'username' => 'Username',
            'email' => 'Email',
            'replied_to' => 'Replied To',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'content' => 'Content',
            'user_ip' => 'User Ip',
        ];
    }

    /**
     * @inheritdoc
     * @return CommentQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CommentQuery(get_called_class());
    }
}