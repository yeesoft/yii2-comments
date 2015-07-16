<?php

namespace yeesoft\comments\behaviors;

use yii\base\Behavior;
use yeesoft\comments\widgets\Comments as CommentsWidget;

/**
 * Description of Comment
 *
 */
class Comments extends Behavior
{

    public function displayComments()
    {
        return CommentsWidget::widget(['model' => $this->owner]);
    }
}