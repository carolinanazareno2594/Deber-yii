<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Vehículos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vehiculo-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Crear Vehículo', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'id_modelo',
                'value' => function ($model) {
                    return $model->modelo->marca->nombre . ' ' . $model->modelo->nombre;
                },
                'label' => 'Modelo',
            ],
            'año',
            'color',
            [
                'attribute' => 'precio',
                'value' => function ($model) {
                    return '$' . number_format($model->precio, 2);
                },
            ],
            [
                'attribute' => 'disponible',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->disponible 
                        ? '<span class="label label-success">Disponible</span>' 
                        : '<span class="label label-danger">Vendido</span>';
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
                            'data-confirm' => '¿Está seguro de eliminar este vehículo?',
                            'data-method' => 'post',
                        ]);
                    },
                ],
            ],
        ],
    ]); ?>

</div>
