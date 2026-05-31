<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Director $model */

// Mostramos el nombre y apellido en la cabecera en lugar de un ID frío
$this->title = $model->nombre . ' ' . $model->apellido;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Directores'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="director-view container my-4 text-white">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold m-0 text-white"><?= Html::encode($this->title) ?></h1>
        
        <div class="d-flex gap-2">
            <?php if (!Yii::$app->user->isGuest && Yii::$app->user->identity->role == 'admin'): ?>
                <?= Html::a(Yii::t('app', 'Update'), ['update', 'iddirector' => $model->iddirector], ['class' => 'btn btn-primary fw-bold px-3']) ?>
                <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'iddirector' => $model->iddirector], [ // ◄--- ¡Corregido aquí! Ya usa iddirector
                    'class' => 'btn btn-danger fw-bold px-3',
                    'data' => [
                        'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                        'method' => 'post',
                    ],
                ]) ?>
            <?php endif; ?>
        </div>
    </div>

    <div class="card border-0 p-4 shadow-lg" style="background: #141a29; border-radius: 12px; border: 1px solid #1f293d !important;">
        
        <?= DetailView::widget([
            'model' => $model,
            'options' => [
                'class' => 'table m-0 text-white',
                'style' => 'background-color: transparent !important; color: #ffffff !important;'
            ],
            'attributes' => [
                // Tu campo condicional original con transparencia forzada
                [
                    'attribute' => 'iddirector',
                    'visible' => !Yii::$app->user->isGuest && Yii::$app->user->identity->role == 'admin',
                    'captionOptions' => [
                        'style' => 'width: 250px; color: #0087ff; font-weight: 600; background-color: transparent !important; border-bottom: 1px solid #1f293d; font-size: 16px;'
                    ],
                    'contentOptions' => [
                        'style' => 'color: #8892b0; font-weight: bold; background-color: transparent !important; border-bottom: 1px solid #1f293d; font-size: 16px;'
                    ],
                ],
                [
                    'attribute' => 'nombre',
                    'captionOptions' => [
                        'style' => 'color: #0087ff; font-weight: 600; background-color: transparent !important; border-bottom: 1px solid #1f293d; font-size: 16px;'
                    ],
                    'contentOptions' => [
                        'style' => 'color: #ffffff; font-weight: 500; background-color: transparent !important; border-bottom: 1px solid #1f293d; font-size: 16px;'
                    ],
                ],
                [
                    'attribute' => 'apellido',
                    'captionOptions' => [
                        'style' => 'color: #0087ff; font-weight: 600; background-color: transparent !important; border-bottom: 1px solid #1f293d; font-size: 16px;'
                    ],
                    'contentOptions' => [
                        'style' => 'color: #ffffff; font-weight: 500; background-color: transparent !important; border-bottom: 1px solid #1f293d; font-size: 16px;'
                    ],
                ],
                [
                    'attribute' => 'fecha_nacimiento',
                    'captionOptions' => [
                        'style' => 'color: #0087ff; font-weight: 600; background-color: transparent !important; border-bottom: 0; font-size: 16px;'
                    ],
                    'contentOptions' => [
                        'style' => 'color: #ced4da; background-color: transparent !important; border-bottom: 0; font-size: 16px;'
                    ],
                ],
            ],
        ]) ?>
        
    </div>

</div>