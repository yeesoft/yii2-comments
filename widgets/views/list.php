<?php

use yii\widgets\ListView;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use yeesoft\comments\models\Comment;

/* @var $this yii\web\View */
/* @var $model yeesoft\comments\models\Comment */
?>

<?php
$containerClass = (ArrayHelper::getValue($dataProvider->query->where,
        'parent_id')) ? 'sub-comments' : 'comments';
?>

<?php
if ($comment) {
    echo ListView::widget([
        'dataProvider' => $dataProvider,
        'emptyText' => 'No Comments',
        'itemView' => function ($model, $key, $index, $widget) use ($comment, $nested_level) {
        return $this->render('item',
                compact('model', 'widget', 'comment', 'nested_level'));
    },
        'options' => ['class' => $containerClass],
        'itemOptions' => ['class' => 'comment'],
        'layout' => "{items}{pager}"
    ]);
}
?>
