<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Venta */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="venta-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'id_vehiculo')->dropDownList($vehiculos, [
                'prompt' => 'Seleccione un vehículo...',
                'options' => isset($_GET['id_vehiculo']) ? [$_GET['id_vehiculo'] => ['selected' => true]] : [],
            ]) ?>

            <?= $form->field($model, 'id_cliente')->dropDownList($clientes, [
                'prompt' => 'Seleccione un cliente...',
                'options' => isset($_GET['id_cliente']) ? [$_GET['id_cliente'] => ['selected' => true]] : [],
            ]) ?>

            <?= $form->field($model, 'fecha_venta')->input('date') ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'precio_venta')->input('number', ['step' => '0.01', 'min' => 0]) ?>

            <?= $form->field($model, 'metodo_pago')->dropDownList($metodosPago, ['prompt' => 'Seleccione un método de pago...']) ?>

            <?= $form->field($model, 'estado')->dropDownList($estados) ?>
        </div>
    </div>

    <?= $form->field($model, 'notas')->textarea(['rows' => 4]) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
        <?= Html::a('Cancelar', ['index'], ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
