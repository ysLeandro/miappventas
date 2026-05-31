<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\ArrayHelper;

/** @var yii\web\View $this */
/** @var app\models\Pelicula $model */

$this->title = $model->titulo ? $model->titulo : "Detalle de la Película";
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Peliculas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="pelicula-view container my-4">

    <div class="movie-detail-box">
        
        <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom border-secondary border-opacity-25">
            <h1 class="movie-detail-title"><?= Html::encode($this->title) ?></h1>
            
            <div class="action-buttons">
                <?php if (!Yii::$app->user->isGuest && Yii::$app->user->identity->role == 'admin'): ?>
                    <?= Html::a(Yii::t('app', 'Update'), ['update', 'idpelicula' => $model->idpelicula], ['class' => 'btn btn-primary btn-sm px-3 me-2 fw-bold']) ?>
                    <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'idpelicula' => $model->idpelicula], [
                        'class' => 'btn btn-danger btn-sm px-3 fw-bold',
                        'data' => [
                            'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                            'method' => 'post',
                        ],
                    ]) ?>
                <?php endif; ?>
            </div>
        </div>

        <div class="row g-4">
            
            <div class="col-12 col-md-4 text-center border-end border-secondary border-opacity-25 d-flex flex-column align-items-center justify-content-center">
                <?php if ($model->portada): ?>
                    <div class="movie-poster-frame shadow">
                        <?= Html::img(
                            Yii::getAlias('@web') . '/portadas/' . $model->portada,
                            ['class' => 'img-fluid']
                        ) ?>
                    </div>
                <?php else: ?>
                    <div class="d-flex align-items-center justify-content-center movie-poster-frame text-muted p-5" style="width: 200px; height: 280px;">
                        <span>Sin Portada</span>
                    </div>
                <?php endif; ?>
                
                <span class="badge bg-dark border border-secondary mt-3 px-3 py-2 fs-6">ID: <?= $model->idpelicula ?></span>
            </div>

            <div class="col-12 col-md-8">
                <div class="table-responsive">
                    
                    <?= DetailView::widget([
                        'model' => $model,
                        'options' => ['class' => 'table table-borderless m-0 align-middle'],
                        'attributes' => [
                            [
                                'attribute' => 'idpelicula',
                                'visible' => !Yii::$app->user->isGuest && Yii::$app->user->identity->role == 'admin',
                            ],
                            [
                                'attribute' => 'titulo',
                                'label' => 'Título Original',
                                'contentOptions' => ['class' => 'text-info fw-bold fs-5'],
                            ],
                            [
                                'attribute' => 'sipnopsis',
                                'label' => 'Sinopsis',
                                'format' => 'ntext',
                                'contentOptions' => ['class' => 'movie-synopsis-style'],
                            ],
                            [
                                'attribute' => 'anio',
                                'label' => 'Año de Lanzamiento',
                                'contentOptions' => ['class' => 'fw-bold'],
                            ],
                            [
                                'attribute' => 'duracion',
                                'label' => 'Duración',
                                'value' => function($model) {
                                    return $model->duracion ? $model->duracion . ' min' : '(No registrada)';
                                },
                                'contentOptions' => ['class' => 'text-warning fw-bold'],
                            ],
                            [
                                'attribute' => 'director_iddirector',
                                'label' => 'Director',
                                'value' => isset($model->directorIddirector) ? $model->directorIddirector->nombre . ' ' . $model->directorIddirector->apellido : null,
                            ],
                            [
                                'label' => 'Actores',
                                'value' => !empty($model->fkIdactors) ? implode(', ', ArrayHelper::getColumn($model->fkIdactors, 'nombres')) : '(Sin actores)',
                            ],
                            [
                                'label' => 'Géneros',
                                'value' => !empty($model->fkIdgeneros) ? implode(', ', ArrayHelper::getColumn($model->fkIdgeneros, 'nombre')) : '(Sin géneros)',
                                'contentOptions' => ['class' => 'text-info fw-semibold'],
                            ],
                        ],
                    ]) ?>

                </div>
            </div>

        </div>
    </div>
</div>