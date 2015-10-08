<?php

namespace yeesoft\comments\components;

use yeesoft\comments\models\Comment;
use Yii;
use yii\web\Cookie;

class CommentsHelper
{

    /**
     * Set cookies using associative array
     *
     * @param array $cookies cookies to set
     */
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

    /**
     * Generate settings for comments caching
     *
     * @param string $model comment's model name
     * @param int $model_id comment's model id
     * @param int $duration
     * @return array
     */
    public static function getCacheProperties($model, $model_id = '', $duration = 3600)
    {
        $tableName = Comment::tableName();

        return [
            'duration' => $duration,
            'dependency' => [
                'class' => 'yii\caching\DbDependency',
                'sql' => "SELECT COUNT(*) FROM {$tableName} "
                    . "WHERE `model` = '{$model}' AND `model_id` = '{$model_id}'",
            ]
        ];
    }

    /**
     * Generate config for comment's reply
     *
     * @param \yeesoft\comments\models\Comment $comment
     * @return array
     */
    public static function getReplyConfig(Comment $comment)
    {
        $model = $comment->model;
        $model_id = $comment->model_id;
        $parent_id = $comment->id;

        return compact('model', 'model_id', 'parent_id');
    }
}