<?php

use app\models\Report;
use app\models\Role;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\Column;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\ReportSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Заявка';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="report-index">


<style>

    .ded > * {
        background-color: rgba(0, 58, 255, 0.4)  !important;
    }

    .neded > * {
        background-color: rgba(255, 0, 9, 0.4) !important;
    }
</style>

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Создать заявку', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'number',
            'description:ntext',
            'image',
            [
                'attribute' => 'image',
                'format'=> 'html',
                'value' => function($report) {
                    return '<img src="' . Url::toRoute($report->image) . '" style="width:200px" />';
                }
            
               /*
               
                'attribute' => 'image',
                'content' => function($report) {
                    return '<img src="' . Url::toRoute($report->image) . '" style="width:100px" />';
                },

               */
                
                // 'format' => ['image',['width'=>'50px','height'=>'50px']],
                // 'content' => function ($report) {
                //     return '<img src="/'.$report->image . '">';
                // }
            ],
            'user_id',
            'status',
            [
                'class' => ActionColumn::className(),
                'visible' => Yii::$app->user->identity->role_id == Role::ADMIN_ROLE_ID ? true : false,
                'template' => '{update}',
                'urlCreator' => function ($action, Report $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
        'rowOptions' => function($model, $key, $index, $column) {   
            if ($index %2 == 0) {
                return ['class' => 'ded'];
            }
            return ['class' => 'neded'];
        },
    ]); ?>


</div>
