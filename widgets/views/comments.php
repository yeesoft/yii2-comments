<?php

use yeesoft\comments\Comments;
use yeesoft\comments\components\CommentsHelper;
use yeesoft\comments\models\Comment;
use yeesoft\comments\widgets\CommentsForm;
use yeesoft\comments\widgets\CommentsList;
use yii\timeago\TimeAgo;

/* @var $this yii\web\View */
/* @var $model yeesoft\comments\models\Comment */
$commentsPage = Yii::$app->getRequest()->get("comment-page", 1);
$cacheKey = 'comment' . $model . $model_id . $commentsPage;
$cacheProperties = CommentsHelper::getCacheProperties($model, $model_id);

?>
<div class="comments">
    <?php if ($this->beginCache($cacheKey . '-count', $cacheProperties)) : ?>
        <h5><?= Comments::t('comments', 'All Comments') ?> (<?= Comment::activeCount($model, $model_id) ?>)</h5>
        <?php $this->endCache(); ?>
    <?php endif; ?>

    <?php if (!Comments::getInstance()->onlyRegistered || !Yii::$app->user->isGuest): ?>
        <div class="comments-main-form">
            <?= CommentsForm::widget(); ?>
        </div>
    <?php endif; ?>

    <?php if ($this->beginCache($cacheKey, $cacheProperties)) : ?>
        <?= CommentsList::widget(compact('model', 'model_id', 'comment')); ?>
        <?php $this->endCache(); ?>
    <?php else: ?>
        <?php TimeAgo::widget(); ?>
    <?php endif; ?>
</div>
