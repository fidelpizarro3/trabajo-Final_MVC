<h2 class="mb-4">Mi Carrito</h2>

<?php if (empty($items)): ?>

    <div class="alert alert-info text-center">
        <h5>Tu carrito está vacío 😕</h5>
        <a href="index.php?control=producto&accion=listar" class="btn btn-primary mt-3">
            Ver productos
        </a>
    </div>

<?php else: ?>

    <table class="table table-bordered align-middle text-center">
        <thead class="table-light">
            <tr>
                <th>Imagen</th>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Subtotal</th>
                <th>Acción</th>
            </tr>
        </thead>

        <tbody>

            <?php 
            $total = 0;

            foreach ($items as $item): 
                $total += $item["subtotal"];
            ?>

                <tr>
                    <td style="width:140px;">
                        <img src="Vistas/img/<?= $item['proimagen'] ?>" 
                             alt="" class="img-fluid rounded"
                             style="height:90px; object-fit:cover;">
                    </td>

                    <td>
                        <h5><?= ucfirst($item['pronombre']) ?></h5>
                        <small class="text-muted"><?= $item['prodetalle'] ?></small>
                    </td>

                    <td style="width:120px;">
                        <?= $item['cantidad'] ?>
                    </td>

                    <td>
                        $<?= number_format($item['subtotal'], 2) ?>
                    </td>

                    <td>
                        <a href="index.php?control=carrito&accion=quitar&id=<?= $item['idproducto'] ?>" 
                           class="btn btn-sm btn-danger">
                           Eliminar
                        </a>
                    </td>
                </tr>

            <?php endforeach; ?>

        </tbody>
    </table>


    <div class="text-end mt-4">
        <h3>Total: <strong>$<?= number_format($total, 2) ?></strong></h3>

        <a href="index.php?control=carrito&accion=vaciar" 
           class="btn btn-outline-danger mt-3">
            Vaciar carrito
        </a>

        <a href="#" class="btn btn-success mt-3">
            Finalizar compra
        </a>
    </div>

<?php endif; ?>
