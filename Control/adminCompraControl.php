<?php
require_once __DIR__ . "/../Modelo/compra.php";
require_once __DIR__ . "/../Modelo/compraitem.php";
require_once __DIR__ . "/../Modelo/compraestado.php";
require_once __DIR__ . "/../Modelo/producto.php";
require_once __DIR__ . "/session.php";
require_once __DIR__ . "/../Correo/Correo.php";

class AdminCompraControl {

    public function listar() {
        $session = new Session();

        if (!$session->validar() || $session->getRol() !== "admin") {
            header("Location: index.php?control=home");
            exit;
        }

        $compraModel = new Compra();
        $itemModel   = new CompraItem();
        $estadoModel = new CompraEstado();

        $compras = $compraModel->obtenerTodas();

        foreach ($compras as &$c) {
            $c["items"]  = $itemModel->obtenerPorCompra($c["idcompra"]);
            $c["estado"] = $estadoModel->estadoActual($c["idcompra"]);
        }

        include __DIR__ . "/../Vistas/estructura/cabecera.php";
        include __DIR__ . "/../Vistas/adminCompras.php";
        include __DIR__ . "/../Vistas/estructura/pie.php";
    }

    public function cambiarEstado() {

        $idcompra = $_GET["id"] ?? null;
        $nuevoEstado = intval($_GET["estado"] ?? null);

        if (!$idcompra || !$nuevoEstado) {
            header("Location: index.php?control=admincompra&accion=listar");
            exit;
        }

        $estadoModel = new CompraEstado();
        $itemModel   = new CompraItem();
        $productoModel = new Producto();

        $actual = $estadoModel->estadoActual($idcompra);

        // Bloquear cancelar después de enviado
        if ($nuevoEstado == 4 && $actual["idcompraestadotipo"] == 3) {
            header("Location: index.php?control=admincompra&accion=listar&err=noCancel");
            exit;
        }

        // ✅ Manejo de stock al aceptar
        if ($nuevoEstado == 2 && $actual["idcompraestadotipo"] != 2) {

            $items = $itemModel->obtenerPorCompra($idcompra);

            foreach ($items as $item) {

                if (!$productoModel->hayStock($item["idproducto"], $item["cicantidad"])) {
                    header("Location: index.php?control=admincompra&accion=listar&err=sinStock");
                    exit;
                }
            }

            foreach ($items as $item) {
                $productoModel->descontarStock($item["idproducto"], $item["cicantidad"]);
            }
        }

        // Cerrar estado anterior
        $estadoModel->cerrarEstadosPrevios($idcompra);

        // Registrar nuevo estado
        $estadoModel->agregarEstado($idcompra, $nuevoEstado);

        // Obtener datos para email
        $compraModel = new Compra();
        $compra = $compraModel->obtenerPorId($idcompra);

        // Enviar mail según estado (lo dejamos igual)
        // ...

        header("Location: index.php?control=admincompra&accion=listar");
        exit;
    }
}
