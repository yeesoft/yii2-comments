<?php

use yeesoft\comments\Module;
use yeesoft\comments\widgets\CommentsForm;
?>

<?php if (!Module::getInstance()->onlyRegistered): ?>
    <?= CommentsForm::widget(compact('reply_to')) ?>
<?php endif; ?>