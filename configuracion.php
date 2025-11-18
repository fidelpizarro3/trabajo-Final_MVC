<?php
// configuracion.php

$HOST = "localhost";
$BASE = "bdcarritocompras";
$USUARIO = "root";
$CLAVE = "";   

function obtenerConexion() {
    global $HOST, $BASE, $USUARIO, $CLAVE;

    $conexion = new mysqli($HOST, $USUARIO, $CLAVE, $BASE);

    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    $conexion->set_charset("utf8");
    return $conexion;
}
