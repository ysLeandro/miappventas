<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[PeliculaHasActor]].
 *
 * @see PeliculaHasActor
 */
class PeliculaHasActorQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return PeliculaHasActor[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return PeliculaHasActor|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
