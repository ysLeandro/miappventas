<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "director".
 *
 * @property int $iddirector
 * @property string $nombre
 * @property string $apellido
 * @property string|null $fecha_nacimiento
 *
 * @property Pelicula[] $peliculas
 */
class Director extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'director';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fecha_nacimiento'], 'default', 'value' => null],
            [['nombre', 'apellido'], 'required'],
            [['fecha_nacimiento'], 'safe'],
            [['nombre', 'apellido'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'iddirector' => Yii::t('app', 'Iddirector'),
            'nombre' => Yii::t('app', 'Nombre'),
            'apellido' => Yii::t('app', 'Apellido'),
            'fecha_nacimiento' => Yii::t('app', 'Fecha Nacimiento'),
        ];
    }

    /**
     * Gets query for [[Peliculas]].
     *
     * @return \yii\db\ActiveQuery|PeliculaQuery
     */
    public function getPeliculas()
    {
        return $this->hasMany(Pelicula::class, ['director_iddirector' => 'iddirector']);
    }

    /**
     * {@inheritdoc}
     * @return DirectorQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new DirectorQuery(get_called_class());
    }

}
