<?php

use yii\helpers\ArrayHelper;
use yii\widgets\ListView;
use yii\widgets\Pjax;
use yeesoft\comments\Comments;

/* @var $this yii\web\View */
/* @var $model yeesoft\comments\models\Comment */
?>

<?php $containerClass = (ArrayHelper::getValue($dataProvider->query->where, 'parent_id')) ? 'sub-comments' : 'comments'; ?>

<?php
if ($comment) {
    Pjax::begin();

    echo ListView::widget([
        'dataProvider' => $dataProvider,
        'emptyText' => Comments::t('comments', 'No Comments'),
        'itemView' => function ($model, $key, $index, $widget) use ($comment, $nested_level) {
            return $this->render('item', compact('model', 'widget', 'comment', 'nested_level'));
        },
        'options' => ['class' => $containerClass],
        'itemOptions' => ['class' => 'comment'],
        'layout' => '{items}<div class="text-center">{pager}</div>',
        'pager' => [
            'class' => yii\widgets\LinkPager::className(),
            'options' => ['class' => 'pagination pagination-sm'],
        ],
    ]);

    Pjax::end();
}