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

                <!-- BOTÓN CON AJAX -->
                <button class="btn btn-success w-100 btnAgregarCarrito"
                        data-id="<?= $p['idproducto'] ?>">
                    Agregar al carrito
                </button>
            </div>

        </div>
    </div>

<?php endforeach; ?>

</div>

<!-- AJAX PARA CARRITO -->
<script>
$(document).ready(function(){

    $(".btnAgregarCarrito").click(function(){
        let id = $(this).data("id");

        $.ajax({
            url: "index.php?control=carrito&accion=agregar&id=" + id,
            method: "GET",
            dataType: "json",
            success: function(resp){
                if(resp.ok){
                    $("#contadorCarrito").text(resp.cantidad);
                }
            }
        });
    });

});
</script>
