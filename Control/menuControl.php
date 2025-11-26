<?php
require_once __DIR__ . "/../Modelo/menu.php";
require_once __DIR__ . "/Session.php";

class MenuControl {

    /** Verifica que haya sesión y que el rol sea admin */
    private function requerirAdmin() {
        $session = new Session();

        if (!$session->validar() || $session->getRol() !== "admin") {
            header("Location: index.php?control=home");
            exit;
        }

        return $session;
    }

    public function listar() {
        $this->requerirAdmin();

        $menu = new Menu();
        $items = $menu->obtenerTodos();

        include __DIR__ . "/../Vistas/estructura/cabecera.php";
        include __DIR__ . "/../Vistas/menuListar.php";
        include __DIR__ . "/../Vistas/estructura/pie.php";
    }

    public function nuevoForm() {
        $this->requerirAdmin();

        include __DIR__ . "/../Vistas/estructura/cabecera.php";
        include __DIR__ . "/../Vistas/menuNuevo.php";
        include __DIR__ . "/../Vistas/estructura/pie.php";
    }

    public function nuevo() {
        $this->requerirAdmin();

        $nombre = $_POST['nombre'] ?? '';
        $ruta   = $_POST['ruta']   ?? '';
        $rol    = $_POST['rol']    ?? '';

        if ($nombre !== '' && $ruta !== '' && $rol !== '') {
            $menu = new Menu();
            $menu->crear($nombre, $ruta, $rol);
        }

        header("Location: index.php?control=menu&accion=listar");
        exit;
    }

    public function deshabilitar() {
        $this->requerirAdmin();

        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

        if ($id > 0) {
            $menu = new Menu();
            $menu->deshabilitar($id);
        }

        header("Location: index.php?control=menu&accion=listar");
        exit;
    }
}
