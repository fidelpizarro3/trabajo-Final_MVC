<?php
require_once __DIR__ . "/../../Control/Session.php";
require_once __DIR__ . "/../../Modelo/menu.php";

$session = new Session();
$menu = new Menu();

$rol = $session->getRol() ?? "publico";

// MENÚ DINÁMICO
if ($session->activa()) {
    $items = $menu->obtenerMenusPorRol($rol);
} else {
    // menú para visitante
    $items = [
        ["menombre" => "Inicio",      "medescripcion" => "home"],
        ["menombre" => "Productos",   "medescripcion" => "producto&accion=listar"],
        ["menombre" => "Contacto",    "medescripcion" => "contacto"],
        ["menombre" => "Ingresar",    "medescripcion" => "login&accion=form"],
        ["menombre" => "Registrarse", "medescripcion" => "login&accion=registro"]
    ];
}

// construye rutas correctas
function armarRuta($desc) {

    if ($desc === "home") return "index.php";

    if ($desc === "contacto") return "index.php?control=contacto";

    // si tiene formato control&accion=...
    if (strpos($desc, "&") !== false) {
        return "index.php?control=" . $desc;
    }

    return "index.php?control=" . $desc;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Tienda de Mates</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="Vistas/css/estilos.css">

    <!-- jQuery necesario para AJAX -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

</head>

<body>

<nav class="navbar navbar-expand-lg bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php">Mates Store</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuApp">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="menuApp">
            <ul class="navbar-nav ms-auto">

                <!-- MENU DINÁMICO -->
                <?php foreach ($items as $item): ?>
                    <?php if ($item['menombre'] !== "Mis compras"): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= armarRuta($item['medescripcion']) ?>">
                                <?= $item['menombre'] ?>
                            </a>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>

                <?php if ($session->activa()): ?>

                    <!-- CARRITO -->
                    <li class="nav-item ms-3">
                        <a class="nav-link fw-semibold" 
                           href="index.php?control=carrito&accion=ver">
                            🛒 Carrito (<span id="contadorCarrito">
                                <?= isset($_SESSION['carrito']) ? array_sum($_SESSION['carrito']) : 0 ?>
                            </span>)
                        </a>
                    </li>

                    <!-- DROPDOWN USUARIO -->
                    <li class="nav-item dropdown ms-3">
                        <a class="nav-link dropdown-toggle text-primary fw-semibold"
                           href="#" role="button" data-bs-toggle="dropdown">
                           Hola, <?= $session->getUsuario(); ?>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="index.php?control=compra&accion=listar">
                                    Mis compras
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- LOGOUT -->
                    <li class="nav-item">
                        <a class="nav-link text-danger fw-bold"
                           href="index.php?control=login&accion=logout">
                            <i class="bi bi-box-arrow-right"></i> Salir
                        </a>
                    </li>

                <?php endif; ?>

            </ul>
        </div>
    </div>
</nav>

<div class="container mt-4">
