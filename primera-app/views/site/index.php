<?php

/** @var yii\web\View $this */
/** @var int $totalVehiculos */
/** @var int $vehiculosDisponibles */
/** @var int $totalVentas */
/** @var int $totalClientes */
/** @var int $totalMarcas */
/** @var array $ultimasVentas */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Sistema de Gestión de Autos';
?>
<div class="site-index">

    <div class="jumbotron text-center bg-transparent mt-4 mb-4">
        <h1 class="display-4">Sistema de Gestión de Autos</h1>
        <p class="lead">Panel de control y estadísticas del sistema de gestión de ventas de vehículos</p>
    </div>

    <div class="body-content">
        <!-- Tarjetas de estadísticas -->
        <div class="row mb-4">
            <div class="col-md-4 mb-3">
                <div class="card text-white bg-primary">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-3">
                                <i class="fas fa-car fa-3x"></i>
                            </div>
                            <div class="col-9 text-right">
                                <h1><?= $totalVehiculos ?></h1>
                                <div>Vehículos Registrados</div>
                            </div>
                        </div>
                    </div>
                    <a href="<?= Url::to(['/vehiculo/index']) ?>" class="card-footer text-white clearfix small z-1">
                        <span class="float-start">Ver Detalles</span>
                        <span class="float-end">
                            <i class="fas fa-angle-right"></i>
                        </span>
                    </a>
                </div>
            </div>
            
            <div class="col-md-4 mb-3">
                <div class="card text-white bg-success">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-3">
                                <i class="fas fa-check-circle fa-3x"></i>
                            </div>
                            <div class="col-9 text-right">
                                <h1><?= $vehiculosDisponibles ?></h1>
                                <div>Vehículos Disponibles</div>
                            </div>
                        </div>
                    </div>
                    <a href="<?= Url::to(['/vehiculo/index']) ?>" class="card-footer text-white clearfix small z-1">
                        <span class="float-start">Ver Detalles</span>
                        <span class="float-end">
                            <i class="fas fa-angle-right"></i>
                        </span>
                    </a>
                </div>
            </div>
            
            <div class="col-md-4 mb-3">
                <div class="card text-white bg-warning">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-3">
                                <i class="fas fa-shopping-cart fa-3x"></i>
                            </div>
                            <div class="col-9 text-right">
                                <h1><?= $totalVentas ?></h1>
                                <div>Ventas Realizadas</div>
                            </div>
                        </div>
                    </div>
                    <a href="<?= Url::to(['/venta/index']) ?>" class="card-footer text-white clearfix small z-1">
                        <span class="float-start">Ver Detalles</span>
                        <span class="float-end">
                            <i class="fas fa-angle-right"></i>
                        </span>
                    </a>
                </div>
            </div>
        </div>
        
        <div class="row mb-4">
            <div class="col-md-6 mb-3">
                <div class="card text-white bg-info">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-3">
                                <i class="fas fa-users fa-3x"></i>
                            </div>
                            <div class="col-9 text-right">
                                <h1><?= $totalClientes ?></h1>
                                <div>Clientes Registrados</div>
                            </div>
                        </div>
                    </div>
                    <a href="<?= Url::to(['/cliente/index']) ?>" class="card-footer text-white clearfix small z-1">
                        <span class="float-start">Ver Detalles</span>
                        <span class="float-end">
                            <i class="fas fa-angle-right"></i>
                        </span>
                    </a>
                </div>
            </div>
            
            <div class="col-md-6 mb-3">
                <div class="card text-white bg-secondary">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-3">
                                <i class="fas fa-trademark fa-3x"></i>
                            </div>
                            <div class="col-9 text-right">
                                <h1><?= $totalMarcas ?></h1>
                                <div>Marcas Disponibles</div>
                            </div>
                        </div>
                    </div>
                    <a href="<?= Url::to(['/marca/index']) ?>" class="card-footer text-white clearfix small z-1">
                        <span class="float-start">Ver Detalles</span>
                        <span class="float-end">
                            <i class="fas fa-angle-right"></i>
                        </span>
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Tabla de últimas ventas -->
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        Últimas Ventas Realizadas
                    </div>
                    <div class="card-body">
                        <?php if (!empty($ultimasVentas)): ?>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>Fecha</th>
                                            <th>Cliente</th>
                                            <th>Vehículo</th>
                                            <th>Precio</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($ultimasVentas as $venta): ?>
                                            <tr>
                                                <td><?= Yii::$app->formatter->asDate($venta['fecha_venta'], 'php:d/m/Y') ?></td>
                                                <td><?= Html::encode($venta['nombre'] . ' ' . $venta['apellido']) ?></td>
                                                <td><?= Html::encode($venta['marca'] . ' ' . $venta['modelo'] . ' (' . $venta['año'] . ')') ?></td>
                                                <td><?= Yii::$app->formatter->asCurrency($venta['precio_venta']) ?></td>
                                                <td>
                                                    <?= Html::a('<i class="fas fa-eye"></i>', ['/venta/view', 'id' => $venta['id_venta']], ['class' => 'btn btn-sm btn-info', 'title' => 'Ver detalles']) ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-info">No hay ventas registradas todavía.</div>
                        <?php endif; ?>
                    </div>
                    <div class="card-footer text-center">
                        <?= Html::a('Ver todas las ventas', ['/venta/index'], ['class' => 'btn btn-primary']) ?>
                        <?= Html::a('Registrar nueva venta', ['/venta/create'], ['class' => 'btn btn-success']) ?>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Accesos directos -->
        <div class="row mb-4">
            <div class="col-md-12 text-center">
                <div class="card">
                    <div class="card-header bg-dark text-white">
                        <h4>Accesos Rápidos</h4>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-around flex-wrap">
                            <?= Html::a('<i class="fas fa-car fa-2x"></i><br>Agregar Vehículo', ['/vehiculo/create'], ['class' => 'btn btn-outline-primary m-2']) ?>
                            <?= Html::a('<i class="fas fa-user-plus fa-2x"></i><br>Nuevo Cliente', ['/cliente/create'], ['class' => 'btn btn-outline-success m-2']) ?>
                            <?= Html::a('<i class="fas fa-tags fa-2x"></i><br>Nueva Marca', ['/marca/create'], ['class' => 'btn btn-outline-info m-2']) ?>
                            <?= Html::a('<i class="fas fa-list fa-2x"></i><br>Nuevo Modelo', ['/modelo/create'], ['class' => 'btn btn-outline-warning m-2']) ?>
                            <?= Html::a('<i class="fas fa-chart-line fa-2x"></i><br>Reportes', ['/venta/index'], ['class' => 'btn btn-outline-danger m-2']) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Agregar Font Awesome para los iconos -->
<?php $this->registerJsFile('https://use.fontawesome.com/releases/v5.15.4/js/all.js', ['integrity' => 'sha384-rOA1PnstxnOBLzCLMcre8ybwbTmemjzdNlILg8O7z1lUkLXozs4DHonlDtnE7fpc', 'crossorigin' => 'anonymous']); ?>

<!-- Estilos adicionales para las tarjetas -->
<?php $this->registerCss(".card-body { padding: 15px; } .card h1 { font-size: 2.5em; margin: 0; } .text-right { text-align: right; } .card-footer { padding: .75rem 1.25rem; background-color: rgba(0,0,0,.03); border-top: 1px solid rgba(0,0,0,.125); } .card-footer:hover { background-color: rgba(0,0,0,.1); }"); ?>
