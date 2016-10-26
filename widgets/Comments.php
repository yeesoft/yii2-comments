<?php

namespace yeesoft\comments\widgets;

use yeesoft\comments\assets\CommentsAsset;
use yeesoft\comments\Comments as CommentModule;
use yeesoft\comments\Comments as CommentsModule;
use yeesoft\comments\components\CommentsHelper;
use yeesoft\comments\models\Comment;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

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
        CommentModule::getInstance()->commentsAssetUrl = $commentsAsset->baseUrl;

        $model = $this->model;
        $model_id = $this->model_id;

        $comment = new Comment(compact('model', 'model_id'));
        $comment->scenario = (Yii::$app->user->isGuest) ? Comment::SCENARIO_GUEST : Comment::SCENARIO_USER;

        if ((!CommentModule::getInstance()->onlyRegistered || !Yii::$app->user->isGuest) && $comment->load(Yii::$app->getRequest()->post())) {

            if ($comment->validate() && Yii::$app->getRequest()->validateCsrfToken()
                && Yii::$app->getRequest()->getCsrfToken(true) && $comment->checkSpam() &&  $comment->save()
            ) {
                if (Yii::$app->user->isGuest) {
                    CommentsHelper::setCookies([
                        'username' => $comment->username,
                        'email' => $comment->email,
                    ]);
                }

                Yii::$app->getResponse()->redirect(Yii::$app->request->referrer);
                return;
            }
        }

        $dataProvider = new ActiveDataProvider([
            'query' => Comment::find(true)->where([
                'model' => $model,
                'model_id' => $model_id,
                'parent_id' => NULL,
                'status' => Comment::STATUS_PUBLISHED,
            ]),
            'pagination' => [
                'pageSize' => CommentsModule::getInstance()->commentsPerPage,
                'pageParam' => 'comment-page',
                'pageSizeParam' => 'comments-per-page',
            ],
            'sort' => [
                'defaultOrder' => [
                    'created_at' => CommentsModule::getInstance()->orderDirection,
                ]
            ],
        ]);

        return $this->render('comments', compact('model', 'model_id', 'comment', 'dataProvider'));
    }
}