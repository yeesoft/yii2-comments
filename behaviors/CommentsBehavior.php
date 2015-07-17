<?php

namespace yeesoft\comments\behaviors;

use yii\base\Behavior;
use yeesoft\comments\widgets\Comments;

/**
 * Comments Behavior
 *
 * Render comments and form for owner model
 *
 */
class CommentsBehavior extends Behavior
{

    /**
     *
     * @return string the rendering result of the Comments Widget for owner model
     */
    public function displayComments()
    {
        return Comments::widget(['model' => $this->owner]);
    }
}