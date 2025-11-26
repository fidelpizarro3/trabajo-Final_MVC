<?php
require_once __DIR__ . "/../configuracion.php";

class Usuario {

    /* ==========================================
        BUSCAR USUARIO POR NOMBRE + VERIFICAR PASS
       ========================================== */
    public function buscarUsuario($nombre, $pass) {
        $conexion = obtenerConexion();

        $sql = "SELECT u.idusuario, u.usnombre, u.uspass, r.rodescripcion AS rol
                FROM usuario u
                JOIN usuariorol ur ON ur.idusuario = u.idusuario
                JOIN rol r ON r.idrol = ur.idrol
                WHERE u.usnombre = ?
                LIMIT 1";

        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("s", $nombre);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows === 0) {
            return false; // usuario no encontrado
        }

        $fila = $resultado->fetch_assoc();

        // Comparamos contraseña hasheada
        if (password_verify($pass, $fila['uspass'])) {
            return $fila;  // LOGIN OK
        }

        return false; // contraseña incorrecta
    }



    /* ==========================================
        INSERTAR NUEVO USUARIO + ASIGNAR ROL CLIENTE
       ========================================== */
    public function insertarUsuario($nombre, $email, $hash) {
    $conexion = obtenerConexion();

    // Verificar SI EL EMAIL YA EXISTE
    $sqlCheck = "SELECT idusuario FROM usuario WHERE usmail = ?";
    $stmtCheck = $conexion->prepare($sqlCheck);
    $stmtCheck->bind_param("s", $email);
    $stmtCheck->execute();
    $result = $stmtCheck->get_result();

    if ($result->num_rows > 0) {
        return false; // El email ya existe
    }

    // Insertar usuario (nombre puede repetirse)
    $sql = "INSERT INTO usuario (usnombre, usmail, uspass) VALUES (?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("sss", $nombre, $email, $hash);

    if (!$stmt->execute()) {
        return false;
    }

    // Obtener ID insertado
    $idusuario = $conexion->insert_id;

    // Asignar rol por defecto = cliente (idrol = 2)
    $sqlRol = "INSERT INTO usuariorol (idusuario, idrol) VALUES (?, 2)";
    $stmtRol = $conexion->prepare($sqlRol);
    $stmtRol->bind_param("i", $idusuario);
    $stmtRol->execute();

    return true;
}
/* ==========================================
    GUARDAR TOKEN DE RECORDAR USUARIO
   ========================================== */
public function guardarToken($idusuario, $token) {
    $conexion = obtenerConexion();

    $sql = "UPDATE usuario 
            SET ustoken = ?, 
                ustoken_expira = DATE_ADD(NOW(), INTERVAL 7 DAY)
            WHERE idusuario = ?";

    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("si", $token, $idusuario);
    return $stmt->execute();
}

/* ==========================================
    BUSCAR USUARIO POR TOKEN (AUTOLOGIN)
   ========================================== */
public function buscarPorToken($token) {
    $conexion = obtenerConexion();

    $sql = "SELECT u.idusuario, u.usnombre, r.rodescripcion AS rol
            FROM usuario u
            JOIN usuariorol ur ON u.idusuario = ur.idusuario
            JOIN rol r ON r.idrol = ur.idrol
            WHERE u.ustoken = ?
              AND u.ustoken_expira > NOW()
            LIMIT 1";

    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

/* ==========================================
    BORRAR TOKEN (LOGOUT)
   ========================================== */
public function borrarToken($idusuario) {
    $conexion = obtenerConexion();

    $sql = "UPDATE usuario 
            SET ustoken = NULL, ustoken_expira = NULL
            WHERE idusuario = ?";

    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $idusuario);
    return $stmt->execute();
}



}
