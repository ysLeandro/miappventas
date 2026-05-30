<?php

use app\models\Actor;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var app\models\ActorSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Actores');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="actor-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (!Yii::$app->user->isGuest): ?>
        <p>
            <?= Html::a(Yii::t('app', 'Create Actor'), ['create'], ['class' => 'btn btn-success']) ?>
        </p>
    <?php endif; ?>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'idactor',
            'nombres',
            'apellidos',
            'biografia',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Actor $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'idactor' => $model->idactor]);
                },
                // Controlamos la visibilidad de los botones en la tabla de Actores
                'visibleButtons' => [
                    // El botón de ver detalle lo pueden usar todos
                    'view' => true, 
                    
                    // Modificar solo si el usuario está logueado y es admin
                    'update' => function ($model, $key, $index) {
                        return !Yii::$app->user->isGuest && Yii::$app->user->identity->role == 'admin';
                    },
                    
                    // Eliminar solo si el usuario está logueado y es admin
                    'delete' => function ($model, $key, $index) {
                        return !Yii::$app->user->isGuest && Yii::$app->user->identity->role == 'admin';
                    },
                ],
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
