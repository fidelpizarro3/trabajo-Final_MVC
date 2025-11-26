<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . "/../Modelo/producto.php";

class CarritoControl {

    /* ====================================================
     *  AGREGAR AL CARRITO (AJAX)
     *  ==================================================== */
    public function agregar() {

        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = [];
        }

        $id   = $_GET['id'] ?? null;
        $cant = isset($_GET['cant']) ? intval($_GET['cant']) : 1;

        if (!$id || $cant < 1) {
            echo json_encode(["ok" => false, "msg" => "Datos inválidos"]);
            return;
        }

        if (isset($_SESSION['carrito'][$id])) {
            $_SESSION['carrito'][$id] += $cant;
        } else {
            $_SESSION['carrito'][$id] = $cant;
        }

        $totalProductos = array_sum($_SESSION['carrito']);

        echo json_encode([
            "ok"       => true,
            "cantidad" => $totalProductos
        ]);
    }


    /* ====================================================
     *  VER CARRITO
     *  ==================================================== */
    public function ver() {

        $items = [];
        $producto = new Producto();

        if (isset($_SESSION['carrito'])) {

            foreach ($_SESSION['carrito'] as $id => $cant) {

                $p = $producto->buscarPorId($id);

                if ($p) {
                    $precio = floatval($p["precio"]);

                    $p["cantidad"] = $cant;
                    $p["subtotal"] = $precio * $cant;

                    $items[] = $p;
                }
            }
        }

        include __DIR__ . "/../Vistas/estructura/cabecera.php";
        include __DIR__ . "/../Vistas/carritoVer.php";
        include __DIR__ . "/../Vistas/estructura/pie.php";
    }


    /* ====================================================
     *  SUMAR / RESTAR
     *  ==================================================== */
    public function sumar() {

        $id = $_GET['id'] ?? null;

        if ($id && isset($_SESSION['carrito'][$id])) {
            $_SESSION['carrito'][$id]++;
        }

        header("Location: index.php?control=carrito&accion=ver");
        exit;
    }

    public function restar() {

        $id = $_GET['id'] ?? null;

        if ($id && isset($_SESSION['carrito'][$id])) {

            if ($_SESSION['carrito'][$id] > 1) {
                $_SESSION['carrito'][$id]--;
            } else {
                unset($_SESSION['carrito'][$id]);
            }
        }

        header("Location: index.php?control=carrito&accion=ver");
        exit;
    }


    /* ====================================================
     *  QUITAR UN PRODUCTO
     *  ==================================================== */
    public function quitar() {

        $id = $_GET['id'] ?? null;

        if ($id && isset($_SESSION['carrito'][$id])) {
            unset($_SESSION['carrito'][$id]);
        }

        header("Location: index.php?control=carrito&accion=ver");
        exit;
    }


    /* ====================================================
     *  VACIAR CARRITO
     *  ==================================================== */
    public function vaciar() {
        unset($_SESSION['carrito']);
        header("Location: index.php?control=producto&accion=listar");
        exit;
    }


    /* ====================================================
     *  FINALIZAR COMPRA
     *  ==================================================== */
    public function finalizar() {

        if (!isset($_SESSION['carrito']) || empty($_SESSION['carrito'])) {
            header("Location: index.php?control=carrito&accion=ver");
            exit;
        }

        require_once __DIR__ . "/../Modelo/producto.php";
        require_once __DIR__ . "/../Modelo/compra.php";
        require_once __DIR__ . "/../Modelo/compraitem.php";
        require_once __DIR__ . "/../Modelo/compraestado.php";
        require_once __DIR__ . "/../Control/Session.php";
        require_once __DIR__ . "/../Correo/Correo.php";

        $session = new Session();
        $idusuario     = $session->getIdUsuario();
        $usuarioNombre = $session->getUsuario();

        // 1) Calcular total
        $productoModel = new Producto();
        $total = 0;

        foreach ($_SESSION['carrito'] as $idproducto => $cant) {
            $prod = $productoModel->buscarPorId($idproducto);
            if ($prod) {
                $total += floatval($prod['precio']) * $cant;
            }
        }

        // 2) Crear compra
        $compraModel = new Compra();
        $idCompra = $compraModel->crearCompra($idusuario, $total);

        // 3) Registrar ítems
        $itemModel = new CompraItem();

        foreach ($_SESSION['carrito'] as $idproducto => $cant) {
            $prod   = $productoModel->buscarPorId($idproducto);
            $precio = floatval($prod['precio']);
            // guardamos precio unitario
            $itemModel->insertarItem($idCompra, $idproducto, $cant, $precio);
        }

        // 4) Estado inicial: 1 = "Aceptada" (según tu tabla compraestadotipo)
        $estadoModel = new CompraEstado();
        $estadoModel->cerrarEstadosPrevios($idCompra);
        $estadoModel->agregarEstado($idCompra, 1);

        // 5) Armar detalle HTML para el correo
        $detalle = "<h2>Compra #$idCompra aceptada</h2>";
        $detalle .= "<p>Hola <strong>$usuarioNombre</strong>, recibimos tu compra.</p>";
        $detalle .= "<h3>Detalle:</h3><ul>";

        foreach ($_SESSION['carrito'] as $idproducto => $cant) {
            $prod = $productoModel->buscarPorId($idproducto);
            $precio = floatval($prod['precio']);
            $sub = $precio * $cant;

            $detalle .= "<li>{$prod['pronombre']} (x$cant) - $" . number_format($sub, 2) . "</li>";
        }

        $detalle .= "</ul><p><strong>Total: $" . number_format($total, 2) . "</strong></p>";

        // 6) Obtener email del usuario
        $conexion = obtenerConexion();
        $sql  = "SELECT usmail FROM usuario WHERE idusuario = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("i", $idusuario);
        $stmt->execute();
        $fila = $stmt->get_result()->fetch_assoc();
        $emailUsuario = $fila['usmail'] ?? "";

        // 7) Enviar mail con Laminas
        if ($emailUsuario !== "") {
            Correo::enviarCompraAceptada($emailUsuario, $usuarioNombre, $idCompra, $detalle);
        }

        // 8) Vaciar carrito
        unset($_SESSION['carrito']);

        // 9) Redirigir a Mis Compras
        header("Location: index.php?control=compra&accion=listar");
        exit;
    }
}
?>
