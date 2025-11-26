<h2 class="mb-4">Mi Carrito</h2>

<?php if (empty($items)): ?>
    <div class="alert alert-info text-center">
        Tu carrito está vacío 
    </div>

<?php else: ?>

<?php  
$total = 0;
?>

<div class="carrito-items">

<?php foreach ($items as $item): ?>

    <?php  
        // ahora sí, item ya existe
        $total += $item["subtotal"];

        $img = "Vistas/img/" . ($item["proimagen"] ?: "sinimagen.png");
        if (!file_exists($img)) {
            $img = "https://via.placeholder.com/120x120?text=Sin+Imagen";
        }
    ?>

    <!-- ITEM -->
    <div class="d-flex align-items-center p-3 mb-3 border rounded shadow-sm">

        <img src="<?= $img ?>"
             class="rounded me-3"
             style="width:100px;height:100px;object-fit:cover;">

        <div class="flex-grow-1">
            <h5 class="mb-1"><?= ucfirst($item["pronombre"]) ?></h5>
            <small class="text-muted"><?= $item["prodetalle"] ?></small>

<div class="mt-2 d-flex align-items-center">
    <span class="me-2 fw-semibold">Cantidad:</span>

    <a href="index.php?control=carrito&accion=restar&id=<?= $item['idproducto'] ?>"
       class="btn btn-outline-secondary btn-sm">−</a>

    <span class="mx-2"><?= $item["cantidad"] ?></span>

    <a href="index.php?control=carrito&accion=sumar&id=<?= $item['idproducto'] ?>"
       class="btn btn-outline-secondary btn-sm">+</a>
</div>

        </div>

        <div class="text-end me-4">
            <strong>$<?= number_format($item["subtotal"], 2) ?></strong>
        </div>

        <a href="index.php?control=carrito&accion=quitar&id=<?= $item['idproducto'] ?>"
           class="btn btn-outline-danger btn-sm">
            <i class="bi bi-trash"></i>
        </a>

    </div>

<?php endforeach; ?>

</div>

<div class="text-end mt-4">
    <h3>Total: $<?= number_format($total, 2) ?></h3>
</div>

<div class="d-flex justify-content-between mt-4">

    <a href="index.php?control=producto&accion=listar" class="btn btn-outline-secondary">
        ← Seguir comprando
    </a>

    <div>
        <a href="index.php?control=carrito&accion=vaciar" class="btn btn-danger me-2">
            Vaciar carrito
        </a>

<a href="index.php?control=carrito&accion=finalizar" class="btn btn-success">
    Finalizar compra
</a>

    </div>

</div>

<?php endif; ?>
