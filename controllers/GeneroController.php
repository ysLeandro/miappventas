<?php

namespace app\controllers;

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
                'verbs' => [
                    'class' => VerbFilter::className(),
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
        $this->findModel($idgenero)->delete();

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
