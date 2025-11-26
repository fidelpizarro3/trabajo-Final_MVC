<h2 class="mb-4">Listado de Productos</h2>

<a class="btn btn-primary mb-3" href="index.php?control=producto&accion=nuevo">
    + Nuevo Producto
</a>

<div class="row">
<?php foreach ($listaProductos as $p): ?>
    
    <?php 
        // Seguridad: evitar errores si precio no existe
        $precio = isset($p['precio']) ? $p['precio'] : 0; 
    ?>

    <div class="col-md-4 mb-4">
        <div class="card shadow-sm h-100">

            <!-- Imagen -->
            <?php if ($p['proimagen']): ?>
                <img src="Vistas/img/<?= $p['proimagen'] ?>" 
                     class="card-img-top" style="height: 220px; object-fit: cover;">
            <?php else: ?>
                <img src="https://via.placeholder.com/350x200?text=Sin+Imagen" 
                     class="card-img-top">
            <?php endif; ?>

            <div class="card-body">

                <h5 class="card-title"><?= $p['pronombre'] ?></h5>
                <p class="card-text"><?= $p['prodetalle'] ?></p>

                <span class="badge bg-primary mb-2">
                    Stock: <?= $p['procantstock'] ?>
                </span>

                <p class="text-success fw-bold fs-5 mb-3">
                    $<?= number_format($precio, 2) ?>
                </p>

                <!-- BOTONES SOLO ADMIN -->
                <div class="d-grid gap-2 mt-3">
                    <a href="index.php?control=producto&accion=editar&id=<?= $p['idproducto'] ?>" 
                       class="btn btn-warning btn-sm">
                        Editar
                    </a>

                    <a href="index.php?control=producto&accion=deshabilitar&id=<?= $p['idproducto'] ?>"
                       class="btn btn-danger btn-sm"
                       onclick="return confirm('¿Seguro que querés deshabilitar este producto?');">
                        Deshabilitar
                    </a>
                </div>

            </div>
        </div>
    </div>

<?php endforeach; ?>
</div>
