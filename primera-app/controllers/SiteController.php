<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        // Cargar modelos para estadísticas
        $totalVehiculos = (new \yii\db\Query())
            ->from('vehiculos')
            ->count();
            
        $vehiculosDisponibles = (new \yii\db\Query())
            ->from('vehiculos')
            ->where(['disponible' => true])
            ->count();
            
        $totalVentas = (new \yii\db\Query())
            ->from('ventas')
            ->count();
            
        $totalClientes = (new \yii\db\Query())
            ->from('clientes')
            ->count();
            
        $totalMarcas = (new \yii\db\Query())
            ->from('marcas')
            ->count();
            
        $ultimasVentas = (new \yii\db\Query())
            ->select(['v.id_venta', 'v.fecha_venta', 'v.precio_venta', 'c.nombre', 'c.apellido', 'm.nombre as marca', 'mo.nombre as modelo', 've.año'])
            ->from(['v' => 'ventas'])
            ->innerJoin(['c' => 'clientes'], 'v.id_cliente = c.id_cliente')
            ->innerJoin(['ve' => 'vehiculos'], 'v.id_vehiculo = ve.id_vehiculo')
            ->innerJoin(['mo' => 'modelos'], 've.id_modelo = mo.id_modelo')
            ->innerJoin(['m' => 'marcas'], 'mo.id_marca = m.id_marca')
            ->orderBy(['v.fecha_venta' => SORT_DESC])
            ->limit(5)
            ->all();
            
        return $this->render('index', [
            'totalVehiculos' => $totalVehiculos,
            'vehiculosDisponibles' => $vehiculosDisponibles,
            'totalVentas' => $totalVentas,
            'totalClientes' => $totalClientes,
            'totalMarcas' => $totalMarcas,
            'ultimasVentas' => $ultimasVentas,
        ]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
