<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Director $model */

$this->title = $model->iddirector;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Directores'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="director-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php if (!Yii::$app->user->isGuest && Yii::$app->user->identity->role == 'admin'): ?>
            <?= Html::a(Yii::t('app', 'Update'), ['update', 'iddirector' => $model->iddirector], ['class' => 'btn btn-primary']) ?>
            <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'iddirector' => $model->iddirector], [
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
            // Convertimos 'iddirector' en un array para controlar su visibilidad de forma condicional
            [
                'attribute' => 'iddirector',
                'visible' => !Yii::$app->user->isGuest && Yii::$app->user->identity->role == 'admin',
            ],
            'nombre',
            'apellido',
            'fecha_nacimiento',
        ],
    ]) ?>

</div>
