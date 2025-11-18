<?php
require_once __DIR__ . "/../utils/seguridad.php";

class PanelControl {

    public function ver() {
        verificarLogin(); // solo logueados

        $rol = rolUsuario();

        include __DIR__ . "/../Vistas/estructura/cabecera.php";

        if ($rol == 'admin') {
            include __DIR__ . "/../Vistas/panelAdmin.php";
        } else {
            include __DIR__ . "/../Vistas/panelCliente.php";
        }

        include __DIR__ . "/../Vistas/estructura/pie.php";
    }
}
