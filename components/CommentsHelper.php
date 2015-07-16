<?php

namespace yeesoft\comments\components;

use Yii;
use yii\web\Cookie;

class CommentsHelper
{

    public static function setCookies(array $cookies)
    {
        foreach ($cookies as $key => $value) {
            $cookie = new Cookie([
                'name' => $key,
                'value' => $value,
                'expire' => time() + 86400 * 365,
            ]);

            Yii::$app->getResponse()->getCookies()->add($cookie);
        }
    }
}