<h2 class="mb-4">Productos disponibles</h2>

<div class="row">

<?php foreach ($listaProductos as $p): ?>

    <?php  
        $img = "Vistas/img/" . ($p['proimagen'] ?: "sinimagen.png");
        if (!file_exists($img)) {
            $img = "https://via.placeholder.com/350x260?text=Sin+Imagen";
        }
    ?>

    <div class="col-md-4 mb-4">
        <div class="card shadow-sm h-100">

            <img src="<?= $img ?>" 
                 class="card-img-top"
                 style="height: 260px; object-fit: cover;">

            <div class="card-body text-center">
                <h5 class="card-title"><?= ucfirst($p['pronombre']) ?></h5>
                <p class="text-muted"><?= $p['prodetalle'] ?></p>

                <p class="fw-bold text-success fs-5">$<?= number_format($p['precio'], 2) ?></p>

                <!-- BOTÓN QUE ABRE EL MODAL -->
                <button class="btn btn-success w-100 btnModalCarrito"
                        data-id="<?= $p['idproducto'] ?>">
                    Agregar al carrito
                </button>
            </div>

        </div>
    </div>

<?php endforeach; ?>

</div>


<!-- ==================== MODAL ==================== -->
<div class="modal fade" id="modalCarrito" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

        <div class="modal-header">
            <h5 class="modal-title">Agregar al carrito</h5>
            <button class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body d-flex">

            <!-- Imagen -->
            <div style="width:45%">
                <img id="modalImg" src="" class="img-fluid rounded">
            </div>

            <!-- Info -->
            <div class="ms-4" style="width:55%">
                <h4 id="modalNombre"></h4>
                <p id="modalDetalle" class="text-muted"></p>

                <h5 class="text-success mt-2">$<span id="modalPrecio"></span></h5>

                <label class="fw-semibold mt-3">Cantidad:</label>
                <div class="input-group" style="width:150px;">
                    <button class="btn btn-outline-secondary" id="btnMenos">−</button>
                    <input type="text" id="inputCant" class="form-control text-center" value="1">
                    <button class="btn btn-outline-secondary" id="btnMas">+</button>
                </div>

                <button class="btn btn-success w-100 mt-4" id="btnConfirmar">
                    Confirmar y agregar
                </button>

            </div>
        </div>

    </div>
  </div>
</div>


<!-- ==================== SCRIPTS AJAX ==================== -->
<script>
$(document).ready(function(){

    let productoSeleccionado = null;

    // Abrir modal y cargar datos
    $(".btnModalCarrito").click(function(){

        let id = $(this).data("id");
        productoSeleccionado = id;

        $.ajax({
            url: "index.php?control=producto&accion=datosAjax&id=" + id,
            method: "GET",
            dataType: "json",
            success: function(p){

                $("#modalNombre").text(p.pronombre);
                $("#modalDetalle").text(p.prodetalle);
                $("#modalPrecio").text(Number(p.precio).toFixed(2));

                if (p.proimagen)
                    $("#modalImg").attr("src", "Vistas/img/" + p.proimagen);
                else
                    $("#modalImg").attr("src", "https://via.placeholder.com/350x260");

                $("#inputCant").val(1);

                let modal = new bootstrap.Modal(document.getElementById('modalCarrito'));
                modal.show();
            }
        });

    });


    // Controles de cantidad
    $("#btnMas").click(() => {
        let c = parseInt($("#inputCant").val());
        $("#inputCant").val(c + 1);
    });

    $("#btnMenos").click(() => {
        let c = parseInt($("#inputCant").val());
        if (c > 1) $("#inputCant").val(c - 1);
    });


    // Confirmar agregar al carrito
    $("#btnConfirmar").click(function(){

        let cant = parseInt($("#inputCant").val());

        $.ajax({
            url: "index.php?control=carrito&accion=agregar&id=" + productoSeleccionado + "&cant=" + cant,
            method: "GET",
            dataType: "json",
            success: function(resp){
                if(resp.ok){
                    $("#contadorCarrito").text(resp.cantidad);

                    let modal = bootstrap.Modal.getInstance(document.getElementById('modalCarrito'));
                    modal.hide();

                    // Notificación
                    alert("Producto agregado!");
                }
            }
        });

    });

});
</script>
