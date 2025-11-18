<?php

class ProductoControl {

    public function index() {
        $this->listar();
    }

    public function listar() {
        require_once __DIR__ . "/../Modelo/producto.php";
        $producto = new Producto();

        $listaProductos = $producto->listarTodos();

        include __DIR__ . "/../Vistas/estructura/cabecera.php";
        include __DIR__ . "/../Vistas/productosListar.php";
        include __DIR__ . "/../Vistas/estructura/pie.php";
    }
}
