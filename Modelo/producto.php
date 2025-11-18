<?php
require_once __DIR__ . "/../configuracion.php";

class Producto {

    public function listarTodos() {
        $conexion = obtenerConexion();

        
        $sql = "SELECT idproducto, pronombre, prodetalle, procantstock FROM producto";

        $resultado = $conexion->query($sql);

        $productos = [];

        if ($resultado && $resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $productos[] = $fila;
            }
        }

        $conexion->close();
        return $productos;
    }
}
