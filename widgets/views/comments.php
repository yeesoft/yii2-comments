<?php

use yii\timeago\TimeAgo;
use yeesoft\comments\Module;
use yeesoft\comments\models\Comment;
use yeesoft\comments\widgets\CommentsList;
use yeesoft\comments\widgets\CommentsForm;
use yeesoft\comments\components\CommentsHelper;

/* @var $this yii\web\View */
/* @var $model yeesoft\comments\models\Comment */

$cacheKey        = 'comment'.$model.$model_id;
$cacheProperties = CommentsHelper::getCacheProperties($model, $model_id);

?>
<div class="comments">
    <?php if ($this->beginCache($cacheKey.'-count', $cacheProperties)) : ?>
        <h5>All Comments (<?= Comment::activeCount($model, $model_id) ?>)</h5>
        <?php $this->endCache(); ?>
    <?php endif; ?>

    <?php if (!Module::getInstance()->onlyRegistered): ?>
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
