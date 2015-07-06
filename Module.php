<?php

namespace yeesoft\comments;

use Yii;

class Module extends \yii\base\Module
{
    public $onlyRegistered      = false;
    public $showEmailField      = true;
    public $showWebsiteField    = true;
    public $usernameRegexp      = '/^(\w|\d)+$/';
    public $usernameBlackRegexp = '/^(.)*admin(.)*$/i';

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

}