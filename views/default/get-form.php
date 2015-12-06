<?php

use yeesoft\comments\Comments;
use yeesoft\comments\widgets\CommentsForm;

?>

<?php if (!Comments::getInstance()->onlyRegistered || !Yii::$app->user->isGuest): ?>
    <?= CommentsForm::widget(compact('reply_to')) ?>
<?php endif; ?>