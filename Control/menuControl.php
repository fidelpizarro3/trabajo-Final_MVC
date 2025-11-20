<?php
require_once __DIR__ . "/../Modelo/menu.php";
require_once __DIR__ . "/../Control/Session.php";

class MenuControl {

    public function listar() {
        $session = new Session();
        if ($session->getRol() !== "admin") {
            die("Acceso denegado");
        }

        $menu = new Menu();
        $items = $menu->obtenerTodos();

        include __DIR__ . "/../Vistas/estructura/cabecera.php";
        include __DIR__ . "/../Vistas/menuListar.php";
        include __DIR__ . "/../Vistas/estructura/pie.php";
    }

    public function nuevoForm() {
        include __DIR__ . "/../Vistas/estructura/cabecera.php";
        include __DIR__ . "/../Vistas/menuNuevo.php";
        include __DIR__ . "/../Vistas/estructura/pie.php";
    }

    public function nuevo() {
        $nombre = $_POST['nombre'];
        $ruta   = $_POST['ruta'];
        $rol    = $_POST['rol'];

        $menu = new Menu();
        $menu->crear($nombre, $ruta, $rol);

        header("Location: index.php?control=menu&accion=listar");
        exit;
    }

    public function deshabilitar() {
        $id = $_GET['id'];

        $menu = new Menu();
        $menu->deshabilitar($id);

        header("Location: index.php?control=menu&accion=listar");
        exit;
    }
}
