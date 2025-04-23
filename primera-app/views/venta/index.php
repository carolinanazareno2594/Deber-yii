<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ventas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="venta-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Registrar Venta', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
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
                'attribute' => 'id_cliente',
                'value' => function ($model) {
                    return $model->cliente->nombre . ' ' . $model->cliente->apellido;
                },
                'label' => 'Cliente',
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
                'template' => '{view} {update} {delete}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                            'title' => 'Ver',
                            'data-toggle' => 'tooltip',
                        ]);
                    },
                    'update' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                            'title' => 'Actualizar',
                            'data-toggle' => 'tooltip',
                        ]);
                    },
                    'delete' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                            'title' => 'Eliminar',
                            'data-toggle' => 'tooltip',
                            'data-confirm' => '¿Está seguro de eliminar esta venta? El vehículo volverá a estar disponible.',
                            'data-method' => 'post',
                        ]);
                    },
                ],
            ],
        ],
    ]); ?>

</div>
