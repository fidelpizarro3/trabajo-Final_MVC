<?php
require_once __DIR__ . "/../configuracion.php";

class Menu {

    /**
     * Devuelve todos los ítems de menú habilitados para un rol dado
     * (admin, cliente, deposito, etc.)
     */
    public function obtenerMenusPorRol($rol) {
        $conexion = obtenerConexion();

        $sql = "SELECT m.idmenu, m.menombre, m.medescripcion, m.idpadre
                FROM menu m
                JOIN menurol mr ON mr.idmenu = m.idmenu
                JOIN rol r ON r.idrol = mr.idrol
                WHERE r.rodescripcion = ?
                  AND m.medeshabilitado IS NULL
                ORDER BY m.idpadre ASC, m.idmenu ASC";

        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("s", $rol);
        $stmt->execute();
        $res = $stmt->get_result();

        $lista = [];
        while ($fila = $res->fetch_assoc()) {
            $lista[] = $fila;
        }

        return $lista;
    }

    /**
     * Devuelve todos los menús habilitados (para el ABM de menús)
     */
    public function obtenerTodos() {
        $conexion = obtenerConexion();

        $sql = "SELECT * FROM menu WHERE medeshabilitado IS NULL";
        $res = $conexion->query($sql);

        $lista = [];
        if ($res && $res->num_rows > 0) {
            while ($f = $res->fetch_assoc()) {
                $lista[] = $f;
            }
        }
        return $lista;
    }

    /**
     * Crea un ítem de menú y lo asocia a un rol
     */
    public function crear($nombre, $ruta, $rol) {
        $conexion = obtenerConexion();

        // 1) Crear el ítem de menú
        $sql = "INSERT INTO menu (menombre, medescripcion) VALUES (?, ?)";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("ss", $nombre, $ruta);
        $stmt->execute();

        $idmenu = $conexion->insert_id;

        // 2) Obtener idrol según la descripción
        $sqlRol = "SELECT idrol FROM rol WHERE rodescripcion = ?";
        $stmtRol = $conexion->prepare($sqlRol);
        $stmtRol->bind_param("s", $rol);
        $stmtRol->execute();
        $resRol = $stmtRol->get_result();
        $datoRol = $resRol->fetch_assoc();

        if ($datoRol) {
            $idrol = $datoRol["idrol"];

            // 3) Asociar menú con rol
            $sql2 = "INSERT INTO menurol (idmenu, idrol) VALUES (?, ?)";
            $stmt2 = $conexion->prepare($sql2);
            $stmt2->bind_param("ii", $idmenu, $idrol);
            $stmt2->execute();
        }
    }

    /**
     * Deshabilita (no borra) un ítem de menú
     */
    public function deshabilitar($idmenu) {
        $conexion = obtenerConexion();

        $sql = "UPDATE menu 
                SET medeshabilitado = NOW() 
                WHERE idmenu = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("i", $idmenu);
        $stmt->execute();
    }
}
