<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Director;
use app\models\Actor;
use app\models\Genero;

/** @var yii\web\View $this */
/** @var app\models\Pelicula $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="pelicula-form">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>

    <?php if($model->portada): ?>

    <div class="form-group">

        <?= Html::label('Imagen Actual') ?>

        <div>
            <?= Html::img(
                Yii::getAlias('@web') . '/portadas/' . $model->portada,['style' => 'width: 200px']) ?>
        </div>

    </div>

    <?php endif; ?>

    <?php //$form->field($model, 'portada')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'imageFile')->fileInput()->label('Selecionar Portada') ?>

    <?= $form->field($model, 'titulo')->textInput(['maxlength' => true, 'placeholder'=>'Titulo de la pelicula', 'required'=>true]) ?>

    <?= $form->field($model, 'sipnopsis')->textarea(['maxlength' => 255,'placeholder'=>'Escriba aqui la sinopsis...', 'required'=>true]) ?>

    <?= $form->field($model, 'anio')->input('number',['min'=>1900,'max'=>date('Y')]) 

                                    ->textInput(['pattern'=>'\d{4}','title'=>'Debe ser un año de5 digitos','placeholder'=>'YYYY','required'=>true])?>
    <?= $form->field($model, 'duracion')->input('text')
                                        ->textInput(['placeholder'=>'00:00:00','pattern'=>'^([0-1]?[0-9]|2[0-3]):[0-5][0-9]:[0-5][0-9]$','title'=>'Formato requerido: HH:MM:SS','required'=>true]) ?>

    <?= $form->field($model, 'director_iddirector')->dropDownList(ArrayHelper::map(Director::find()->select(['iddirector','CONCAT(apellido, " ", nombre) AS nombre_completo'])
                                                                                                ->orderBy('apellido')
                                                                                                ->asArray()
                                                                                                ->all(), 'iddirector','nombre_completo'), ['prompt'=>'Seleccione un director', 'required'=>true]) 
    ?>

    <?= $form->field($model, 'actores_ids')->dropDownList(ArrayHelper::map(Actor::find()->select(['idactor','CONCAT(apellidos, " ", nombres) AS nombre_completo'])
                                                                                                ->orderBy('apellidos')
                                                                                                ->asArray()
                                                                                                ->all(), 'idactor','nombre_completo'), ['prompt'=>'Seleccione un actor', 'required'=>true]) 
    ?>

    <?= $form->field($model, 'generos_ids')->dropDownList(ArrayHelper::map(Genero::find()->select(['idgenero','nombre'])
                                                                                                ->orderBy('nombre')
                                                                                                ->asArray()
                                                                                                ->all(), 'idgenero','nombre'), ['prompt'=>'Seleccione un género', 'required'=>true]) 
    ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>