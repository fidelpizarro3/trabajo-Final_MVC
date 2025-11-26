<?php
require_once __DIR__ . "/../configuracion.php";

class Compra {

    public function crearCompra($idusuario, $total) {

        $conexion = obtenerConexion();

        $sql = "INSERT INTO compra (idusuario, comtotal, comfecha)
                VALUES (?, ?, NOW())";

        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("id", $idusuario, $total);

        if (!$stmt->execute()) {
            return false;
        }

        return $conexion->insert_id;
    }

    public function obtenerPorId($id) {

        $conexion = obtenerConexion();

        $sql = "SELECT c.*, u.usnombre, u.usmail
                FROM compra c
                JOIN usuario u ON u.idusuario = c.idusuario
                WHERE c.idcompra = ?";

        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }

    public function obtenerTodas() {

        $conexion = obtenerConexion();

        $sql = "SELECT c.idcompra, u.usnombre, c.comtotal, c.comfecha
                FROM compra c
                JOIN usuario u ON u.idusuario = c.idusuario
                ORDER BY c.idcompra DESC";

        return $conexion->query($sql)->fetch_all(MYSQLI_ASSOC);
    }

    public function obtenerPorUsuario($idusuario) {

        $conexion = obtenerConexion();

        $sql = "SELECT * FROM compra 
                WHERE idusuario = ? 
                ORDER BY idcompra DESC";

        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("i", $idusuario);
        $stmt->execute();

        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

}
?>
