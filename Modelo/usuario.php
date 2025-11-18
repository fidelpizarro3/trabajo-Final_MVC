<?php
require_once __DIR__ . "/../configuracion.php";

class Usuario {

    public function buscarUsuario($nombre, $pass) {
        $conexion = obtenerConexion();

        // Buscamos solo por nombre de usuario
        $sql = "SELECT u.idusuario, u.usnombre, u.uspass, r.rodescripcion AS rol
                FROM usuario u
                JOIN usuariorol ur ON ur.idusuario = u.idusuario
                JOIN rol r        ON r.idrol = ur.idrol
                WHERE u.usnombre = '$nombre'
                LIMIT 1";

        $resultado = $conexion->query($sql);
        $devuelve = null;

        if ($resultado && $resultado->num_rows > 0) {
            $fila = $resultado->fetch_assoc();

            // Verificamos la contraseña hasheada
            if (password_verify($pass, $fila['uspass'])) {
                $devuelve = $fila;   // login OK
            }
        }
        
        // Si no encontró usuario o el password no coincide
        return $devuelve;
    }

    public function insertarUsuario($nombre, $email, $hash) {
    $conexion = obtenerConexion();

    // IMPORTANTE: no manejamos roles acá, solo usuario base
    $sql = "INSERT INTO usuario (usnombre, usmail, uspass)
            VALUES ('$nombre', '$email', '$hash')";
        $retorno = false;
    if ($conexion->query($sql)) {

        // obtener el ID del usuario insertado
        $idusuario = $conexion->insert_id;
        
        // asignar rol por defecto = cliente
        $sqlRol = "INSERT INTO usuariorol (idusuario, idrol) VALUES ($idusuario, 2)";
        $conexion->query($sqlRol);

        $retorno = true;
    }

    return $retorno;
}

}
