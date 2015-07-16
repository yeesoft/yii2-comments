<?php

namespace yeesoft\comments\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yeesoft\comments\Module;
use yeesoft\comments\models\Comment;

class DefaultController extends Controller
{

    //  public $layout = '@vendor/yeesoft/yii2-comments/views/layouts/main';

    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(),
                [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'get-form' => ['post', 'get'],
                    ],
                ],
        ]);
    }

    public function actionGetForm()
    {
        $reply_to = (int) Yii::$app->getRequest()->post('reply_to');

        return $this->renderAjax('get-form', compact('reply_to'));
    }
}