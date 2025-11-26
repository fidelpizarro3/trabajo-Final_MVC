<?php
require_once "configuracion.php";
require_once "Control/Session.php";

$control = $_GET['control'] ?? 'home';
$accion  = $_GET['accion'] ?? 'index';

switch ($control) {

    /* ===========================
       LOGIN
       =========================== */
    case 'login':
        require_once "Control/loginControl.php";
        $login = new LoginControl();

        switch ($accion) {
            case 'form':
                $login->form();
                break;

            case 'validar':
                $login->validar();
                break;

            case 'logout':
                $login->logout();
                break;

            case 'registro':
                $login->registroForm();
                break;

            case 'registrar':
                $login->registrarUsuario();
                break;

            default:
                $login->form();
        }
        break;



    /* ===========================
       PRODUCTOS
       =========================== */
    case 'producto':
        require_once "Control/productoControl.php";
        $p = new ProductoControl();

        switch ($accion) {

            case 'listar':
                $p->listar();
                break;

            case 'nuevo':
                $p->nuevo();
                break;

            case 'guardar':
                $p->guardar();
                break;

            case 'editar':
                $p->editar();
                break;

            case 'actualizar':
                $p->actualizar();
                break;

            case 'deshabilitar':
                $p->deshabilitar();
                break;

            case 'datosAjax':
                $p->datosAjax();
                break;

            default:
                $p->listar();
        }
        break;



    /* ===========================
       PANEL PRIVADO
       =========================== */
    case 'panel':
        require_once "Control/panelControl.php";
        $panel = new PanelControl();
        $panel->ver();
        break;



    /* ===========================
       CONTACTO
       =========================== */
    case 'contacto':
        include "Vistas/estructura/cabecera.php";
        include "Vistas/contacto.php";
        include "Vistas/estructura/pie.php";
        break;



    /* ===========================
       MENÚ DINÁMICO
       =========================== */
    case 'menu':
        require_once "Control/menuControl.php";
        $mc = new MenuControl();

        if ($accion == "listar")           $mc->listar();
        elseif ($accion == "nuevoForm")    $mc->nuevoForm();
        elseif ($accion == "nuevo")        $mc->nuevo();
        elseif ($accion == "deshabilitar") $mc->deshabilitar();
        break;



    /* ===========================
       CARRITO
       =========================== */
    case 'carrito':
        require_once "Control/carritoControl.php";
        $car = new CarritoControl();

        if     ($accion == "agregar")   $car->agregar();
        elseif ($accion == "ver")       $car->ver();
        elseif ($accion == "quitar")    $car->quitar();
        elseif ($accion == "vaciar")    $car->vaciar();
        elseif ($accion == "sumar")     $car->sumar();
        elseif ($accion == "restar")    $car->restar();
        elseif ($accion == "finalizar") $car->finalizar();
        break;



    /* ===========================
       COMPRAS DEL USUARIO
       =========================== */
    case 'compra':
        require_once "Control/compraControl.php";
        $cc = new CompraControl();

        if ($accion == "listar") {
            $cc->listar();
        }
        break;



    /* ===========================
       HOME PÚBLICA (DEFAULT)
       =========================== */
    case 'home':
    default:
        include "Vistas/estructura/cabecera.php";
        include "Vistas/home.php";
        include "Vistas/estructura/pie.php";
        break;


    case 'admincompra':
    require_once "Control/adminCompraControl.php";
    $ac = new AdminCompraControl();

    if ($accion == "listar")       $ac->listar();
    elseif ($accion == "cambiarEstado") $ac->cambiarEstado();
    break;

}


?>
