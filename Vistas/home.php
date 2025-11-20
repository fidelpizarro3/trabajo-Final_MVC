<?php
require_once __DIR__ . "/../Control/Session.php";
$session = new Session();
?>

<div class="container mt-5">

    <div class="row justify-content-center">
        <div class="col-md-8 text-center">

            <h1 class="fw-bold mb-4">Bienvenido a Mates Store</h1>

            <p class="text-muted fs-5">
                La tienda online donde vas a encontrar los mejores mates, bombillas y accesorios.
            </p>

            <?php if (!$session->activa()): ?>
            <!-- SOLO se muestra si NO está logeado -->
            <div class="mt-4">
                <a href="index.php?control=login&accion=form" class="btn btn-primary btn-lg mx-2">
                    Iniciar Sesión
                </a>

                <a href="index.php?control=login&accion=registro" class="btn btn-outline-primary btn-lg mx-2">
                    Registrarse
                </a>
            </div>
            <?php endif; ?>

            <hr class="my-5">

            <h3 class="fw-semibold mb-4">Productos destacados</h3>
        </div>
    </div>

    <!-- Tarjetas de productos -->
    <div class="row justify-content-center">

        <!-- PRODUCTO 1 -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm h-100">
                <div class="ratio ratio-1x1">
                    <img src="Vistas/img/mate1.jpg" class="card-img-top object-fit-cover" alt="Mate Imperial">
                </div>

                <div class="card-body text-center">
                    <h5 class="card-title">Mate Imperial</h5>
                    <p class="card-text text-muted">Hecho en cuero, premium artesanal</p>

                    <a href="index.php?control=producto&accion=listar" class="btn btn-success w-100">
                        Ver productos
                    </a>
                </div>
            </div>
        </div>

        <!-- PRODUCTO 2 -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm h-100">
                <div class="ratio ratio-1x1">
                    <img src="Vistas/img/mate2.webp" class="card-img-top object-fit-cover" alt="Mate Camionero">
                </div>

                <div class="card-body text-center">
                    <h5 class="card-title">Mate Camionero</h5>
                    <p class="card-text text-muted">Calabaza seleccionada premium</p>
                    <a href="index.php?control=producto&accion=listar" class="btn btn-success w-100">
                        Ver productos
                    </a>
                </div>
            </div>
        </div>

        <!-- PRODUCTO 3 -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm h-100">
                <div class="ratio ratio-1x1">
                    <img src="Vistas/img/mate3.jpg" class="card-img-top object-fit-cover" alt="Mate Torpedo">
                </div>

                <div class="card-body text-center">
                    <h5 class="card-title">Mate Torpedo</h5>
                    <p class="card-text text-muted">Moderno y resistente</p>

                    <a href="index.php?control=producto&accion=listar" class="btn btn-success w-100">
                        Ver productos
                    </a>
                </div>
            </div>
        </div>

    </div>

</div>
