<?php
require_once __DIR__ . "/../configuracion.php";

class CompraItem {

    public function insertarItem($idcompra, $idproducto, $cantidad, $precio) {

        $conexion = obtenerConexion();

        $sql = "INSERT INTO compraitem (idcompra, idproducto, cicantidad, citprecio)
                VALUES (?, ?, ?, ?)";

        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("iiid", $idcompra, $idproducto, $cantidad, $precio);

        return $stmt->execute();
    }

    public function obtenerPorCompra($idcompra) {

        $conexion = obtenerConexion();

        $sql = "SELECT ci.*, p.pronombre, p.prodetalle, p.proimagen
                FROM compraitem ci
                JOIN producto p ON p.idproducto = ci.idproducto
                WHERE ci.idcompra = ?";

        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("i", $idcompra);
        $stmt->execute();

        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

}
?>
