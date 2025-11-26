<?php
require_once __DIR__ . "/../Modelo/usuario.php";
require_once __DIR__ . "/../Control/Session.php";

class LoginControl {

    /** 
     * Muestra el formulario de login
     */
    public function form() {
        include __DIR__ . "/../Vistas/estructura/cabecera.php";
        include __DIR__ . "/../Vistas/loginForm.php";
        include __DIR__ . "/../Vistas/estructura/pie.php";
    }

    /**
     * Muestra el formulario de registro
     */
    public function registroForm() {
        include __DIR__ . "/../Vistas/estructura/cabecera.php";
        include __DIR__ . "/../Vistas/registroForm.php";
        include __DIR__ . "/../Vistas/estructura/pie.php";
    }

    /**
     * Valida usuario y contraseña
     */
    public function validar() {

        $nombre = $_POST['usuario'] ?? "";
        $pass   = $_POST['clave'] ?? "";

        // Validación básica
        if ($nombre === "" || $pass === "") {
            include __DIR__ . "/../Vistas/estructura/cabecera.php";
            echo "<h3>Debe completar usuario y contraseña</h3>";
            echo "<a href='index.php?control=login&accion=form'>Volver</a>";
            include __DIR__ . "/../Vistas/estructura/pie.php";
            return;
        }

        // Buscar usuario en la BD
        $modeloUsuario = new Usuario();
        $datos = $modeloUsuario->buscarUsuario($nombre, $pass);

        $session = new Session();

        if ($datos != false) {

            // Guardar toda la data del usuario
            $session->iniciar(
                $datos['usnombre'],   // usuario
                $pass,                // sin hash
                $datos['idusuario'],  // ID
                $datos['rol']         // admin / cliente
            );

            //  Redirecciones según rol
            if ($datos['rol'] === "admin") {
                header("Location: index.php?control=panel&accion=ver");
            } else {
                header("Location: index.php?home.php");
            }

            exit;
        }

        // Error
        include __DIR__ . "/../Vistas/estructura/cabecera.php";
        echo "<h3>Error: usuario o contraseña incorrectos</h3>";
        echo "<a href='index.php?control=login&accion=form'>Volver</a>";
        include __DIR__ . "/../Vistas/estructura/pie.php";
    }


    /**
     * Cierra sesión
     */
    public function logout() {
        $session = new Session();
        $session->cerrar();
        header("Location: index.php");
        exit;
    }

    /**
     * Procesa formulario de registro
     */
    public function registrarUsuario() {

        $nombre = $_POST['usuario'] ?? "";
        $email  = $_POST['email']   ?? "";
        $clave  = $_POST['clave']   ?? "";

        if ($nombre === "" || $email === "" || $clave === "") {
            include __DIR__ . "/../Vistas/estructura/cabecera.php";
            echo "<h3>Todos los campos son obligatorios.</h3>";
            echo "<a href='index.php?control=login&accion=registro'>Volver</a>";
            include __DIR__ . "/../Vistas/estructura/pie.php";
            return;
        }

        $modeloUsuario = new Usuario();
        $hash = password_hash($clave, PASSWORD_DEFAULT);

        $ok = $modeloUsuario->insertarUsuario($nombre, $email, $hash);

        if ($ok) {
            header("Location: index.php?control=login&accion=form&msg=registrado");
            exit;
        } else {
            include __DIR__ . "/../Vistas/estructura/cabecera.php";
            echo "<h3>Error al registrar. El usuario puede ya existir.</h3>";
            echo "<a href='index.php?control=login&accion=registro'>Volver</a>";
            include __DIR__ . "/../Vistas/estructura/pie.php";
        }
    }
}
