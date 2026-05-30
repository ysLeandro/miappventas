<?php

use app\models\Director;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var app\models\DirectorSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Directores');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="director-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (!Yii::$app->user->isGuest): ?>
        <p>
            <?= Html::a(Yii::t('app', 'Create Director'), ['create'], ['class' => 'btn btn-success']) ?>
        </p>
    <?php endif; ?>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'iddirector',
            'nombre',
            'apellido',
            'fecha_nacimiento',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Director $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'iddirector' => $model->iddirector]);
                },
                // Controlamos la visibilidad de los botones en la tabla de Directores
                'visibleButtons' => [
                    // El botón de ver detalle lo pueden usar todos (invitados y logueados)
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
