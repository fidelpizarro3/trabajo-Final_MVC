<?php
require_once __DIR__ . "/../configuracion.php";

class Producto {

    /* ============================================================
       LISTAR TODOS LOS PRODUCTOS
    ============================================================ */
    public function listarTodos() {
        $conexion = obtenerConexion();

        $sql = "SELECT idproducto, pronombre, prodetalle, procantstock, proimagen 
                FROM producto";

        $res = $conexion->query($sql);

        $lista = [];
        if ($res && $res->num_rows > 0) {
            while ($fila = $res->fetch_assoc()) {
                $lista[] = $fila;
            }
        }
        return $lista;
    }


    /* ============================================================
       BUSCAR PRODUCTO POR ID
    ============================================================ */
    public function buscarPorId($id) {
        $conexion = obtenerConexion();

        $sql = "SELECT * FROM producto WHERE idproducto = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }


    /* ============================================================
       INSERTAR PRODUCTO
    ============================================================ */
    public function insertar($nombre, $detalle, $stock, $imagenNombre) {
        $conexion = obtenerConexion();

        $sql = "INSERT INTO producto (pronombre, prodetalle, procantstock, proimagen)
                VALUES (?, ?, ?, ?)";

        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("ssis", $nombre, $detalle, $stock, $imagenNombre);

        return $stmt->execute();
    }


    /* ============================================================
       ACTUALIZAR PRODUCTO
    ============================================================ */
    public function actualizar($id, $nombre, $detalle, $stock, $nuevaImagen) {
    $conexion = obtenerConexion();

    // Si NO se subió nueva imagen → mantener la actual
    if ($nuevaImagen === null) {
        $sql = "UPDATE producto
                SET pronombre = ?, prodetalle = ?, procantstock = ?
                WHERE idproducto = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("ssii", $nombre, $detalle, $stock, $id);

    } else {
        $sql = "UPDATE producto
                SET pronombre = ?, prodetalle = ?, procantstock = ?, proimagen = ?
                WHERE idproducto = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("ssisi", $nombre, $detalle, $stock, $nuevaImagen, $id);
    }

    return $stmt->execute();
}



    /* ============================================================
       ELIMINAR PRODUCTO
    ============================================================ */
    public function eliminar($id) {
        $conexion = obtenerConexion();

        $sql = "DELETE FROM producto WHERE idproducto = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("i", $id);

        return $stmt->execute();
    }
}
