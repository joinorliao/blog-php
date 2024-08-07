<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Adminuser $model */

$this->title = 'Create Adminuser';
$this->params['breadcrumbs'][] = ['label' => 'Adminusers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="adminuser-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
