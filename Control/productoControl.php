<?php

class ProductoControl {

    public function index() {
        $this->listar();
    }

    public function listar() {
        require_once __DIR__ . "/../Modelo/producto.php";
        require_once __DIR__ . "/../Control/Session.php";

        $producto = new Producto();
        $listaProductos = $producto->listarTodos();

        $session = new Session();
        $rol = $session->getRol();

        include __DIR__ . "/../Vistas/estructura/cabecera.php";

        if ($rol === "admin") {
            // Vista ADMIN
            include __DIR__ . "/../Vistas/productosListar.php";
        } else {
            // Vista CLIENTE
            include __DIR__ . "/../Vistas/productosCliente.php";
        }

        include __DIR__ . "/../Vistas/estructura/pie.php";
    }

    public function nuevo() {
        include __DIR__ . "/../Vistas/estructura/cabecera.php";
        include __DIR__ . "/../Vistas/productoNuevo.php";
        include __DIR__ . "/../Vistas/estructura/pie.php";
    }

    public function guardar() {
        require_once __DIR__ . "/../Modelo/producto.php";

        $nombre  = $_POST['nombre'];
        $detalle = $_POST['detalle'];
        $stock   = $_POST['stock'];
        $precio  = $_POST['precio'];

        // Imagen
        $imagenNombre = null;

        if (!empty($_FILES['imagen']['name'])) {
            $imagenNombre = time() . "_" . $_FILES['imagen']['name'];
            $ruta = __DIR__ . "/../Vistas/img/" . $imagenNombre;
            move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta);
        }

        $producto = new Producto();
        $producto->insertar($nombre, $detalle, $stock,$precio, $imagenNombre);

        header("Location: index.php?control=producto&accion=listar");
    }

    public function editar() {
    require_once __DIR__ . "/../Modelo/producto.php";

    $id = $_GET['id'];

    $producto = new Producto();
    $datos = $producto->buscarPorId($id);

    include __DIR__ . "/../Vistas/estructura/cabecera.php";
    include __DIR__ . "/../Vistas/productoEditar.php";
    include __DIR__ . "/../Vistas/estructura/pie.php";
}

public function actualizar() {
    require_once __DIR__ . "/../Modelo/producto.php";

    $id      = $_POST['id'];
    $nombre  = $_POST['nombre'];
    $detalle = $_POST['detalle'];
    $stock   = $_POST['stock'];
    $precio  = $_POST['precio'];

    // Manejo de imagen
    $nuevaImagen = null;

    if (!empty($_FILES['imagen']['name'])) {
        $nuevaImagen = time() . "_" . $_FILES['imagen']['name'];
        $ruta = __DIR__ . "/../Vistas/img/" . $nuevaImagen;
        move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta);
    }

    $producto = new Producto();
    $producto->actualizar($id, $nombre, $detalle, $stock,$precio, $nuevaImagen);

    header("Location: index.php?control=producto&accion=listar");
    exit;
}


public function deshabilitar() {
    require_once __DIR__ . "/../Modelo/producto.php";

    $id = $_GET['id'];

    $producto = new Producto();
    $producto->eliminar($id);

    header("Location: index.php?control=producto&accion=listar");
}


public function datosAjax() {

    require_once __DIR__ . "/../Modelo/producto.php";
    $p = new Producto();
    $id = $_GET['id'] ?? 0;

    $prod = $p->buscarPorId($id);

    echo json_encode($prod);
}

}