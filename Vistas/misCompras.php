<h2 class="mb-4 fw-bold">Mis compras</h2>

<?php if (empty($compras)) : ?>
    <div class="alert alert-info text-center">
        No tenés compras realizadas.
    </div>

<?php else : ?>

    <?php foreach ($compras as $c): ?>
        <div class="card mb-4 shadow-sm border-0 rounded-3">
            <div class="card-body">

                <?php 
                    $estado = isset($c["estado"]["descripcion"]) ? $c["estado"]["descripcion"] : "Sin estado";

                    $color = match($estado) {
                        "iniciada" => "warning",
                        "aceptada" => "primary",
                        "enviada" => "info",
                        "cancelada" => "danger",
                        default => "secondary"
                    };

                    $descripcionEstado = match($estado) {
                        "iniciada" => "Tu compra fue registrada y está pendiente de aprobación.",
                        "aceptada" => "Tu compra fue aceptada y está siendo preparada.",
                        "enviada" => "Tu compra fue enviada y está en camino.",
                        "cancelada" => "Tu compra fue cancelada.",
                        default => "Estado no disponible."
                    };
                ?>

                <!-- Encabezado -->
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="mb-0 fw-semibold">
                        Compra #<?= $c["idcompra"] ?>
                    </h4>

                    <span class="badge bg-<?= $color ?> px-3 py-2 text-uppercase">
                        <?= $estado ?>
                    </span>
                </div>

                <p class="text-muted mb-2"><?= $descripcionEstado ?></p>

                <p><strong>Fecha:</strong> <?= $c["comfecha"] ?></p>
                
                <p class="fs-5">
                    <strong>Total:</strong>
                    <span class="text-success">$<?= number_format($c["comtotal"], 2, ',', '.') ?></span>
                </p>

                <!-- BOTÓN SEGUIR PEDIDO -->
                <?php if ($estado === "aceptada" || $estado === "enviada"): ?>
                    <button class="btn btn-outline-primary mb-3"
                            data-bs-toggle="modal"
                            data-bs-target="#modalSeguimiento<?= $c["idcompra"] ?>">
                        📦 Seguir pedido
                    </button>
                <?php endif; ?>

                <hr>

                <!-- Lista de productos -->
                <h5 class="fw-bold mb-3">Ítems del pedido</h5>

                <ul class="list-group">
                    <?php foreach ($c["items"] as $item): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <span class="fw-semibold"><?= $item["pronombre"] ?></span>
                                <br>
                                <small class="text-muted">x<?= $item["cicantidad"] ?></small>
                            </div>

                            <span class="fw-bold">
                                $<?= number_format($item["citprecio"], 2, ',', '.') ?>
                            </span>
                        </li>
                    <?php endforeach; ?>
                </ul>

            </div>
        </div>

        <!-- MODAL SEGUIMIENTO -->
        <div class="modal fade" id="modalSeguimiento<?= $c["idcompra"] ?>" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">Seguimiento del pedido #<?= $c["idcompra"] ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <p class="fw-bold mb-3">Historial de estados:</p>

                        <ul class="list-group">
                            <?php foreach ($c["historial"] as $h): ?>
                                <?php 
                                    $colorEstado = match($h["descripcion"]) {
                                        "iniciada" => "warning",
                                        "aceptada" => "primary",
                                        "enviada" => "info",
                                        "cancelada" => "danger",
                                        default => "secondary"
                                    };
                                ?>
                                <li class="list-group-item bg-light border border-<?= $colorEstado ?>">
                                    <strong class="text-<?= $colorEstado ?>"><?= ucfirst($h["descripcion"]) ?></strong><br>
                                    <small class="text-muted">
                                        Desde: <?= $h["cefechaini"] ?><br>
                                        <?php if ($h["cefechafin"]): ?>
                                            Hasta: <?= $h["cefechafin"] ?>
                                        <?php endif; ?>
                                    </small>
                                </li>
                            <?php endforeach; ?>
                        </ul>

                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>

                </div>
            </div>
        </div>

    <?php endforeach; ?>

<?php endif; ?>
