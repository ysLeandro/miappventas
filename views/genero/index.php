<?php

use app\models\Genero;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var app\models\GeneroSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Generos');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="genero-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (!Yii::$app->user->isGuest): ?>
        <p>
            <?= Html::a(Yii::t('app', 'Create Genero'), ['create'], ['class' => 'btn btn-success']) ?>
        </p>
    <?php endif; ?>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'idgenero',
            'nombre',
            'descripcion',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Genero $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'idgenero' => $model->idgenero]);
                },
                // Controlamos la visibilidad de los botones de acción para Géneros
                'visibleButtons' => [
                    // Ver el género lo puede hacer cualquiera
                    'view' => true, 
                    
                    // Editar solo si el usuario inició sesión y tiene rol de admin
                    'update' => function ($model, $key, $index) {
                        return !Yii::$app->user->isGuest && Yii::$app->user->identity->role == 'admin';
                    },
                    
                    // Eliminar solo si el usuario inició sesión y tiene rol de admin
                    'delete' => function ($model, $key, $index) {
                        return !Yii::$app->user->isGuest && Yii::$app->user->identity->role == 'admin';
                    },
                ],
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
