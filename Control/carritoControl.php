<?php
require_once __DIR__ . "/../Modelo/producto.php";

class CarritoControl {

    /** ====================================================
     *  AGREGAR AL CARRITO (con cantidad y AJAX)
     *  ==================================================== */
    public function agregar() {

        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = [];
        }

        // ID del producto
        $id = $_GET['id'] ?? null;

        // Cantidad enviada (si no viene ponemos 1)
        $cant = isset($_GET['cant']) ? intval($_GET['cant']) : 1;

        if (!$id || $cant < 1) {
            echo json_encode(["ok" => false, "msg" => "Datos inválidos"]);
            return;
        }

        // Si ya existe el producto en el carrito → sumamos
        if (isset($_SESSION['carrito'][$id])) {
            $_SESSION['carrito'][$id] += $cant;
        } else {
            $_SESSION['carrito'][$id] = $cant;
        }

        // Total de productos en el carrito
        $total = array_sum($_SESSION['carrito']);

        echo json_encode([
            "ok" => true,
            "cantidad" => $total
        ]);
        return;
    }



    /** ====================================================
     *  VER CARRITO
     *  ==================================================== */
    public function ver() {

        // Cargar productos del carrito
        $items = [];
        $producto = new Producto();

        if (isset($_SESSION['carrito'])) {
            foreach ($_SESSION['carrito'] as $id => $cant) {
                $p = $producto->buscarPorId($id);

                if ($p) {
                    $p["cantidad"] = $cant;
                    $p["subtotal"] = $cant * 1; // TODO: cuando tengamos precio real
                    $items[] = $p;
                }
            }
        }

        // Vista
        include __DIR__ . "/../Vistas/estructura/cabecera.php";
        include __DIR__ . "/../Vistas/carritoVer.php";
        include __DIR__ . "/../Vistas/estructura/pie.php";
    }



    /** ====================================================
     *  ELIMINAR UN PRODUCTO DEL CARRITO
     *  ==================================================== */
    public function quitar() {

        $id = $_GET['id'] ?? null;

        if ($id && isset($_SESSION['carrito'][$id])) {
            unset($_SESSION['carrito'][$id]);
        }

        header("Location: index.php?control=carrito&accion=ver");
    }



    /** ====================================================
     *  VACIAR TODO EL CARRITO
     *  ==================================================== */
    public function vaciar() {
        unset($_SESSION['carrito']);
        header("Location: index.php?control=carrito&accion=ver");
    }
}
