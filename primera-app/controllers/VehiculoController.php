<?php

namespace app\controllers;

use Yii;
use app\models\Vehiculo;
use app\models\Modelo;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * VehiculoController implementa las acciones CRUD para el modelo Vehiculo.
 */
class VehiculoController extends Controller
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
     * Lista todos los modelos Vehiculo.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Vehiculo::find()->with(['modelo', 'modelo.marca']),
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'defaultOrder' => [
                    'id_vehiculo' => SORT_DESC,
                ]
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Muestra un único modelo Vehiculo.
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
     * Crea un nuevo modelo Vehiculo.
     * Si la creación es exitosa, el navegador redirigirá a la página 'view'.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Vehiculo();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Vehículo creado correctamente.');
            return $this->redirect(['view', 'id' => $model->id_vehiculo]);
        }

        $modelos = ArrayHelper::map(
            Modelo::find()
                ->joinWith('marca')
                ->orderBy(['marcas.nombre' => SORT_ASC, 'modelos.nombre' => SORT_ASC])
                ->all(), 
            'id_modelo', 
            function($model) {
                return $model->marca->nombre . ' ' . $model->nombre;
            }
        );

        return $this->render('create', [
            'model' => $model,
            'modelos' => $modelos,
        ]);
    }

    /**
     * Actualiza un modelo Vehiculo existente.
     * Si la actualización es exitosa, el navegador redirigirá a la página 'view'.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException si el modelo no puede ser encontrado
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Vehículo actualizado correctamente.');
            return $this->redirect(['view', 'id' => $model->id_vehiculo]);
        }

        $modelos = ArrayHelper::map(
            Modelo::find()
                ->joinWith('marca')
                ->orderBy(['marcas.nombre' => SORT_ASC, 'modelos.nombre' => SORT_ASC])
                ->all(), 
            'id_modelo', 
            function($model) {
                return $model->marca->nombre . ' ' . $model->nombre;
            }
        );

        return $this->render('update', [
            'model' => $model,
            'modelos' => $modelos,
        ]);
    }

    /**
     * Elimina un modelo Vehiculo existente.
     * Si la eliminación es exitosa, el navegador redirigirá a la página 'index'.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException si el modelo no puede ser encontrado
     */
    public function actionDelete($id)
    {
        try {
            $this->findModel($id)->delete();
            Yii::$app->session->setFlash('success', 'Vehículo eliminado correctamente.');
        } catch (\Exception $e) {
            Yii::$app->session->setFlash('error', 'No se puede eliminar este vehículo porque tiene ventas asociadas.');
        }

        return $this->redirect(['index']);
    }

    /**
     * Encuentra el modelo Vehiculo basado en el valor de su llave primaria.
     * Si no se encuentra el modelo, se lanza una excepción 404 HTTP.
     * @param integer $id
     * @return Vehiculo el modelo cargado
     * @throws NotFoundHttpException si el modelo no puede ser encontrado
     */
    protected function findModel($id)
    {
        if (($model = Vehiculo::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('La página solicitada no existe.');
    }
}
