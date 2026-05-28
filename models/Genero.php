<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "genero".
 *
 * @property int $idgenero
 * @property string $nombre
 * @property string|null $descripcion
 *
 * @property Pelicula[] $fkIdpeliculas
 * @property PeliculaHasGenero[] $peliculaHasGeneros
 */
class Genero extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'genero';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['descripcion'], 'default', 'value' => null],
            [['nombre'], 'required'],
            [['nombre', 'descripcion'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idgenero' => Yii::t('app', 'Idgenero'),
            'nombre' => Yii::t('app', 'Nombre'),
            'descripcion' => Yii::t('app', 'Descripcion'),
        ];
    }

    /**
     * Gets query for [[FkIdpeliculas]].
     *
     * @return \yii\db\ActiveQuery|PeliculaQuery
     */
    public function getFkIdpeliculas()
    {
        return $this->hasMany(Pelicula::class, ['idpelicula' => 'fk_idpelicula'])->viaTable('pelicula_has_genero', ['fk_idgenero' => 'idgenero']);
    }

    /**
     * Gets query for [[PeliculaHasGeneros]].
     *
     * @return \yii\db\ActiveQuery|PeliculaHasGeneroQuery
     */
    public function getPeliculaHasGeneros()
    {
        return $this->hasMany(PeliculaHasGenero::class, ['fk_idgenero' => 'idgenero']);
    }

    /**
     * {@inheritdoc}
     * @return GeneroQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new GeneroQuery(get_called_class());
    }

}
