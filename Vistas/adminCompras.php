<h2 class="fw-bold mb-4">Gestión de Compras</h2>

<?php if (isset($_GET["err"])): ?>
    <div class="alert alert-danger shadow-sm">
        ❌ No se puede cancelar una compra que ya fue enviada.
    </div>
<?php endif; ?>

<?php if (empty($compras)): ?>
    <div class="alert alert-info shadow-sm">
        No hay compras registradas por el momento.
    </div>

<?php else: ?>

<?php foreach ($compras as $c): ?>

<div class="card shadow-sm mb-4 border-4 rounded-3 overflow-hidden">

    <!-- HEADER -->
    <div class="p-3 bg-light border-bottom ">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="fw-bold mb-0">
                Compra #<?= $c["idcompra"] ?>
            </h5>

            <span class="badge 
                <?php 
                    switch ($c["estado"]["descripcion"]) {
                        case 'iniciada': echo 'bg-secondary'; break;
                        case 'aceptada': echo 'bg-info text-dark'; break;
                        case 'enviada': echo 'bg-success'; break;
                        case 'cancelada': echo 'bg-danger'; break;
                        default: echo 'bg-dark';
                    } 
                ?>
            fs-6 px-3 py-2">
                <?= ucfirst($c["estado"]["descripcion"]) ?>
            </span>
        </div>
    </div>

    <!-- BODY -->
    <div class="card-body">

        <div class="row">
            <!-- DATOS GENERALES -->
            <div class="col-md-6 border-end">
                <p class="mb-2"><strong>Cliente:</strong> <?= $c["usnombre"] ?></p>
                <p class="mb-2"><strong>Fecha:</strong> <?= $c["comfecha"] ?></p>
                <p class="mb-3">
                    <strong>Total:</strong> 
                    <span class="fw-bold text-success">$<?= number_format($c["comtotal"], 2, ',', '.') ?></span>
                </p>
            </div>

            <!-- ITEMS -->
            <div class="col-md-6">
                <h6 class="fw-bold border-bottom pb-2 mb-3">Productos comprados</h6>
                
                <ul class="list-group list-group-flush">
                    <?php foreach ($c["items"] as $item): ?>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>
                                <i class="bi bi-bag"></i>
                                <?= $item["pronombre"] ?>  
                                <span class="text-muted">(x<?= $item["cicantidad"] ?>)</span>
                            </span>
                            <strong>$<?= number_format($item["citprecio"], 2, ',', '.') ?></strong>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>

        <!-- BOTONES DE ESTADO -->
        <div class="mt-4 d-flex gap-2 justify-content-end">

            <?php $estado = $c["estado"]["descripcion"]; ?>

            <?php if ($estado === "iniciada"): ?>
                <a href="index.php?control=admincompra&accion=cambiarEstado&id=<?= $c["idcompra"] ?>&estado=2"
                class="btn btn-success px-4">
                    Aceptar
                </a>

                <a href="index.php?control=admincompra&accion=cambiarEstado&id=<?= $c["idcompra"] ?>&estado=4"
                class="btn btn-danger px-4">
                    Cancelar
                </a>

            <?php elseif ($estado === "aceptada"): ?>
                <a href="index.php?control=admincompra&accion=cambiarEstado&id=<?= $c["idcompra"] ?>&estado=3"
                class="btn btn-primary px-4">
                    Enviar
                </a>

                <a href="index.php?control=admincompra&accion=cambiarEstado&id=<?= $c["idcompra"] ?>&estado=4"
                class="btn btn-danger px-4">
                    Cancelar
                </a>

            <?php endif; ?>

        </div>

    </div>

</div>

<?php endforeach; ?>
<?php endif; ?>
