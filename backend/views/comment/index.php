<?php

use common\models\Comment;
use common\models\Commentstatus;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\CommentSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = '评论管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comment-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Comment', ['create'], ['class' => 'btn btn-success']) ?>
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

            [
                    'attribute'=>'content',
                    'format'=>'raw',
                    'value'=>function($model) {
                        $tmpStr = strip_tags($model->content);
                        $tmpLen = mb_strlen($tmpStr);
                        return mb_substr($tmpStr,0,15,'utf-8').($tmpLen>15?'...':'');
                    }
            ],
            [
                    'attribute'=>'status',
                    'value'=>'status0.name',
                    'filter'=>Commentstatus::find()
                    ->select(['name','id'])
                        ->orderBy('position')
                        ->indexBy('id')
                        ->column(),
                    'contentOptions'=>
                            function ($model) {
                                return ($model->status==1)?['class'=>'bg-danger']:['class'=>'bg-success'];
                            }
            ],
            //'create_time:datetime',
            //'userid',
            [
                    'attribute'=>'create_time',
                    'format'=>['date','php:Y-m-d H:i:s'],
            ],
            [
                    'attribute'=>'user.username',
                    'label'=>'作者',
                    'value'=>'user.username',
            ],
            'post.title',
            //'email:email',
            //'url:url',
            //'post_id',
            [
                'class' => ActionColumn::className(),
                'template'=>'{view} {update} {delete} {approve}',
                'buttons'=>
                [
                        'approve'=>function($url,$model,$key)
                        {
                            $options = [
                                    'title' => Yii::t('app','审核'),
                                    'aria-label' => Yii::t('app','审核'),
                                    'data-confirm' => Yii::t('app','确定审核通过吗？'),
                                    'data-method' => 'post',
                                    'data-pjax' => '0',
                                    'class'=>'btn btn-success'
                            ];
                            return Html::a('<span class="glyphicon glyphicon-ok"></span>', $url, $options);
                        }
                ],

                'urlCreator' => function ($action, Comment $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
