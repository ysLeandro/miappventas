<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pelicula_has_actor".
 *
 * @property int $fk_idpelicula
 * @property int $fk_idactor
 *
 * @property Actor $fkIdactor
 * @property Pelicula $fkIdpelicula
 */
class PeliculaHasActor extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pelicula_has_actor';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fk_idpelicula', 'fk_idactor'], 'required'],
            [['fk_idpelicula', 'fk_idactor'], 'integer'],
            [['fk_idpelicula', 'fk_idactor'], 'unique', 'targetAttribute' => ['fk_idpelicula', 'fk_idactor']],
            [['fk_idactor'], 'exist', 'skipOnError' => true, 'targetClass' => Actor::class, 'targetAttribute' => ['fk_idactor' => 'idactor']],
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
            'fk_idactor' => Yii::t('app', 'Fk Idactor'),
        ];
    }

    /**
     * Gets query for [[FkIdactor]].
     *
     * @return \yii\db\ActiveQuery|ActorQuery
     */
    public function getFkIdactor()
    {
        return $this->hasOne(Actor::class, ['idactor' => 'fk_idactor']);
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
     * @return PeliculaHasActorQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PeliculaHasActorQuery(get_called_class());
    }

}
