<?php

use yii\timeago\TimeAgo;
use yeesoft\comments\Module;
use yeesoft\comments\widgets\CommentsList;
use yeesoft\comments\widgets\CommentsForm;

/* @var $this yii\web\View */
/* @var $model yeesoft\comments\models\Comment */

$this->title = 'Comments';
?>

<?php if (!Module::getInstance()->onlyRegistered): ?>
    <div class="comments-main-form">
        <?= CommentsForm::widget(); ?>
    </div>
<?php endif; ?>

<?php if ($this->beginCache('comment'.$model.$model_id)) : ?>

    <div class="comments">
        <?= CommentsList::widget(compact('model', 'model_id', 'comment')); ?>
    </div>

    <?php $this->endCache(); ?>
<?php else: ?>
    <?php TimeAgo::widget(); ?>
<?php endif; ?>

