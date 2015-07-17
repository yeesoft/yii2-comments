<?php

namespace yeesoft\comments\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yeesoft\comments\Module;

/**
 * This is the model class for table "comment".
 *
 * @property integer $id
 * @property string $model
 * @property integer $model_id
 * @property integer $user_id
 * @property string $username
 * @property string $email
 * @property integer $parent_id
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
    const STATUS_PENDING   = 0;
    const STATUS_PUBLISHED = 1;
    const STATUS_SPAM      = 2;
    const STATUS_DELETED   = 3;
    const SCENARIO_GUEST   = 'guest';
    const SCENARIO_USER    = 'user';

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
    public function init()
    {
        parent::init();
        $this->on(self::EVENT_BEFORE_INSERT, [$this, 'setUserData']);
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content'], 'required'],
            [['username', 'email'], 'required', 'on' => self::SCENARIO_GUEST],
            [['parent_id'], 'integer'],
            [['content'], 'string'],
            [['username'], 'string', 'max' => 128],
            [['username', 'content'], 'string', 'min' => 4],
            [['email'], 'email'],
            ['username', 'unique',
                'targetClass' => Module::getInstance()->userModel,
                'targetAttribute' => 'username',
                'on' => self::SCENARIO_GUEST
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenarios                       = parent::scenarios();
        $scenarios[self::SCENARIO_USER]  = ['content', 'parent_id'];
        $scenarios[self::SCENARIO_GUEST] = ['username', 'email', 'content', 'parent_id'];
        return $scenarios;
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
            'parent_id' => 'Parent Id',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'content' => 'Content',
            'user_ip' => 'User Ip',
        ];
    }

    /**
     * @inheritdoc
     * 
     * @return CommentQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CommentQuery(get_called_class());
    }

    /**
     * Get author of comment
     *
     * @return string
     */
    public function getAuthor()
    {
        if ($this->user_id) {
            $userModel = Module::getInstance()->userModel;
            return $userModel::findIdentity($this->user_id)->username;
        } else {
            return $this->username;
        }
    }

    /**
     * Updates user's data before comment insert
     */
    public function setUserData()
    {
        $this->user_ip = Yii::$app->getRequest()->getUserIP();

        if (!Yii::$app->user->isGuest) {
            $this->user_id = Yii::$app->user->id;
        }
    }

    /**
     * Check whether comment has replies
     *
     * @return int nubmer of replies
     */
    public function isReplied()
    {
        return Comment::find()->where(['parent_id' => $this->id])->active()->count();
    }

    /**
     * Get count of active comments by $model and $model_id
     *
     * @param string $model
     * @param int $model_id
     * @return int
     */
    public static function activeCount($model, $model_id = NULL)
    {
        return Comment::find()->where(['model' => $model, 'model_id' => $model_id])->active()->count();
    }
}