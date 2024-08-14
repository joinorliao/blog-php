<?php

use common\models\Post;
use common\models\Poststatus;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\PostSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Posts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('创建文章', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
            [
                    'attribute'=>'id',
                'contentOptions'=>['style'=>'width: 35px;'],
            ],
            'title',
            [
                    'attribute'=>'authorName',
                'value'=> 'author.nickname',
            ],
            [
                    'attribute'=>'status',
                    'value'=>'status0.name',
                    'filter'=>Poststatus::find()
                        ->select(['name','id'])
                        ->orderBy('position')
                        ->indexBy('id')
                        ->column(),
            ],
            [
                    'attribute'=>'update_time',
                    'format'=> ['date','php:Y-m-d H:i:s'],

            ],
            'tags:ntext',
            //'create_time:datetime',
            //'update_time:datetime',
            //'author_id',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Post $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
