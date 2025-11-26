<?php
require_once __DIR__ . "/../configuracion.php";

class Producto
{

    public function listarTodos()
    {
        $conexion = obtenerConexion();
        $sql = "SELECT idproducto, pronombre, prodetalle, procantstock, precio, proimagen FROM producto";
        $res = $conexion->query($sql);
        $lista = [];
        if ($res && $res->num_rows > 0) {
            while ($fila = $res->fetch_assoc()) {
                $lista[] = $fila;
            }
        }
        return $lista;
    }

    public function buscarPorId($id)
    {
        $conexion = obtenerConexion();
        $sql = "SELECT * FROM producto WHERE idproducto = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function insertar($nombre, $detalle, $stock, $precio, $imagenNombre)
    {
        $conexion = obtenerConexion();
        $sql = "INSERT INTO producto (pronombre, prodetalle, procantstock, precio, proimagen)
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("ssids", $nombre, $detalle, $stock, $precio, $imagenNombre);
        return $stmt->execute();
    }

    public function actualizar($id, $nombre, $detalle, $stock, $precio, $nuevaImagen)
    {
        $conexion = obtenerConexion();
        if ($nuevaImagen === null) {
            $sql = "UPDATE producto 
                    SET pronombre = ?, prodetalle = ?, procantstock = ?, precio = ?
                    WHERE idproducto = ?";
            $stmt = $conexion->prepare($sql);
            $stmt->bind_param("ssidi", $nombre, $detalle, $stock, $precio, $id);
        } else {
            $sql = "UPDATE producto 
                    SET pronombre = ?, prodetalle = ?, procantstock = ?, precio = ?, proimagen = ?
                    WHERE idproducto = ?";
            $stmt = $conexion->prepare($sql);
            $stmt->bind_param("ssidsi", $nombre, $detalle, $stock, $precio, $nuevaImagen, $id);
        }
        return $stmt->execute();
    }

    /* ============================================================
       NUEVO: Verificar si hay stock suficiente
    ============================================================ */
    public function hayStock($idproducto, $cantidadNecesaria)
    {
        $producto = $this->buscarPorId($idproducto);
        return $producto && $producto["procantstock"] >= $cantidadNecesaria;
    }

    /* ============================================================
       NUEVO: Descontar stock del producto
    ============================================================ */
    public function descontarStock($idproducto, $cantidad)
    {
        $conexion = obtenerConexion();
        $sql = "UPDATE producto 
                SET procantstock = procantstock - ?
                WHERE idproducto = ? AND procantstock >= ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("iii", $cantidad, $idproducto, $cantidad);
        return $stmt->execute();
    }
}
