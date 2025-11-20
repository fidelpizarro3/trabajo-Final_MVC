<h2 class="fw-bold mb-4">Nuevo ítem de menú</h2>

<form method="POST" action="index.php?control=menu&accion=nuevo">
    <div class="mb-3">
        <label class="form-label">Nombre del Menú</label>
        <input type="text" name="nombre" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Ruta</label>
        <input type="text" name="ruta" class="form-control" placeholder="Ej: producto&accion=listar" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Rol que lo ve</label>
        <select name="rol" class="form-control">
            <option value="admin">Administrador</option>
            <option value="cliente">Cliente</option>
        </select>
    </div>

    <button type="submit" class="btn btn-success">Crear</button>
    <a href="index.php?control=menu&accion=listar" class="btn btn-secondary">Volver</a>
</form>
