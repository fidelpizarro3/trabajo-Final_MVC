<?php
// utils/seguridad.php

function iniciarSesion() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}

function usuarioLogueado() {
    iniciarSesion();
    return isset($_SESSION['idusuario']);
}

function rolUsuario() {
    iniciarSesion();
    return isset($_SESSION['rol']) ? $_SESSION['rol'] : null;
}

function verificarLogin() {
    iniciarSesion();
    if (!usuarioLogueado()) {
        header("Location: index.php?control=login&accion=form");
        exit();
    }
}

function verificarAdmin() {
    iniciarSesion();
    if (!usuarioLogueado() || rolUsuario() !== 'admin') {
        echo "<p>No tiene permisos para acceder a esta sección.</p>";
        exit();
    }
}
