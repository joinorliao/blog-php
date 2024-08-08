<?php

use common\models\Adminuser;
use common\models\Post;
use common\models\Poststatus;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Post $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="post-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'tags')->textarea(['rows' => 6]) ?>

    <?php
    $PostStatus = Poststatus::find()->all();
    $PostStatusOptions = ArrayHelper::map($PostStatus,'id','name');

    $Authors = Adminuser::find()->all();
    $AuthorOptions = ArrayHelper::map($Authors,'id','nickname');
    ?>
    <?= $form->field($model, 'status')
            ->dropDownList($PostStatusOptions,
            ['prompt'=>'请选择状态'])?>

    <?= $form->field($model, 'author_id')
                ->dropDownList($AuthorOptions,
                ['prompt'=>'请选择作者'])?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
