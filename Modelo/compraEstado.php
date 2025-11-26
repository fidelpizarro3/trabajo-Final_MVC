<?php
require_once __DIR__ . "/../configuracion.php";

class CompraEstado {

    public function agregarEstado($idcompra, $idestado) {
        $conexion = obtenerConexion();
        $sql = "INSERT INTO compraestado (idcompra, idcompraestadotipo, cefechaini)
                VALUES (?, ?, NOW())";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("ii", $idcompra, $idestado);
        return $stmt->execute();
    }

    public function cerrarEstadosPrevios($idcompra) {
        $conexion = obtenerConexion();
        $sql = "UPDATE compraestado
                SET cefechafin = NOW()
                WHERE idcompra = ? AND cefechafin IS NULL";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("i", $idcompra);
        return $stmt->execute();
    }

    public function estadoActual($idcompra) {
        $conexion = obtenerConexion();
        $sql = "SELECT ce.*, cet.cetdescripcion AS descripcion
                FROM compraestado ce
                JOIN compraestadotipo cet 
                    ON cet.idcompraestadotipo = ce.idcompraestadotipo
                WHERE ce.idcompra = ? AND ce.cefechafin IS NULL";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("i", $idcompra);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function historial($idcompra) {
        $conexion = obtenerConexion();
        $sql = "SELECT ce.*, cet.cetdescripcion AS descripcion
                FROM compraestado ce
                JOIN compraestadotipo cet 
                    ON cet.idcompraestadotipo = ce.idcompraestadotipo
                WHERE ce.idcompra = ?
                ORDER BY ce.cefechaini ASC";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("i", $idcompra);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
?>
