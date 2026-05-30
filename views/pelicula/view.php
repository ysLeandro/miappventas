<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Pelicula $model */

$this->title = $model->idpelicula;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Peliculas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="pelicula-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php if (!Yii::$app->user->isGuest && Yii::$app->user->identity->role == 'admin'): ?>
            <?= Html::a(Yii::t('app', 'Update'), ['update', 'idpelicula' => $model->idpelicula], ['class' => 'btn btn-primary']) ?>
            <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'idpelicula' => $model->idpelicula], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ]) ?>
        <?php endif; ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // Convertimos 'idpelicula' en array para controlar su visibilidad de forma condicional
            [
                'attribute' => 'idpelicula',
                'visible' => !Yii::$app->user->isGuest && Yii::$app->user->identity->role == 'admin',
            ],
            [
                'attribute' => 'portada',
                'format' => 'html',
                'value' => function($model){
                    if ($model->portada) {
                        return Html::img(
                            Yii::getAlias('@web') . '/portadas/' . $model->portada,
                            ['style' => 'width: 100px']
                        );
                    }
                    return null;
                }
            ],
            'titulo',
            'sipnopsis',
            'anio',
            'duracion',
            [
                'attribute' => 'director_iddirector',
                'label' => 'Director',
                'value' => isset($model->directorIddirector) ? $model->directorIddirector->nombre : null,
            ],
            [
                'label' => 'Actores',
                'value' => implode(', ', yii\helpers\ArrayHelper::getColumn($model->fkIdactors, 'nombres')),
            ],
        ],
    ]) ?>

</div>