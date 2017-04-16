<?php

use yeesoft\comments\Comments;
use yeesoft\comments\widgets\CommentsForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\timeago\TimeAgo;

?>
<?php if (Comments::getInstance()->displayAvatar): ?>
    <div class="avatar">
        <img src="<?= Comments::getInstance()->renderUserAvatar($model->user_id) ?>"/>
    </div>
<?php endif; ?>
<div class="comment-content<?= (Comments::getInstance()->displayAvatar) ? ' display-avatar' : '' ?>">
    <div class="comment-header">
        <a class="author"><?= Html::encode($model->getAuthor()); ?></a>
        <span class="time dot-left dot-right"><?= TimeAgo::widget(['timestamp' => $model->created_at, 'language' => Yii::$app->language]); ?></span>
    </div>
    <div class="comment-text">
        <?= Html::encode($model->content); ?>
    </div>
    <?php if ($nested_level < Comments::getInstance()->maxNestedLevel): ?>
        <div class="comment-footer">
            <?php if (!Comments::getInstance()->onlyRegistered || !Yii::$app->user->isGuest): ?>
                <a class="reply-button" data-reply-to="<?= $model->id; ?>"
                   href="#"><?= Comments::t('comments', 'Reply') ?></a>
                <!--<span class="dot-left"></span>
                <a class="glyphicon glyphicon-thumbs-up"></a> <span>0</span> &nbsp;
                <a class="glyphicon glyphicon-thumbs-down"></a> <span>0</span><span class="dot-left"></span>
                -->
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>

<?php if ($nested_level < Comments::getInstance()->maxNestedLevel): ?>
    <?php if (!Comments::getInstance()->onlyRegistered || !Yii::$app->user->isGuest): ?>
        <div class="reply-form<?= (Comments::getInstance()->displayAvatar) ? ' display-avatar' : '' ?>">
            <?php if ($model->id == ArrayHelper::getValue(Yii::$app->getRequest()->post(), 'Comment.parent_id')) : ?>
                <?= CommentsForm::widget(['reply_to' => $model->id]); ?>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($model->comments)) : ?>
        <div class="sub-comments">
            <?php $nested_level++; ?>
            <?php foreach ($model->comments as $model) : ?>
                <div class="comment">
                    <?= $this->render('comment', compact('model', 'widget', 'nested_level')) ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
<?php endif; ?>



