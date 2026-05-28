<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pelicula_has_genero".
 *
 * @property int $fk_idpelicula
 * @property int $fk_idgenero
 *
 * @property Genero $fkIdgenero
 * @property Pelicula $fkIdpelicula
 */
class PeliculaHasGenero extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pelicula_has_genero';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fk_idpelicula', 'fk_idgenero'], 'required'],
            [['fk_idpelicula', 'fk_idgenero'], 'integer'],
            [['fk_idpelicula', 'fk_idgenero'], 'unique', 'targetAttribute' => ['fk_idpelicula', 'fk_idgenero']],
            [['fk_idgenero'], 'exist', 'skipOnError' => true, 'targetClass' => Genero::class, 'targetAttribute' => ['fk_idgenero' => 'idgenero']],
            [['fk_idpelicula'], 'exist', 'skipOnError' => true, 'targetClass' => Pelicula::class, 'targetAttribute' => ['fk_idpelicula' => 'idpelicula']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'fk_idpelicula' => Yii::t('app', 'Fk Idpelicula'),
            'fk_idgenero' => Yii::t('app', 'Fk Idgenero'),
        ];
    }

    /**
     * Gets query for [[FkIdgenero]].
     *
     * @return \yii\db\ActiveQuery|GeneroQuery
     */
    public function getFkIdgenero()
    {
        return $this->hasOne(Genero::class, ['idgenero' => 'fk_idgenero']);
    }

    /**
     * Gets query for [[FkIdpelicula]].
     *
     * @return \yii\db\ActiveQuery|PeliculaQuery
     */
    public function getFkIdpelicula()
    {
        return $this->hasOne(Pelicula::class, ['idpelicula' => 'fk_idpelicula']);
    }

    /**
     * {@inheritdoc}
     * @return PeliculaHasGeneroQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PeliculaHasGeneroQuery(get_called_class());
    }

}
