<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Modelo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="modelo-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_marca')->dropDownList($marcas, ['prompt' => 'Seleccione una marca...']) ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'año_inicio')->input('number') ?>

    <?= $form->field($model, 'año_fin')->input('number') ?>

    <?= $form->field($model, 'tipo')->dropDownList([
        'Sedan' => 'Sedan',
        'SUV' => 'SUV',
        'Hatchback' => 'Hatchback',
        'Deportivo' => 'Deportivo',
        'Pickup' => 'Pickup',
        'Minivan' => 'Minivan',
        'Coupé' => 'Coupé',
        'Convertible' => 'Convertible',
        'Otro' => 'Otro'
    ], ['prompt' => 'Seleccione un tipo...']) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
        <?= Html::a('Cancelar', ['index'], ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
