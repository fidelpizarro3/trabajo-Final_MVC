<?php
require_once __DIR__ . "/../Modelo/compra.php";
require_once __DIR__ . "/../Modelo/compraitem.php";
require_once __DIR__ . "/../Modelo/compraestado.php";
require_once __DIR__ . "/Session.php";

class CompraControl {

    public function listar() {
    $session = new Session();

    if (!$session->validar()) {
        header("Location: index.php?control=login&accion=form");
        exit;
    }

    $idusuario = $session->getIdUsuario();

    $compraModel = new Compra();
    $itemModel   = new CompraItem();
    $estadoModel = new CompraEstado();

    $compras = $compraModel->obtenerPorUsuario($idusuario);

    foreach ($compras as &$c) {
        $c["items"]      = $itemModel->obtenerPorCompra($c["idcompra"]);
        $c["estado"]     = $estadoModel->estadoActual($c["idcompra"]);
        $c["historial"]  = $estadoModel->historial($c["idcompra"]); // ✅ NUEVO
    }

    include __DIR__ . "/../Vistas/estructura/cabecera.php";
    include __DIR__ . "/../Vistas/misCompras.php";
    include __DIR__ . "/../Vistas/estructura/pie.php";
}

}
?>
