<h2 class="mb-4">Nuevo Producto</h2>

<form action="index.php?control=producto&accion=guardar" 
      method="POST" enctype="multipart/form-data" class="card p-4 shadow">

    <div class="mb-3">
        <label class="form-label">Nombre</label>
        <input type="text" name="nombre" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Detalle</label>
        <textarea name="detalle" class="form-control" required></textarea>
    </div>

    <div class="mb-3">
        <label class="form-label">Stock</label>
        <input type="number" name="stock" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Imagen</label>
        <input type="file" name="imagen" class="form-control">
    </div>

    <button class="btn btn-success">Guardar Producto</button>
</form>
