<?php
require_once __DIR__ . "/session.php";

class PanelControl {

    public function ver() {

        // Módulo de autenticación 
        $session = new Session();

        // Validar sesión activa
        if (!$session->validar()) {
            header("Location: index.php?control=login&accion=form");
            exit;
        }

        // Obtener rol del usuario
        $rol = $session->getRol();

        include __DIR__ . "/../Vistas/estructura/cabecera.php";

        if ($rol == 'admin') {
            include __DIR__ . "/../Vistas/panelAdmin.php";
        } else {
            include __DIR__ . "/../Vistas/panelCliente.php";
        }

        include __DIR__ . "/../Vistas/estructura/pie.php";
    }
}
