<?php

// $datos contiene el producto traído desde ProductoControl->editar()
?>

<h2 class="mb-4">Editar Producto</h2>

<form action="index.php?control=producto&accion=actualizar" 
      method="POST" enctype="multipart/form-data" 
      class="card p-4 shadow-sm">

    <input type="hidden" name="id" value="<?= $datos['idproducto'] ?>">

    <!-- Nombre -->
    <div class="mb-3">
        <label class="form-label fw-semibold">Nombre</label>
        <input type="text" name="nombre" class="form-control" required
               value="<?= $datos['pronombre'] ?>">
    </div>

    <!-- Detalle -->
    <div class="mb-3">
        <label class="form-label fw-semibold">Detalle</label>
        <textarea name="detalle" rows="3" class="form-control" required>
            <?= $datos['prodetalle'] ?>
        </textarea>
    </div>

    <!-- Stock -->
    <div class="mb-3">
        <label class="form-label fw-semibold">Stock</label>
        <input type="number" name="stock" class="form-control" min="0" required
               value="<?= $datos['procantstock'] ?>">
    </div>

    <!-- Precio -->
    <div class="mb-3">
        <label class="form-label fw-semibold">Precio</label>
        <input type="number" step="0.01" name="precio" 
               value="<?= $datos['precio'] ?>" 
               class="form-control" required>
    </div>

    <!-- Imagen actual -->
    <div class="mb-3">
        <label class="form-label fw-semibold">Imagen actual</label>
        <br>

        <?php if (!empty($datos['proimagen'])): ?>
            <img src="Vistas/img/<?= $datos['proimagen'] ?>" 
                 width="180" class="rounded border">
        <?php else: ?>
            <p class="text-muted">Sin imagen</p>
        <?php endif; ?>
    </div>

    <!-- Nueva imagen -->
    <div class="mb-3">
        <label class="form-label fw-semibold">Nueva imagen (opcional)</label>
        <input type="file" name="imagen" class="form-control">
    </div>

    <!-- Botones -->
    <div class="d-flex justify-content-between mt-4">
        <a href="index.php?control=producto&accion=listar" 
           class="btn btn-secondary">
            Volver
        </a>

        <button type="submit" class="btn btn-primary">
            Guardar cambios
        </button>
    </div>

</form>
