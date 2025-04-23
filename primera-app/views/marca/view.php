<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Marca */

$this->title = $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Marcas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="marca-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->id_marca], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->id_marca], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Está seguro de eliminar esta marca?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Volver', ['index'], ['class' => 'btn btn-default']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id_marca',
            'nombre',
            'pais_origen',
            [
                'attribute' => 'fecha_fundacion',
                'format' => ['date', 'php:d/m/Y'],
            ],
            [
                'attribute' => 'logo_url',
                'format' => 'html',
                'value' => function ($model) {
                    return $model->logo_url ? Html::img($model->logo_url, ['width' => '200px']) : 'Sin logo';
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
    
    <h3>Modelos de esta marca</h3>
    
    <?php if (!empty($model->modelos)): ?>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Año Inicio</th>
                        <th>Tipo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($model->modelos as $modelo): ?>
                    <tr>
                        <td><?= Html::encode($modelo->nombre) ?></td>
                        <td><?= Html::encode($modelo->año_inicio) ?></td>
                        <td><?= Html::encode($modelo->tipo) ?></td>
                        <td>
                            <?= Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['/modelo/view', 'id' => $modelo->id_modelo], ['title' => 'Ver', 'data-toggle' => 'tooltip']) ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-info">Esta marca no tiene modelos registrados.</div>
    <?php endif; ?>

</div>
