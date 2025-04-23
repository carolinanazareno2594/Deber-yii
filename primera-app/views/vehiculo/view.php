<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Vehiculo */

$this->title = $model->modelo->marca->nombre . ' ' . $model->modelo->nombre . ' (' . $model->año . ')';
$this->params['breadcrumbs'][] = ['label' => 'Vehículos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vehiculo-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->id_vehiculo], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->id_vehiculo], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Está seguro de eliminar este vehículo?',
                'method' => 'post',
            ],
        ]) ?>
        <?php if ($model->disponible): ?>
            <?= Html::a('Registrar Venta', ['/venta/create', 'id_vehiculo' => $model->id_vehiculo], ['class' => 'btn btn-success']) ?>
        <?php endif; ?>
        <?= Html::a('Volver', ['index'], ['class' => 'btn btn-default']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id_vehiculo',
            [
                'attribute' => 'id_modelo',
                'value' => $model->modelo->marca->nombre . ' ' . $model->modelo->nombre,
                'label' => 'Modelo',
            ],
            'vin',
            'año',
            'color',
            'kilometraje',
            [
                'attribute' => 'precio',
                'value' => '$' . number_format($model->precio, 2),
            ],
            [
                'attribute' => 'disponible',
                'format' => 'raw',
                'value' => $model->disponible 
                    ? '<span class="label label-success">Disponible</span>' 
                    : '<span class="label label-danger">Vendido</span>',
            ],
            'descripcion:ntext',
            [
                'attribute' => 'imagen_url',
                'format' => 'html',
                'value' => function ($model) {
                    return $model->imagen_url ? Html::img($model->imagen_url, ['width' => '300px']) : 'Sin imagen';
                },
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
    
    <?php if (!$model->disponible && !empty($model->ventas)): ?>
        <h3>Información de Venta</h3>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Cliente</th>
                        <th>Precio de Venta</th>
                        <th>Método de Pago</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($model->ventas as $venta): ?>
                    <tr>
                        <td><?= Yii::$app->formatter->asDate($venta->fecha_venta, 'php:d/m/Y') ?></td>
                        <td><?= Html::encode($venta->cliente->nombreCompleto) ?></td>
                        <td>$<?= number_format($venta->precio_venta, 2) ?></td>
                        <td><?= Html::encode($venta->metodo_pago) ?></td>
                        <td>
                            <span class="label label-<?= $venta->estado == 'Completada' ? 'success' : ($venta->estado == 'Pendiente' ? 'warning' : 'danger') ?>">
                                <?= Html::encode($venta->estado) ?>
                            </span>
                        </td>
                        <td>
                            <?= Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['/venta/view', 'id' => $venta->id_venta], ['title' => 'Ver', 'data-toggle' => 'tooltip']) ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>

</div>
