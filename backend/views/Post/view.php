<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Post $model */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => '文章管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="post-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'content:ntext',
            'tags:ntext',
            [
                    'label'=>'状态',
                    'value'=>$model->status0->name,
            ],
            [
                    'attribute'=>'creat_time',
                'value' => date('Y-m-d H:i:s',$model -> create_time)
            ],
            [
                    'attribute'=>'update_time',
                'value' => date('Y-m-d H:i:s',$model -> update_time)
            ],
            [
                    //'attribute'=>'author_id',
                'label' => '作者🆔',
                'value'=> $model->author->nickname,
            ]
        ],
    ]) ?>

</div>
