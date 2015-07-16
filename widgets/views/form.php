<?php

use Yii;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yeesoft\comments\Module;
use yeesoft\comments\assets\CommentsAsset;

/* @var $this yii\web\View */
/* @var $modelyeesoft\comments\models\Comment */
?>

<?php
$commentsAsset                          = CommentsAsset::register($this);
Module::getInstance()->commentsAssetUrl = $commentsAsset->baseUrl;

$formID     = 'comment-form'.(($comment->parent_id) ? '-'.$comment->parent_id : '');
$replyClass = ($comment->parent_id) ? 'comment-form-reply' : '';
?>

<div class="comment-form <?= $replyClass ?> clearfix">

    <?php
    $form       = ActiveForm::begin([
            'action' => NULL,
            'validateOnBlur' => FALSE,
            'validationUrl' => Url::to('comments/validate'),
            'id' => $formID,
            'class' => 'com-form'
    ]);

    if ($comment->parent_id) {
        echo $form->field($comment, 'parent_id')->hiddenInput()->label(false);
    }
    ?>

    <div class="avatar">
        <img src="<?= Module::getInstance()->renderUserAvatar(Yii::$app->user->id) ?>"/>
    </div>
    <div class="comment-fields">

        <div class="row">
            <div class="col-lg-12">
                <?=
                $form->field($comment, 'content')->textarea([
                    'class' => 'form-control input-sm',
                    'placeholder' => 'Share your thoughts...'
                ])->label(false);
                ?>
            </div>
        </div>

        <div class="comment-fields-more">
            <div class="buttons text-right">
                <?=
                Html::submitButton('Cancel',
                    ['class' => 'btn btn-default btn-sm reply-cancel'])
                ?>
                <?=
                Html::submitButton(($comment->parent_id) ? 'Reply' : 'Post',
                    ['class' => 'btn btn-primary btn-sm'])
                ?>
            </div>
            <div class="fields">
                <div class="row">
                    <?php if (Yii::$app->user->isGuest): ?>
                        <div class="col-lg-6">
                            <?=
                            $form->field($comment, 'username',
                                ['enableAjaxValidation' => true])->textInput([
                                'maxlength' => true,
                                'class' => 'form-control input-sm',
                                'placeholder' => 'Your name'
                            ])->label(false)
                            ?>
                        </div>
                        <div class="col-lg-6">
                            <?=
                            $form->field($comment, 'email')->textInput([
                                'maxlength' => true,
                                'email' => true,
                                'class' => 'form-control input-sm',
                                'placeholder' => 'Your email'
                            ])->label(false)
                            ?>
                        </div>
                    <?php else: ?>
                        <div class="col-lg-6">
                            <?=
                            (($comment->parent_id) ? 'Reply as ' : 'Post as ').
                            '<b>'.Yii::$app->user->username.'</b>';
                            ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    </div>

    <?php ActiveForm::end(); ?>

</div>


<?php
//if (Yii::$app->getRequest()->post()) {
//$options    = Json::htmlEncode($form->getClientOptions());
//$attributes = Json::htmlEncode($form->attributes);
//\yii\widgets\ActiveFormAsset::register($this);
//$this->registerJs("jQuery('#$formID').yiiActiveForm($attributes, $options);");
//}
?>


