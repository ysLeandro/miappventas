<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Actor $model */

$this->title = $model->idactor;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Actores'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="actor-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php if (!Yii::$app->user->isGuest && Yii::$app->user->identity->role == 'admin'): ?>
            <?= Html::a(Yii::t('app', 'Update'), ['update', 'idactor' => $model->idactor], ['class' => 'btn btn-primary']) ?>
            <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'idactor' => $model->idactor], [
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
            // Convertimos 'idactor' en un array para controlar su visibilidad de forma condicional
            [
                'attribute' => 'idactor',
                'visible' => !Yii::$app->user->isGuest && Yii::$app->user->identity->role == 'admin',
            ],
            'nombres',
            'apellidos',
            'biografia',
        ],
    ]) ?>

</div>
