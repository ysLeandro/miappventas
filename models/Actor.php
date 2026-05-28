<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "actor".
 *
 * @property int $idactor
 * @property string $nombres
 * @property string $apellidos
 * @property string|null $biografia
 *
 * @property Pelicula[] $fkIdpeliculas
 * @property PeliculaHasActor[] $peliculaHasActors
 */
class Actor extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'actor';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['biografia'], 'default', 'value' => null],
            [['nombres', 'apellidos'], 'required'],
            [['nombres', 'apellidos', 'biografia'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idactor' => Yii::t('app', 'Idactor'),
            'nombres' => Yii::t('app', 'Nombres'),
            'apellidos' => Yii::t('app', 'Apellidos'),
            'biografia' => Yii::t('app', 'Biografia'),
        ];
    }

    /**
     * Gets query for [[FkIdpeliculas]].
     *
     * @return \yii\db\ActiveQuery|PeliculaQuery
     */
    public function getFkIdpeliculas()
    {
        return $this->hasMany(Pelicula::class, ['idpelicula' => 'fk_idpelicula'])->viaTable('pelicula_has_actor', ['fk_idactor' => 'idactor']);
    }

    /**
     * Gets query for [[PeliculaHasActors]].
     *
     * @return \yii\db\ActiveQuery|PeliculaHasActorQuery
     */
    public function getPeliculaHasActors()
    {
        return $this->hasMany(PeliculaHasActor::class, ['fk_idactor' => 'idactor']);
    }

    /**
     * {@inheritdoc}
     * @return ActorQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ActorQuery(get_called_class());
    }

}
