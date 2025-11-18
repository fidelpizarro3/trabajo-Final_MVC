<?php
require_once "configuracion.php";
require_once "utils/seguridad.php";

$control = isset($_GET['control']) ? $_GET['control'] : 'home';
$accion  = isset($_GET['accion']) ? $_GET['accion'] : 'index';

switch ($control) {

    case 'producto':
        require_once "Control/productoControl.php";
        $controlador = new ProductoControl();
        if ($accion == 'listar') {
            $controlador->listar();
        } else {
            $controlador->index();
        }
        break;

case 'login':
    require_once "Control/loginControl.php";
    $login = new LoginControl();

    if ($accion == 'form') {
        $login->form();
    } elseif ($accion == 'validar') {
        $login->validar();
    } elseif ($accion == 'logout') {
        $login->logout();
    } elseif ($accion == 'registro') {
        $login->registroForm();
    } elseif ($accion == 'registrarUsuario') {
        $login->registrarUsuario();
    }
    break;


    case 'panel':
        require_once "Control/panelControl.php";
        $panel = new PanelControl();
        if ($accion == 'ver') {
            $panel->ver();
        }
        break;

    case 'home':
    default:
        include "Vistas/estructura/cabecera.php";
        include "Vistas/home.php";
        include "Vistas/estructura/pie.php";
        break;
}
