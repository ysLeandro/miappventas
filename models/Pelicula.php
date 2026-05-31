<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "pelicula".
 *
 * @property int $idpelicula
 * @property string|null $portada
 * @property string|null $titulo
 * @property string|null $sipnopsis
 * @property int|null $anio
 * @property string|null $duracion
 * @property int $director_iddirector
 */
class Pelicula extends \yii\db\ActiveRecord
{
    public $imageFile;

    // Propiedades virtuales añadidas para capturar las selecciones de los desplegables
    public $actores_ids;
    public $generos_ids;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pelicula';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['portada', 'titulo', 'sipnopsis', 'anio', 'duracion'], 'default', 'value' => null],

            [['anio', 'director_iddirector'], 'integer'],

            // Hacemos obligatorios los actores y géneros antes de guardar
            [['director_iddirector', 'actores_ids', 'generos_ids'], 'required'],

            [['portada','sipnopsis', 'duracion'], 'string', 'max' => 255],
            [['titulo'], 'string', 'max' => 100],

            // Permitir procesar las variables de los desplegables de forma segura
            [['actores_ids', 'generos_ids'], 'safe'],

            [['director_iddirector'], 'exist',
                'skipOnError' => true,
                'targetClass' => Director::class,
                'targetAttribute' => ['director_iddirector' => 'iddirector']
            ],

            [['imageFile'], 'file',
                'skipOnEmpty' => true,
                'extensions' => 'png, jpg, jpeg'
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idpelicula' => Yii::t('app', 'Idpelicula'),
            'portada' => Yii::t('app', 'Portada'),
            'titulo' => Yii::t('app', 'Titulo'),
            'sipnopsis' => Yii::t('app', 'Sipnopsis'),
            'anio' => Yii::t('app', 'Año'),
            'duracion' => Yii::t('app', 'Duracion'),
            'director_iddirector' => Yii::t('app', 'Director'),
            'actores_ids' => Yii::t('app', 'Actor'),
            'generos_ids' => Yii::t('app', 'Género'),
        ];
    }

    /**
     * Carga automáticamente los valores actuales al momento de editar
     */
    public function afterFind()
    {
        parent::afterFind();
        // Tomamos el primer registro de la tabla puente para pintarlo en el desplegable único
        $this->actores_ids = ArrayHelper::getColumn($this->peliculaHasActors, 'fk_idactor');
        $this->generos_ids = ArrayHelper::getColumn($this->peliculaHasGeneros, 'fk_idgenero');
    }

    /**
     * Registra los ID seleccionados en tus tablas intermedias puente
     */
    public function saveRelaciones()
    {
        // 1. Limpiamos relaciones previas en caso de actualización
        PeliculaHasActor::deleteAll(['fk_idpelicula' => $this->idpelicula]);
        PeliculaHasGenero::deleteAll(['fk_idpelicula' => $this->idpelicula]);

        // 2. Guardar el actor seleccionado en el dropDown
        if (!empty($this->actores_ids)) {
            $relacionActor = new PeliculaHasActor();
            $relacionActor->fk_idpelicula = $this->idpelicula;
            $relacionActor->fk_idactor = $this->actores_ids;
            $relacionActor->save(false);
        }

        // 3. Guardar el género seleccionado en el dropDown
        if (!empty($this->generos_ids)) {
            $relacionGenero = new PeliculaHasGenero();
            $relacionGenero->fk_idpelicula = $this->idpelicula;
            $relacionGenero->fk_idgenero = $this->generos_ids;
            $relacionGenero->save(false);
        }
    }

    public function upload()
    {
        if (!$this->validate()) {

            print_r($this->errors);
            return false;
        }

        if ($this->imageFile instanceof UploadedFile) {

            $folder = Yii::getAlias('@webroot/portadas/');

            // Crear carpeta si no existe
            if (!file_exists($folder)) {
                mkdir($folder, 0777, true);
            }

            $filename =
                $this->idpelicula .
                '_' .
                date('Ymd_His') .
                '.' .
                $this->imageFile->extension;

            $path = $folder . $filename;

            // Guardar imagen
            if ($this->imageFile->saveAs($path)) {

                // Eliminar portada anterior
                if ($this->portada && $this->portada !== $filename) {
                    $this->deletePortada();
                }

                // Guardar nombre en BD
                $this->portada = $filename;

                return $this->save(false);

            } else {

                echo "No se pudo guardar la imagen";
                return false;
            }
        }

        return true;
    }

    public function deletePortada()
    {
        $path = Yii::getAlias('@webroot/portadas/') . $this->portada;

        if (file_exists($path)) {
            unlink($path);
        }
    }

    /**
     * Gets query for [[DirectorIddirector]].
     */
    public function getDirectorIddirector()
    {
        return $this->hasOne(Director::class, ['iddirector' => 'director_iddirector']);
    }

    /**
     * Gets query for [[FkIdactors]].
     */
    public function getFkIdactors()
    {
        return $this->hasMany(
            Actor::class,
            ['idactor' => 'fk_idactor']
        )->viaTable(
            'pelicula_has_actor',
            ['fk_idpelicula' => 'idpelicula']
        );
    }

    /**
     * Gets query for [[FkIdgeneros]].
     */
    public function getFkIdgeneros()
    {
        return $this->hasMany(
            Genero::class,
            ['idgenero' => 'fk_idgenero']
        )->viaTable(
            'pelicula_has_genero',
            ['fk_idpelicula' => 'idpelicula']
        );
    }

    /**
     * Gets query for [[PeliculaHasActors]].
     */
    public function getPeliculaHasActors()
    {
        return $this->hasMany(
            PeliculaHasActor::class,
            ['fk_idpelicula' => 'idpelicula']
        );
    }

    /**
     * Gets query for [[PeliculaHasGeneros]].
     */
    public function getPeliculaHasGeneros()
    {
        return $this->hasMany(
            PeliculaHasGenero::class,
            ['fk_idpelicula' => 'idpelicula']
        );
    }

    /**
     * {@inheritdoc}
     */
    public static function find()
    {
        return new PeliculaQuery(get_called_class());
    }
}