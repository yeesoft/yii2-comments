<?php

namespace yeesoft\comments\assets;

use yii\web\AssetBundle;

class CommentsAsset extends AssetBundle
{
    public $sourcePath = '@vendor/yeesoft/yii2-comments/assets/source';
    public $css = [
        'css/comments.css',
    ];
    public $js = [
        'js/comments.js',
    ];
    public $depends = [
        'yii\bootstrap\BootstrapAsset',
        'yii\web\JqueryAsset',
    ];

}