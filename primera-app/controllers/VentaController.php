<?php

namespace app\controllers;

use Yii;
use app\models\Venta;
use app\models\Vehiculo;
use app\models\Cliente;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * VentaController implementa las acciones CRUD para el modelo Venta.
 */
class VentaController extends Controller
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
     * Lista todos los modelos Venta.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Venta::find()->with(['vehiculo', 'vehiculo.modelo', 'vehiculo.modelo.marca', 'cliente']),
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'defaultOrder' => [
                    'fecha_venta' => SORT_DESC,
                ]
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Muestra un único modelo Venta.
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
     * Crea un nuevo modelo Venta.
     * Si la creación es exitosa, el navegador redirigirá a la página 'view'.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Venta();
        $model->fecha_venta = date('Y-m-d');
        $model->estado = 'Completada';

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Venta registrada correctamente.');
            return $this->redirect(['view', 'id' => $model->id_venta]);
        }

        $vehiculos = ArrayHelper::map(
            Vehiculo::find()
                ->where(['disponible' => true])
                ->joinWith(['modelo', 'modelo.marca'])
                ->orderBy(['marcas.nombre' => SORT_ASC, 'modelos.nombre' => SORT_ASC])
                ->all(), 
            'id_vehiculo', 
            function($model) {
                return $model->getNombreCompleto() . ' - $' . number_format($model->precio, 2);
            }
        );
        
        $clientes = ArrayHelper::map(
            Cliente::find()
                ->orderBy(['apellido' => SORT_ASC, 'nombre' => SORT_ASC])
                ->all(), 
            'id_cliente', 
            'nombreCompleto'
        );
        
        $metodosPago = Venta::getMetodosPago();
        $estados = Venta::getEstados();

        return $this->render('create', [
            'model' => $model,
            'vehiculos' => $vehiculos,
            'clientes' => $clientes,
            'metodosPago' => $metodosPago,
            'estados' => $estados,
        ]);
    }

    /**
     * Actualiza un modelo Venta existente.
     * Si la actualización es exitosa, el navegador redirigirá a la página 'view'.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException si el modelo no puede ser encontrado
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Venta actualizada correctamente.');
            return $this->redirect(['view', 'id' => $model->id_venta]);
        }

        // Para actualización incluimos el vehículo actual aunque ya no esté disponible
        $vehiculos = ArrayHelper::map(
            Vehiculo::find()
                ->where(['or', ['disponible' => true], ['id_vehiculo' => $model->id_vehiculo]])
                ->joinWith(['modelo', 'modelo.marca'])
                ->orderBy(['marcas.nombre' => SORT_ASC, 'modelos.nombre' => SORT_ASC])
                ->all(), 
            'id_vehiculo', 
            function($model) {
                return $model->getNombreCompleto() . ' - $' . number_format($model->precio, 2);
            }
        );
        
        $clientes = ArrayHelper::map(
            Cliente::find()
                ->orderBy(['apellido' => SORT_ASC, 'nombre' => SORT_ASC])
                ->all(), 
            'id_cliente', 
            'nombreCompleto'
        );
        
        $metodosPago = Venta::getMetodosPago();
        $estados = Venta::getEstados();

        return $this->render('update', [
            'model' => $model,
            'vehiculos' => $vehiculos,
            'clientes' => $clientes,
            'metodosPago' => $metodosPago,
            'estados' => $estados,
        ]);
    }

    /**
     * Elimina un modelo Venta existente.
     * Si la eliminación es exitosa, el navegador redirigirá a la página 'index'.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException si el modelo no puede ser encontrado
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $vehiculo = $model->vehiculo;
        
        if ($model->delete()) {
            // Si se elimina la venta, marcamos el vehículo como disponible nuevamente
            $vehiculo->disponible = true;
            $vehiculo->save(false);
            Yii::$app->session->setFlash('success', 'Venta eliminada correctamente y vehículo marcado como disponible.');
        }

        return $this->redirect(['index']);
    }

    /**
     * Encuentra el modelo Venta basado en el valor de su llave primaria.
     * Si no se encuentra el modelo, se lanza una excepción 404 HTTP.
     * @param integer $id
     * @return Venta el modelo cargado
     * @throws NotFoundHttpException si el modelo no puede ser encontrado
     */
    protected function findModel($id)
    {
        if (($model = Venta::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('La página solicitada no existe.');
    }
}
