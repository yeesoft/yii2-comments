<?php

namespace yeesoft\comments\widgets;

use Yii;
use yii\web\Cookie;
use yii\helpers\HtmlPurifier;
use yeesoft\comments\models\Comment;
use yii\helpers\ArrayHelper;

class CommentsForm extends \yii\base\Widget
{
    public $reply_to;
    private $_comment;

    public function init()
    {
        parent::init();

        if (!$this->_comment) {
            $this->_comment = new Comment(['scenario' => (Yii::$app->user->isGuest)
                        ? Comment::SCENARIO_GUEST : Comment::SCENARIO_USER]);

            $post = Yii::$app->getRequest()->post();
            if ($this->_comment->load($post) &&
                ($this->reply_to == ArrayHelper::getValue($post,
                    'Comment.parent_id'))) {

                $this->_comment->validate();
            }
        }

        if ($this->reply_to) {
            $this->_comment->parent_id = $this->reply_to;
        }



        /* if($model->id == Yii::$app->getRequest()->post('Comment')['parent_id']){


          //echo '<br><br>Model ID = '.$model->id.'<br><br>';




          print_r(Yii::$app->getRequest()->post());
          echo '<br><br>';
          print_r($comment->getAttributes());

          } */
    }

    public function run()
    {
        if (Yii::$app->user->isGuest && empty($this->_comment->username)) {
            $this->_comment->username = HtmlPurifier::process(Yii::$app->getRequest()->getCookies()->getValue('username'));
        }

        if (Yii::$app->user->isGuest && empty($this->_comment->email)) {
            $this->_comment->email = HtmlPurifier::process(Yii::$app->getRequest()->getCookies()->getValue('email'));
        }

        return $this->render('form', ['comment' => $this->_comment]);
    }
}