<?php

use common\models\Adminuser;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\AdminuserSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Adminusers';
$this->params['breadcrumbs'][] = $this->title;
?>
<!--<head><link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"></head>-->


<div class="adminuser-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Adminuser', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            'id',
            //'username',
            'nickname',
            //'password',
            'email:email',
            //'profile:ntext',
            //'auth_key',
            //'password_hash',
            //'password_reset_token',
            [
                'class' => ActionColumn::className(),
                'template' =>'{view} {update} {resetpwd} {privilege}',
                'buttons' => [
                        'resetpwd' => function ($url, $model, $key)
                        {
                            $options = [
                                    'title' => Yii::t('app', 'Reset Password'),
                                    'aria-label' => Yii::t('app', 'Reset Password'),
                                    'data-pjax' => '0',
                            ];
                            return Html::a('<span class="green">密码重置</span>', $url, $options);

                        },
                    'privilege' => function ($url, $model, $key)
                    {
                        $options = [
                                'title' => Yii::t('app', 'Privilege'),
                                'aria-label' => Yii::t('app', 'Privilege'),
                                'data-pjax' => '0',
                        ];
                        return Html::a('<span class="red">权限</span>', $url, $options);
                    }
                ],
                'urlCreator' => function ($action, Adminuser $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>

<!-- 首先，引入jQuery和Popper.js，Bootstrap 4需要它们 -->
<!--<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>-->
<!--<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>-->
<!-- 然后，引入Bootstrap JS -->
<!--<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>-->