<?php
require_once __DIR__ . "/../configuracion.php";

class Menu {

    public function obtenerMenusPorRol($rol)
    {
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

    public function obtenerTodos() {
    $conexion = obtenerConexion();
    $sql = "SELECT * FROM menu WHERE medeshabilitado IS NULL";
    $res = $conexion->query($sql);

    $lista = [];
    while ($f = $res->fetch_assoc()) {
        $lista[] = $f;
    }
    return $lista;
}

public function crear($nombre, $ruta, $rol) {
    $conexion = obtenerConexion();

    // 1) Crear ítem en tabla menu
    $sql = "INSERT INTO menu (menombre, medescripcion) VALUES (?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ss", $nombre, $ruta);
    $stmt->execute();

    $idmenu = $conexion->insert_id;

    // 2) Asignar rol
    $sql2 = "INSERT INTO menurol (idmenu, idrol)
                VALUES ($idmenu, (SELECT idrol FROM rol WHERE rodescripcion = '$rol'))";
    $conexion->query($sql2);
}

public function deshabilitar($idmenu) {
    $conexion = obtenerConexion();
    $sql = "UPDATE menu SET medeshabilitado = NOW() WHERE idmenu = $idmenu";
    $conexion->query($sql);
}

}
