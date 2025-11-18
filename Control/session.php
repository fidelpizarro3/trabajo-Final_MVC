<?php

class Session {

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function iniciar($usuario, $rol) {
        $_SESSION['usuario'] = $usuario;
        $_SESSION['rol'] = $rol;
    }

    public function validar() {
        return isset($_SESSION['usuario']);
    }

    public function activa() {
        return $this->validar();
    }

    public function getUsuario() {
        return $_SESSION['usuario'] ?? null;
    }

    public function getRol() {
        return $_SESSION['rol'] ?? null;
    }

    public function cerrar() {
        session_destroy();
    }
}
