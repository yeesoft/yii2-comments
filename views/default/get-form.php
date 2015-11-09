<?php

use yeesoft\comments\Comments;
use yeesoft\comments\widgets\CommentsForm;
?>

<?php if (!Comments::getInstance()->onlyRegistered): ?>
    <?= CommentsForm::widget(compact('reply_to')) ?>
<?php endif; ?>