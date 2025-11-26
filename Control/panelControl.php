<?php
require_once __DIR__ . "/session.php";

class PanelControl {

    public function ver() {

        $session = new Session();

        // 1) Validar sesión activa
        if (!$session->activa()) {
            header("Location: index.php?control=login&accion=form");
            exit;
        }

        // 2) Validar que sea ADMIN
        if ($session->getRol() !== 'admin') {
            // Acceso denegado
            include __DIR__ . "/../Vistas/estructura/cabecera.php";
            echo "<h2 style='color:red'>Acceso denegado</h2>";
            echo "<p>No tenés permiso para acceder a esta sección.</p>";
            include __DIR__ . "/../Vistas/estructura/pie.php";
            exit;
        }

        // 3) Permitir acceso a la vista admin
        include __DIR__ . "/../Vistas/estructura/cabecera.php";

        // Habilitar acceso a panelAdmin.php
        define("ACCESO_PERMITIDO", true);

        include __DIR__ . "/../Vistas/panelAdmin.php";
        include __DIR__ . "/../Vistas/estructura/pie.php";
    }
}
