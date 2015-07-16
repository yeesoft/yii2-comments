<?php

namespace yeesoft\comments;

use Yii;

class Module extends \yii\base\Module
{
    /**
     * Path to default avatar image
     */
    const DEFAULT_AVATAR = '/images/user.png';

    public $controllerNamespace = 'yeesoft\comments\controllers';
    public $maxNestedLevel       = 5;
    public $onlyRegistered       = false;
    public $orderDirection       = SORT_DESC;
    public $nestedOrderDirection = SORT_ASC;
    // public $showWebsiteField = true;
    public $usernameRegexp       = '/^(\w|\d)+$/';
    public $usernameBlackRegexp  = '/^(.)*admin(.)*$/i';
    public $userAvatar;
    public $userModel            = 'yeesoft\usermanagement\models\User';
    public $commentsAssetUrl;



    //public $controllerNamespace = '';

    /**
     * Options for captcha
     *
     * @var array
     */
    public $captchaOptions = [
        'class' => 'yii\captcha\CaptchaAction',
        'minLength' => 4,
        'maxLength' => 6,
        'offset' => 5
    ];

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
    }

    public function renderUserAvatar($user_id)
    {
        $this->userAvatar = Module::getInstance()->userAvatar;
        if ($this->userAvatar === null) {
            return $this->commentsAssetUrl.Module::DEFAULT_AVATAR;
        } elseif (is_string($this->userAvatar)) {
            return $this->userAvatar;
        } else {
            return call_user_func($this->userAvatar, $user_id);
        }
    }
}