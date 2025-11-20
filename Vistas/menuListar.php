<h2 class="mb-4 fw-bold">Administración del Menú</h2>

<a class="btn btn-primary mb-3" href="index.php?control=menu&accion=nuevoForm">
    + Nuevo ítem de menú
</a>

<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Ruta</th>
            <th>Acciones</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($items as $m): ?>
            <tr>
                <td><?= $m['idmenu'] ?></td>
                <td><?= $m['menombre'] ?></td>
                <td><?= $m['medescripcion'] ?></td>

                <td>
                    <a class="btn btn-danger btn-sm"
                        href="index.php?control=menu&accion=deshabilitar&id=<?= $m['idmenu'] ?>">
                        Deshabilitar
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
