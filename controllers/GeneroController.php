<?php

namespace app\controllers;

use Yii;
use app\models\Genero;
use app\models\GeneroSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * GeneroController implements the CRUD actions for Genero model.
 */
class GeneroController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => \yii\filters\AccessControl::class,
                    'only' => ['index', 'view', 'create', 'update', 'delete'],
                    'rules' => [
                        // 1. Cualquier persona (invitado o logueado) puede ver la lista y el detalle de géneros
                        [
                            'allow' => true,
                            'actions' => ['index', 'view'],
                            'roles' => ['?', '@'],
                        ],
                        // 2. Cualquier usuario logueado puede crear un nuevo género cinematográfico
                        [
                            'allow' => true,
                            'actions' => ['create'],
                            'roles' => ['@'],
                        ],
                        // 3. Solo el administrador tiene permisos para modificar o eliminar géneros
                        [
                            'allow' => true,
                            'actions' => ['update', 'delete'],
                            'roles' => ['@'],
                            'matchCallback' => function ($rule, $action) {
                                return Yii::$app->user->identity->role == 'admin';
                            }
                        ],
                    ],
                ],
                'verbs' => [
                    'class' => \yii\filters\VerbFilter::class,
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Genero models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new GeneroSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Genero model.
     * @param int $idgenero Idgenero
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($idgenero)
    {
        return $this->render('view', [
            'model' => $this->findModel($idgenero),
        ]);
    }

    /**
     * Creates a new Genero model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Genero();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'idgenero' => $model->idgenero]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Genero model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $idgenero Idgenero
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($idgenero)
    {
        $model = $this->findModel($idgenero);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'idgenero' => $model->idgenero]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Genero model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $idgenero Idgenero
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($idgenero)
    {
        $model = $this->findModel($idgenero);

        // 🛡️ Iniciamos una transacción segura para la base de datos
        $transaction = Yii::$app->db->beginTransaction();

        try {
            // 🍿 1. Rompemos la relación en la tabla intermedia usando el campo correcto: fk_idgenero
            Yii::$app->db->createCommand()
                ->delete('pelicula_has_genero', ['fk_idgenero' => $idgenero])
                ->execute();

            // 💥 2. Ahora que ninguna película depende de este género, lo borramos con seguridad
            $model->delete();

            // Confirmamos la operación
            $transaction->commit();

        } catch (\Exception $e) {
            // Si algo sale mal, revertimos todo para proteger el sistema
            $transaction->rollBack();
            throw $e;
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the Genero model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $idgenero Idgenero
     * @return Genero the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($idgenero)
    {
        if (($model = Genero::findOne(['idgenero' => $idgenero])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
