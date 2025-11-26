<?php

class Session {

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Inicia la sesión guardando usuario, password, idusuario y rol.
     */
    public function iniciar($usuario, $psw, $idusuario = null, $rol = null) {
        $_SESSION['usuario']   = $usuario;
        $_SESSION['password']  = $psw;
        $_SESSION['idusuario'] = $idusuario;
        $_SESSION['rol']       = $rol;   // ej: 'admin', 'cliente', 'deposito'
    }

    /**
     * Valida si la sesión actual tiene usuario y password cargados.
     */
    public function validar() {
        return isset($_SESSION['usuario']) && isset($_SESSION['password']);
    }

    /** Alias de validar() */
    public function activa() {
        return $this->validar();
    }

    public function getUsuario() {
        return $_SESSION['usuario'] ?? null;
    }

    public function getIdUsuario() {
        return $_SESSION['idusuario'] ?? null;
    }

    public function getRol() {
        return $_SESSION['rol'] ?? null;
    }

    /**
     * Cierra la sesión correctamente.
     */
    public function cerrar() {
        $_SESSION = [];
        session_destroy();
    }
}
