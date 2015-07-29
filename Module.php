<?php

namespace yeesoft\comments;

/**
 * Comments Module For Yii2
 *
 * @author Taras Makitra <taras.makitra@gmail.com>
 */
class Module extends \yii\base\Module
{
    /**
     * Path to default avatar image
     */
    const DEFAULT_AVATAR = '/images/user.png';

    /**
     *  Comments Module controller namespace
     *
     * @var string
     */
    public $controllerNamespace = 'yeesoft\comments\controllers';

    /**
     *  User model class name
     *
     * @var string
     */
    public $userModel = 'yii\web\User';

    /**
     * Maximum allowed nested level for comment's replies
     *
     * @var int
     */
    public $maxNestedLevel = 5;

    /**
     *  Indicates whether not registered users can leave a comment
     *
     * @var boolean
     */
    public $onlyRegistered = FALSE;

    /**
     * Comments order direction
     *
     * @var int const
     */
    public $orderDirection = SORT_DESC;

    /**
     * Replies order direction
     *
     * @var int const
     */
    public $nestedOrderDirection = SORT_ASC;

    /**
     * The field for displaying user avatars.
     *
     * Is this field is NULL default avatar image will be displayed. Also it
     * can specify path to image or use callable type.
     *
     * If this property is specified as a callback, it should have the following signature:
     *
     * ~~~
     * function ($user_id)
     * ~~~
     *
     * Example of module settings :
     * ~~~
     * 'comments' => [
     *       'class' => 'yeesoft\comments\Module',
     *       'userAvatar' => function($user_id){
     *           return User::getUserAvatarByID($user_id);
     *       }
     *   ]
     * ~~~
     * @var string|callable
     */
    public $userAvatar;

    /**
     * Comments asset url
     *
     * @var string
     */
    public $commentsAssetUrl;

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
     * Render user avatar by UserID according to $userAvatar setting
     *
     * @param int $user_id
     * @return string
     */
    public function renderUserAvatar($user_id)
    {
        $this->userAvatar = Module::getInstance()->userAvatar;
        if ($this->userAvatar === null) {
            return $this->commentsAssetUrl . Module::DEFAULT_AVATAR;
        } elseif (is_string($this->userAvatar)) {
            return $this->userAvatar;
        } else {
            return call_user_func($this->userAvatar, $user_id);
        }
    }
}