<?php

namespace app\controllers;

use Yii;
use app\models\Marca;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MarcaController implementa las acciones CRUD para el modelo Marca.
 */
class MarcaController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lista todos los modelos Marca.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Marca::find(),
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'defaultOrder' => [
                    'nombre' => SORT_ASC,
                ]
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Muestra un único modelo Marca.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException si el modelo no puede ser encontrado
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Crea un nuevo modelo Marca.
     * Si la creación es exitosa, el navegador redirigirá a la página 'view'.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Marca();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Marca creada correctamente.');
            return $this->redirect(['view', 'id' => $model->id_marca]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Actualiza un modelo Marca existente.
     * Si la actualización es exitosa, el navegador redirigirá a la página 'view'.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException si el modelo no puede ser encontrado
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Marca actualizada correctamente.');
            return $this->redirect(['view', 'id' => $model->id_marca]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Elimina un modelo Marca existente.
     * Si la eliminación es exitosa, el navegador redirigirá a la página 'index'.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException si el modelo no puede ser encontrado
     */
    public function actionDelete($id)
    {
        try {
            $this->findModel($id)->delete();
            Yii::$app->session->setFlash('success', 'Marca eliminada correctamente.');
        } catch (\Exception $e) {
            Yii::$app->session->setFlash('error', 'No se puede eliminar esta marca porque tiene modelos asociados.');
        }

        return $this->redirect(['index']);
    }

    /**
     * Encuentra el modelo Marca basado en el valor de su llave primaria.
     * Si no se encuentra el modelo, se lanza una excepción 404 HTTP.
     * @param integer $id
     * @return Marca el modelo cargado
     * @throws NotFoundHttpException si el modelo no puede ser encontrado
     */
    protected function findModel($id)
    {
        if (($model = Marca::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('La página solicitada no existe.');
    }
}
