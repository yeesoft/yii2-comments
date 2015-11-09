<?php

namespace yeesoft\comments\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Controller;

class DefaultController extends Controller
{

    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'get-form' => ['post'],
                ],
            ],
        ]);
    }

    /**
     * Render reply form by AJAX request
     *
     * @return string
     */
    public function actionGetForm()
    {
        $reply_to = (int)Yii::$app->getRequest()->post('reply_to');
        return $this->renderAjax('get-form', compact('reply_to'));
    }
}