<?php

namespace app\controllers;

use Yii;
use app\models\Cliente;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ClienteController implementa las acciones CRUD para el modelo Cliente.
 */
class ClienteController extends Controller
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
     * Lista todos los modelos Cliente.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Cliente::find(),
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'defaultOrder' => [
                    'apellido' => SORT_ASC,
                    'nombre' => SORT_ASC,
                ]
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Muestra un único modelo Cliente.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException si el modelo no puede ser encontrado
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        
        $ventasDataProvider = new ActiveDataProvider([
            'query' => $model->getVentas()->with(['vehiculo', 'vehiculo.modelo', 'vehiculo.modelo.marca']),
            'pagination' => [
                'pageSize' => 5,
            ],
            'sort' => [
                'defaultOrder' => [
                    'fecha_venta' => SORT_DESC,
                ]
            ],
        ]);
        
        return $this->render('view', [
            'model' => $model,
            'ventasDataProvider' => $ventasDataProvider,
        ]);
    }

    /**
     * Crea un nuevo modelo Cliente.
     * Si la creación es exitosa, el navegador redirigirá a la página 'view'.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Cliente();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Cliente creado correctamente.');
            return $this->redirect(['view', 'id' => $model->id_cliente]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Actualiza un modelo Cliente existente.
     * Si la actualización es exitosa, el navegador redirigirá a la página 'view'.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException si el modelo no puede ser encontrado
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Cliente actualizado correctamente.');
            return $this->redirect(['view', 'id' => $model->id_cliente]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Elimina un modelo Cliente existente.
     * Si la eliminación es exitosa, el navegador redirigirá a la página 'index'.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException si el modelo no puede ser encontrado
     */
    public function actionDelete($id)
    {
        try {
            $this->findModel($id)->delete();
            Yii::$app->session->setFlash('success', 'Cliente eliminado correctamente.');
        } catch (\Exception $e) {
            Yii::$app->session->setFlash('error', 'No se puede eliminar este cliente porque tiene ventas asociadas.');
        }

        return $this->redirect(['index']);
    }

    /**
     * Encuentra el modelo Cliente basado en el valor de su llave primaria.
     * Si no se encuentra el modelo, se lanza una excepción 404 HTTP.
     * @param integer $id
     * @return Cliente el modelo cargado
     * @throws NotFoundHttpException si el modelo no puede ser encontrado
     */
    protected function findModel($id)
    {
        if (($model = Cliente::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('La página solicitada no existe.');
    }
}
