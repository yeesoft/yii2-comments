<?php

namespace yeesoft\comments\models;

use yeesoft\comments\Comments;
use Yii;
use yii\behaviors\TimestampBehavior;
use yeesoft\Yee;

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
    const STATUS_PENDING = 0;
    const STATUS_APPROVED = 1;
    const STATUS_SPAM = 2;
    const STATUS_TRASH = 3;
    const STATUS_PUBLISHED = self::STATUS_APPROVED;
    const SCENARIO_GUEST = 'guest';
    const SCENARIO_USER = 'user';

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
            ['username', 'match', 'pattern' => Comments::getInstance()->usernameRegexp, 'on' => self::SCENARIO_GUEST],
            ['username', 'match', 'not' => true, 'pattern' => Comments::getInstance()->usernameBlackRegexp, 'on' => self::SCENARIO_GUEST],
            [['email'], 'email'],
            ['username', 'unique',
                'targetClass' => Comments::getInstance()->userModel,
                'targetAttribute' => 'username',
                'on' => self::SCENARIO_GUEST,
            ],
            ['created_at', 'date', 'timestampAttribute' => 'created_at'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_USER] = ['content', 'parent_id'];
        $scenarios[self::SCENARIO_GUEST] = ['username', 'email', 'content', 'parent_id'];
        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yee::t('yee', 'ID'),
            'model' => Comments::t('comments', 'Model'),
            'model_id' => Comments::t('comments', 'Model ID'),
            'user_id' => Comments::t('comments', 'User ID'),
            'username' => Yee::t('yee', 'Username'),
            'email' => Yee::t('yee', 'E-mail'),
            'parent_id' => Comments::t('comments', 'Parent Comment'),
            'status' => Yee::t('yee', 'Status'),
            'created_at' => Yee::t('yee', 'Created'),
            'updated_at' => Yee::t('yee', 'Updated'),
            'content' => Yee::t('yee', 'Content'),
            'user_ip' => Yee::t('yee', 'IP'),
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
     * getTypeList
     * @return array
     */
    public static function getStatusList()
    {
        return [
            self::STATUS_PENDING => Yee::t('yee', 'Pending'),
            self::STATUS_APPROVED => Yee::t('yee', 'Approved'),
            self::STATUS_SPAM => Yee::t('yee', 'Spam'),
            self::STATUS_TRASH => Yee::t('yee', 'Trash'),
        ];
    }

    /**
     * getStatusOptionsList
     * @return array
     */
    public static function getStatusOptionsList()
    {
        return [
            [self::STATUS_PENDING, Yee::t('yee', 'Pending'), 'default'],
            [self::STATUS_APPROVED, Yee::t('yee', 'Approved'), 'primary'],
            [self::STATUS_SPAM, Yee::t('yee', 'Spam'), 'default'],
            [self::STATUS_TRASH, Yee::t('yee', 'Trash'), 'default']
        ];
    }

    /**
     * Get created date and time
     * @return string
     */
    public function getCreatedDateTime()
    {
        return date('Y-m-d H:i',
            ($this->isNewRecord) ? time() : $this->created_at);
    }

    /**
     * Get created date and time
     * @return string
     */
    public function getUpdatedDateTime()
    {
        return date('Y-m-d H:i',
            ($this->isNewRecord) ? time() : $this->updated_at);
    }

    /**
     * Get author of comment
     *
     * @return string
     */
    public function getAuthor()
    {
        if ($this->user_id) {
            $userModel = Comments::getInstance()->userModel;
            $user = $userModel::findIdentity($this->user_id);
            return ($user && isset($user)) ? $user->username : Comments::getInstance()->deletedUserName;

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