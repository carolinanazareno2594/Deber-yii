<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Cliente */

$this->title = $model->nombre . ' ' . $model->apellido;
$this->params['breadcrumbs'][] = ['label' => 'Clientes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cliente-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->id_cliente], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->id_cliente], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Está seguro de eliminar este cliente?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Registrar Venta', ['/venta/create', 'id_cliente' => $model->id_cliente], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Volver', ['index'], ['class' => 'btn btn-default']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id_cliente',
            'nombre',
            'apellido',
            'email:email',
            'telefono',
            'direccion',
            'ciudad',
            [
                'attribute' => 'fecha_registro',
                'format' => ['date', 'php:d/m/Y'],
            ],
            [
                'attribute' => 'created_at',
                'format' => ['date', 'php:d/m/Y H:i:s'],
            ],
            [
                'attribute' => 'updated_at',
                'format' => ['date', 'php:d/m/Y H:i:s'],
            ],
        ],
    ]) ?>
    
    <h3>Historial de Compras</h3>
    
    <?= GridView::widget([
        'dataProvider' => $ventasDataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'fecha_venta',
                'format' => ['date', 'php:d/m/Y'],
            ],
            [
                'attribute' => 'id_vehiculo',
                'value' => function ($model) {
                    return $model->vehiculo->modelo->marca->nombre . ' ' . 
                           $model->vehiculo->modelo->nombre . ' (' . 
                           $model->vehiculo->año . ')';
                },
                'label' => 'Vehículo',
            ],
            [
                'attribute' => 'precio_venta',
                'value' => function ($model) {
                    return '$' . number_format($model->precio_venta, 2);
                },
            ],
            'metodo_pago',
            [
                'attribute' => 'estado',
                'format' => 'raw',
                'value' => function ($model) {
                    $class = 'label label-';
                    switch ($model->estado) {
                        case 'Completada':
                            $class .= 'success';
                            break;
                        case 'Pendiente':
                            $class .= 'warning';
                            break;
                        case 'Cancelada':
                            $class .= 'danger';
                            break;
                        default:
                            $class .= 'default';
                    }
                    return '<span class="' . $class . '">' . Html::encode($model->estado) . '</span>';
                },
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['/venta/view', 'id' => $model->id_venta], [
                            'title' => 'Ver detalles de la venta',
                            'data-toggle' => 'tooltip',
                        ]);
                    },
                ],
            ],
        ],
    ]); ?>

</div>
