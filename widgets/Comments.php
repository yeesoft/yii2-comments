<?php

namespace yeesoft\comments\widgets;

use yeesoft\comments\assets\CommentsAsset;
use yeesoft\comments\components\CommentsHelper;
use yeesoft\comments\models\Comment;
use yeesoft\comments\Module;
use Yii;
use yii\base\Model;

class Comments extends \yii\base\Widget
{
    public $model;
    public $model_id = 0;

    public function init()
    {
        parent::init();

        if ($this->model instanceof Model) {
            $this->model_id = $this->model->id;
            $this->model = $this->model->tableName();
        }
    }

    public function run()
    {
        $commentsAsset = CommentsAsset::register($this->getView());
        Module::getInstance()->commentsAssetUrl = $commentsAsset->baseUrl;

        $model = $this->model;
        $model_id = $this->model_id;

        $comment = new Comment(compact('model', 'model_id'));
        $comment->scenario = (Yii::$app->user->isGuest) ? Comment::SCENARIO_GUEST : Comment::SCENARIO_USER;

        if (!Module::getInstance()->onlyRegistered && $comment->load(Yii::$app->getRequest()->post())) {

            if ($comment->validate() && $comment->save()) {

                if (Yii::$app->user->isGuest) {
                    CommentsHelper::setCookies([
                        'username' => $comment->username,
                        'email' => $comment->email,
                    ]);
                }

                return Yii::$app->getResponse()->redirect(Yii::$app->request->referrer);
            }
        }

        return $this->render('comments', compact('model', 'model_id', 'comment'));
    }
}