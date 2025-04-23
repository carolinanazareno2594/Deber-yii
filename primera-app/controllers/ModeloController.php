<?php

namespace app\controllers;

use Yii;
use app\models\Modelo;
use app\models\Marca;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * ModeloController implementa las acciones CRUD para el modelo Modelo.
 */
class ModeloController extends Controller
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
     * Lista todos los modelos Modelo.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Modelo::find()->with('marca'),
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
     * Muestra un único modelo Modelo.
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
     * Crea un nuevo modelo Modelo.
     * Si la creación es exitosa, el navegador redirigirá a la página 'view'.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Modelo();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Modelo creado correctamente.');
            return $this->redirect(['view', 'id' => $model->id_modelo]);
        }

        $marcas = ArrayHelper::map(Marca::find()->orderBy('nombre')->all(), 'id_marca', 'nombre');

        return $this->render('create', [
            'model' => $model,
            'marcas' => $marcas,
        ]);
    }

    /**
     * Actualiza un modelo Modelo existente.
     * Si la actualización es exitosa, el navegador redirigirá a la página 'view'.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException si el modelo no puede ser encontrado
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Modelo actualizado correctamente.');
            return $this->redirect(['view', 'id' => $model->id_modelo]);
        }

        $marcas = ArrayHelper::map(Marca::find()->orderBy('nombre')->all(), 'id_marca', 'nombre');

        return $this->render('update', [
            'model' => $model,
            'marcas' => $marcas,
        ]);
    }

    /**
     * Elimina un modelo Modelo existente.
     * Si la eliminación es exitosa, el navegador redirigirá a la página 'index'.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException si el modelo no puede ser encontrado
     */
    public function actionDelete($id)
    {
        try {
            $this->findModel($id)->delete();
            Yii::$app->session->setFlash('success', 'Modelo eliminado correctamente.');
        } catch (\Exception $e) {
            Yii::$app->session->setFlash('error', 'No se puede eliminar este modelo porque tiene vehículos asociados.');
        }

        return $this->redirect(['index']);
    }

    /**
     * Encuentra el modelo Modelo basado en el valor de su llave primaria.
     * Si no se encuentra el modelo, se lanza una excepción 404 HTTP.
     * @param integer $id
     * @return Modelo el modelo cargado
     * @throws NotFoundHttpException si el modelo no puede ser encontrado
     */
    protected function findModel($id)
    {
        if (($model = Modelo::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('La página solicitada no existe.');
    }
}
