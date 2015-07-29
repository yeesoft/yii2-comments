<?php

use yeesoft\comments\components\CommentsHelper;
use yeesoft\comments\Module;
use yeesoft\comments\widgets\CommentsForm;
use yeesoft\comments\widgets\CommentsList;
use yii\helpers\ArrayHelper;
use yii\helpers\HtmlPurifier;
use yii\timeago\TimeAgo;

?>

<div class="avatar">
    <img src="<?= Module::getInstance()->renderUserAvatar($model->user_id) ?>"/>
</div>

<div class="comment-content">
    <div class="comment-header">
        <span class="author"><?= HtmlPurifier::process($model->getAuthor()); ?></span>
        <span class="time dot-left dot-right"><?= TimeAgo::widget(['timestamp' => $model->created_at]); ?></span>
    </div>
    <div class="comment-text">
        <?= HtmlPurifier::process($model->content); ?>
    </div>
    <?php if ($nested_level < Module::getInstance()->maxNestedLevel): ?>
        <div class="comment-footer">
            <?php if (!Module::getInstance()->onlyRegistered): ?>
                <a class="reply-button" data-reply-to="<?= $model->id; ?>" href="#">Reply</a>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>

<?php if ($nested_level < Module::getInstance()->maxNestedLevel): ?>
    <?php if (!Module::getInstance()->onlyRegistered): ?>
        <div class="reply-form">
            <?php if ($model->id == ArrayHelper::getValue(Yii::$app->getRequest()->post(),
                    'Comment.parent_id')
            ) :
                ?>
                <?= CommentsForm::widget(['reply_to' => $model->id]); ?>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <?php
    if ($model->isReplied()) {
        echo CommentsList::widget(ArrayHelper::merge(
            CommentsHelper::getReplyConfig($model),
            [
                "comment" => $comment,
                "nested_level" => $nested_level + 1
            ]
        )
        );
    }
    ?>
<?php endif; ?>



