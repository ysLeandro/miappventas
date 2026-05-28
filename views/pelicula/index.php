<?php

use app\models\Pelicula;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var app\models\PeliculaSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Peliculas');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pelicula-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Pelicula'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'idpelicula',
            //'portada',
            [
                'attribute' => 'portada',
                'format' => 'html',
                'value' => function(Pelicula $model){
                    if($model->portada)
                        return Html::img(Yii::getAlias('@web') . '/portadas/' . $model->portada, ['style' => 'width: 50px']);
                    return null;
                }
            ],
            'titulo',
            'sipnopsis',
            'anio',
            //'duracion',
            //'director_iddirector',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Pelicula $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'idpelicula' => $model->idpelicula]);
                 }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
