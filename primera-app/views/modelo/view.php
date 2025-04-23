<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Modelo */

$this->title = $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Modelos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="modelo-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->id_modelo], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->id_modelo], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Está seguro de eliminar este modelo?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Volver', ['index'], ['class' => 'btn btn-default']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id_modelo',
            [
                'attribute' => 'id_marca',
                'value' => $model->marca->nombre,
                'label' => 'Marca',
            ],
            'nombre',
            'año_inicio',
            'año_fin',
            'tipo',
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
    
    <h3>Vehículos de este modelo</h3>
    
    <?php if (!empty($model->vehiculos)): ?>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Año</th>
                        <th>Color</th>
                        <th>Precio</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($model->vehiculos as $vehiculo): ?>
                    <tr>
                        <td><?= Html::encode($vehiculo->año) ?></td>
                        <td><?= Html::encode($vehiculo->color) ?></td>
                        <td>$<?= number_format($vehiculo->precio, 2) ?></td>
                        <td>
                            <span class="label label-<?= $vehiculo->disponible ? 'success' : 'danger' ?>">
                                <?= $vehiculo->disponible ? 'Disponible' : 'Vendido' ?>
                            </span>
                        </td>
                        <td>
                            <?= Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['/vehiculo/view', 'id' => $vehiculo->id_vehiculo], ['title' => 'Ver', 'data-toggle' => 'tooltip']) ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-info">Este modelo no tiene vehículos registrados.</div>
    <?php endif; ?>

</div>
