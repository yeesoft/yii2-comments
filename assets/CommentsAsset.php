<?php

namespace yeesoft\comments\assets;

use yeesoft\comments\Comments;
use yii\helpers\Url;
use yii\web\AssetBundle;
use yii\web\View;

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

    /**
     * Registers this asset bundle with a view.
     * @param \yii\web\View $view the view to be registered with
     * @return static the registered asset bundle instance
     */
    public static function register($view)
    {
        $commentsModuleID = Comments::getInstance()->commentsModuleID;
        $getFormLink = Url::to(["/$commentsModuleID/default/get-form"]);
        $js = <<<JS
commentsModuleID = "$commentsModuleID";
commentsFormLink = "$getFormLink";
JS;

        $view->registerJs($js, View::POS_HEAD);

        return parent::register($view);
    }
}