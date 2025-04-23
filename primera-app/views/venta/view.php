<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Venta */

$this->title = 'Venta #' . $model->id_venta;
$this->params['breadcrumbs'][] = ['label' => 'Ventas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="venta-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->id_venta], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->id_venta], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Está seguro de eliminar esta venta? El vehículo volverá a estar disponible.',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Volver', ['index'], ['class' => 'btn btn-default']) ?>
    </p>

    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">Información de la Venta</h3>
                </div>
                <div class="panel-body">
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'id_venta',
                            [
                                'attribute' => 'fecha_venta',
                                'format' => ['date', 'php:d/m/Y'],
                            ],
                            [
                                'attribute' => 'precio_venta',
                                'value' => '$' . number_format($model->precio_venta, 2),
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
                            'notas:ntext',
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
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Información del Vehículo</h3>
                </div>
                <div class="panel-body">
                    <?= DetailView::widget([
                        'model' => $model->vehiculo,
                        'attributes' => [
                            [
                                'label' => 'Vehículo',
                                'value' => $model->vehiculo->modelo->marca->nombre . ' ' . 
                                          $model->vehiculo->modelo->nombre . ' (' . 
                                          $model->vehiculo->año . ')',
                            ],
                            'color',
                            'vin',
                            'kilometraje',
                            [
                                'attribute' => 'precio',
                                'value' => '$' . number_format($model->vehiculo->precio, 2),
                            ],
                        ],
                    ]) ?>
                    
                    <?= Html::a('Ver Detalles del Vehículo', ['/vehiculo/view', 'id' => $model->id_vehiculo], ['class' => 'btn btn-info btn-block']) ?>
                </div>
            </div>
            
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title">Información del Cliente</h3>
                </div>
                <div class="panel-body">
                    <?= DetailView::widget([
                        'model' => $model->cliente,
                        'attributes' => [
                            [
                                'label' => 'Nombre Completo',
                                'value' => $model->cliente->nombre . ' ' . $model->cliente->apellido,
                            ],
                            'email:email',
                            'telefono',
                            'ciudad',
                        ],
                    ]) ?>
                    
                    <?= Html::a('Ver Perfil del Cliente', ['/cliente/view', 'id' => $model->id_cliente], ['class' => 'btn btn-success btn-block']) ?>
                </div>
            </div>
        </div>
    </div>

</div>
