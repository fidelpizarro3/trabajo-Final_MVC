<?php
if (!defined('ACCESO_PERMITIDO')) {
    die("Acceso directo NO permitido.");
}
?>


<h2 class="fw-bold mb-4">Panel de Administrador</h2>

<p class="text-muted fs-5">
    Bienvenido, aquí podés gestionar toda la tienda.
</p>

<div class="row mt-4">

    <!-- Gestionar Usuarios -->
    <div class="col-md-6 mb-3">
        <div class="card shadow-sm">
            <div class="card-body">
                <h4 class="card-title">Usuarios y Roles</h4>
                <p class="card-text">Alta, baja y modificación de usuarios, asignar roles.</p>
                <a href="#" class="btn btn-outline-primary disabled">Próximamente</a>
            </div>
        </div>
    </div>

    <!-- Gestionar Productos -->
    <div class="col-md-6 mb-3">
        <div class="card shadow-sm">
            <div class="card-body">
                <h4 class="card-title">Productos</h4>
                <p class="card-text">Administrar productos, stock e imágenes.</p>
                <a href="index.php?control=producto&accion=listar" class="btn btn-primary">
                    Gestionar productos
                </a>
            </div>
        </div>
    </div>

    <!-- Gestionar Menú Dinámico
    <div class="col-md-6 mb-3">
        <div class="card shadow-sm">
            <div class="card-body">
                <h4 class="card-title">Menú dinámico</h4>
                <p class="card-text">
                    Crear nuevos ítems de menú, asignar roles y deshabilitar opciones.
                </p>
                <a href="index.php?control=menu&accion=listar" class="btn btn-success">
                    Administrar menú
                </a>
            </div>
        </div>
    </div> -->

    <!-- Estado de compras -->
<div class="col-md-6 mb-3">
    <div class="card shadow-sm">
        <div class="card-body">
            <h4 class="card-title">Estado de compras</h4>
            <p class="card-text">Aceptar, enviar o cancelar compras.</p>
            <a href="index.php?control=admincompra&accion=listar" class="btn btn-warning">
                Ver compras
            </a>
        </div>
    </div>
</div>


</div>

<div class="mt-4">
    <a href="index.php?control=login&accion=logout" class="btn btn-danger">
        Cerrar sesión
    </a>
</div>
