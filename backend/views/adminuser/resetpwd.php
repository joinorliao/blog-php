  <?php

use yii\helpers\Html;
  use yii\widgets\ActiveForm;

  /** @var yii\web\View $this */
/** @var common\models\Adminuser $model */

$this->title = '重置密码';
$this->params['breadcrumbs'][] = ['label' => 'Adminusers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="adminuser-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password_repeat')->textInput(['maxlength' => true]) ?>


    <div class="form-group">
        <?= Html::submitButton('修改', ['class' =>  'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
