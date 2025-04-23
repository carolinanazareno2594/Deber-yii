<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Vehiculo */

$this->title = 'Actualizar Vehículo: ' . $model->modelo->marca->nombre . ' ' . $model->modelo->nombre . ' (' . $model->año . ')';
$this->params['breadcrumbs'][] = ['label' => 'Vehículos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->modelo->marca->nombre . ' ' . $model->modelo->nombre . ' (' . $model->año . ')', 'url' => ['view', 'id' => $model->id_vehiculo]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="vehiculo-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelos' => $modelos,
    ]) ?>

</div>
